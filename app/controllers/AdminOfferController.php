<?php

class AdminOfferController extends BaseController {

	/**
	 * Offer Repository
	 *
	 * @var Offer
	 */
	protected $offer;
	protected $offer_option;

	/**
	 * Constructor
	 */
	public function __construct(Offer $offer, OfferOption $offer_option)
	{
		/*
		 * Set Offer Instance
		 */

		$this->offer = $offer;
		$this->offer_option = $offer_option;

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


    	$pag = Input::get('pag', 25);

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
			->select(['id', 'title', 'destiny_id', 'starts_on', 'ends_on'])
			->whereExists(function($query){
                if (Input::has('destiny')) {
					$query->select(DB::raw(1))
	                      ->from('destinies')
						  ->whereRaw('destinies.id = offers.destiny_id')
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
				'starts_on' => Input::get('starts_on'),
				'ends_on' => Input::get('ends_on'),
				'pag' => Input::get('pag'),
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

        $s3access = Configuration::get('s3access');
        $s3secret = Configuration::get('s3secret');
        $s3region = Configuration::get('s3region');
        $s3bucket = Configuration::get('s3bucket');

        $s3 = Aws\S3\S3Client::factory(
            array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
        );

        $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

        $postObject = new Aws\S3\Model\PostObject($s3, $s3bucket, array('acl' => 'public-read', 'Cache-Control' => 'max-age=315360000', 'Content-Type' => '^', 'Expires' => $expires, "success_action_status" => "200"));
        $form = $postObject->prepareData()->getFormInputs();
        $policy = $form['policy'];
        $signature = $form['signature'];
        $uid = uniqid();

		$this->layout->page_title = 'Criar Oferta';
		$this->layout->content = View::make('admin.offer.create', compact('policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Create Offer.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		if ($this->offer->passes() && $this->offer_option->passes(Input::get('offer_options')[0]))
		{
            // Cria a oferta
			$offer = $this->offer->create(Input::all());

            if($offer->id){
                // Insere as opções de venda
                $offer_options = Input::get('offer_options');

                $price_original = 0;
                $price_with_discount = 0;
                $percent_off = 0;


                foreach($offer_options as $k => $opt){
                    $opt['display_order'] = $k;
                    $opt['offer_id'] = $offer->id;
                    //$offer_option = $offer->offer_option()->create($opt);
                    $offer_option = $this->offer_option->create($opt);
                    // Verifica os valores de $offer_option para pegar o menor e depois jogar na oferta
                    if($price_with_discount == 0 || $offer_option->price_with_discount < $price_with_discount){
                        $price_original = $offer_option->price_original;
                        $price_with_discount = $offer_option->price_with_discount;
                        $percent_off = $offer_option->percent_off;
                    }
                }
                // Atualiza a oferta com os menores valores de offer_option
                $offer->price_original = $price_original;
                $offer->price_with_discount = $price_with_discount;
                $offer->percent_off = $percent_off;

                // Update na oferta
                $offer->save();
            }





            return Redirect::route('admin.offer.create')
                ->withInput()
                ->withErrors($this->offer->errors());

			//return Redirect::route('admin.offer');
		}

        Session::flash('error', 'Erro ao salvar oferta no banco de dados. Verifique o formulário abaixo e tente novamente.');

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.offer.create')
			->withInput()
			->withErrors($this->offer->errors());
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

	// /**
	//  * Delete Offer.
	//  *
	//  * @return Response
	//  */

	// public function postDelete($id)
	// {
	// 	$this->offer->find($id)->delete();

	// 	Session::flash('success', 'Papel de usuário excluído com sucesso.');

	// 	return Redirect::route('admin.offer');
	// }

	// public function getClearfield($id, $field)
	// {
	// 	$offer = $this->offer->find($id);

	// 	if (is_null($offer) || !isset($field))
	// 	{
	// 		return Redirect::route('admin.offer.edit', $id);
	// 	}

	// 	$toDelete = $offer->{$field};

	// 	if (is_array($toDelete)) {
	// 		foreach ($toDelete as $item) {
	// 			$path = public_path() . $item;
	// 			if (File::exists($path)) {
	// 				File::delete($path);
	// 			}
	// 		}
	// 	}

	// 	$offer->{$field} = null;
	// 	$offer->save();

	// 	Session::flash('success', 'O campo '. $field .' pode ser editado agora.');

	// 	return Redirect::route('admin.offer.edit', $id);
	// }

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
