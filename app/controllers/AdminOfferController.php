<?php

class AdminOfferController extends BaseController {

	/**
	 * Offer Repository
	 *
	 * @var Offer
	 */
	protected $offer;

	/**
	 * Constructor
	 */
	public function __construct(Offer $offer)
	{
		/*
		 * Set Offer Instance
		 */

		$this->offer = $offer;

		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$offer = $this->offer;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('id')) {
			$offer = $offer->where('id', Input::get('id'));
		}

		if (Input::has('title')) {
			$offer = $offer->where('title', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('genre_id')) {
			$offer = $offer->where('genre_id', Input::get('genre_id'));
		}

		if (Input::has('in_pre_booking')) {
			$offer = $offer->where('in_pre_booking', Input::get('in_pre_booking'));
		}

		if (Input::has('starts_on')) {
			$offer = $offer->where('starts_on', '>=', Input::get('starts_on'));
		}

		if (Input::has('ends_on')) {
			$offer = $offer->where('ends_on', '<=', Input::get('ends_on'));
		}

		/*
		 * Finally Obj
		 */
		$offer = $offer
			->with(['partner', 'destiny'])
			// ->select(['id', 'title', 'starts_on', 'ends_on', 'in_pre_booking'])
			->whereExists(function($query){
                if (Input::has('destiny')) {
					$query->select(DB::raw(1))
	                      ->from('destinies')
						  ->whereRaw('destinies.id = offers.destiniy_id')
						  ->whereRaw('destinies.name LIKE "%'.Input::get('destiny').'%"');
				}

            })
			->orderBy($sort, $order)
			->paginate($pag)->appends([
				'sort' => $sort,
				'order' => $order,
				'id' => Input::get('id'),
				'destiny' => Input::get('destiny'),
				'title' => Input::get('title'),
				'genre_id' => Input::get('genre_id'),
				'in_pre_booking' => Input::get('in_pre_booking'),
				'starts_on' => Input::get('starts_on'),
				'ends_on' => Input::get('ends_on'),
			]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.list', compact('sort', 'order', 'pag', 'offer'));
	}

	/**
	 * Display Offer Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.offer.create');
	}

	/**
	 * Create Offer.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->offer->create($inputs);

			return Redirect::route('admin.offer');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.offer.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Offer Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$offer = $this->offer->with(['ngo', 'partner'])->find($id);

		if (is_null($offer))
		{
			return Redirect::route('admin.offer');
		}


		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.offer.edit', compact('offer'));
	}

	/**
	 * Update Offer.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::all();

	    $validation = Validator::make($inputs, Offer::$rules);

		if ($validation->passes())
		{
			$offer = $this->offer->find($id);

			if ($offer)
			{
				$cover_img = ImageUpload::createFrom(Input::file('cover_img'), Config::get('upload.offer'));

				$inputs['cover_img'] = $cover_img;

				$offer->update($inputs);
			}

			return Redirect::route('admin.offer');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.offer.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Offer Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$offer = $this->offer->find($id);

		if (is_null($offer))
		{
			return Redirect::route('admin.offer');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta offeruração? Esta operação não poderá ser desfeita.');

		$data['offerData'] = $offer->toArray();
		$data['offerArray'] = null;

		foreach ($data['offerData'] as $key => $value) {
			$data['offerArray'][Lang::get('offer.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.offer.delete', $data);
	}

	/**
	 * Delete Offer.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->offer->find($id)->delete();

		Session::flash('success', 'Papel de usuário excluído com sucesso.');

		return Redirect::route('admin.offer');
	}

	public function getClearfield($id, $field)
	{
		$offer = $this->offer->find($id);

		if (is_null($offer) || !isset($field))
		{
			return Redirect::route('admin.offer.edit', $id);
		}

		$toDelete = $offer->{$field};

		if (is_array($toDelete)) {
			foreach ($toDelete as $item) {
				$path = public_path() . $item;
				if (File::exists($path)) {
					File::delete($path);
				}
			}
		}

		$offer->{$field} = null;
		$offer->save();

		Session::flash('success', 'O campo '. $field .' pode ser editado agora.');

		return Redirect::route('admin.offer.edit', $id);
	}

	/**
	 * Update Offer.in_pre_booking.
	 *
	 * @return Response
	 */

	public function getInPreBooking($id, $in)
	{
		/*
		 * Permuration
		 */
		$offer = $this->offer->find($id);

		if ($offer)
		{
			$offer->in_pre_booking = $in;
			$offer->save();
		}

		return Redirect::route('admin.offer');
	}

	public function getSort(){
		/*
		 * Obj
		 */
		$offerObj = $this->offer;

		/*
		 * Finally Obj
		 */
		$offers = $offerObj->orderBy('display_order', 'asc')
						   // ->where('ends_on', '>=', date("Y-m-d H:i:s"))
						   ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.sort', compact('offers'));
	}

	public function postSort(){
		$offers = Input::get('offers');

		foreach ($offers as $display_order => $id) {
			$o = Offer::find($id);
			$o->display_order = $display_order;
			$o->save();
		}

		return Redirect::route('admin.offer.sort');
	}

	public function getSortPreBooking(){
		/*
		 * Obj
		 */
		$offerObj = $this->offer;

		/*
		 * Finally Obj
		 */
		$offers = $offerObj->orderBy('pre_booking_order', 'asc')
						   ->where('in_pre_booking', 1)
						   ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.sort_pre_booking', compact('offers'));
	}

	public function postSortPreBooking(){
		$offers = Input::get('offers');

		foreach ($offers as $pre_booking_order => $id) {
			$o = Offer::find($id);
			$o->pre_booking_order = $pre_booking_order;
			$o->save();
		}

		return Redirect::route('admin.offer.sort_pre_booking');
	}

	public function getSortComment($id){
		/*
		 * Obj
		 */
		$offer = $this->offer->with(['comment'])->where('id', $id)->first();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.sort_comment', compact('offer'));
	}

	public function postSortComment($offer_id){
		$comments = Input::get('comments');

		foreach ($comments as $display_order => $id) {
			$c = Comment::find($id);
			$c->display_order = $display_order;
			$c->save();
		}

		return Redirect::route('admin.offer.sort_comment', $offer_id);
	}

	public function getNewsletter(){
		$offers = $this->offer/*->where('starts_on', '<=', date('Y-m-d H:i:s'))
		             		   ->where('ends_on', '>=', date('Y-m-d H:i:s'))*/->get();
		/*
		* Layout / View
		*/
		$this->layout->content = View::make('admin.offer.newsletter', compact('offers'));
	}

	public function postNewsletter(){
		$offers = Input::get('offers');
		$selected_offers = Input::get('selected_offers');

		$ids = array();

		foreach ($offers as $display_order => $id) {
			if(isset($selected_offers[$id])){
				$ids[] = $id;
			}
		}

		$offers = DB::select(DB::raw('SELECT o.*, oo.price_original,oo.price_with_discount FROM offers o LEFT JOIN offers_options oo ON o.id = oo.offer_id WHERE oo.id = (SELECT id FROM offers_options WHERE offer_id = o.id ORDER BY price_with_discount LIMIT 1) AND o.id IN ('.implode(',', $ids).') GROUP BY o.id ORDER BY FIELD(o.id, ' . implode(',', $ids) . ') ASC'));

		// $html = Response::view('email.newsletter_'.Input::get('system'), compact('offers'));

		// print('<pre>');
		// print_r($offers);
		// print('</pre>'); die();

		/*
		* Layout / View
		*/

		return View::make('emails.newsletter_'.Input::get('system'), compact('offers'));
		// $this->layout->content = View::make('admin.newsletter.html', compact('html'));
	}

}
