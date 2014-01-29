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
		$offer = $this->offer->with(['ngo', 'partner'])->select(['id', 'title', 'destiny', 'starts_on', 'ends_on']);

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
		// if (Input::has('name')) {
		// 	$offer = $offer->where('name', 'like', '%'. Input::get('name') .'%');
		// }

		// if (Input::has('description')) {
		// 	$offer = $offer->where('description', 'like', '%'. Input::get('description') .'%');
		// }

		/*
		 * Finally Obj
		 */
		$offer = $offer
			->orderBy($sort, $order)
			->paginate($pag)->appends([
				'sort' => $sort,
				'order' => $order,
				// 'name' => Input::get('name'),
				// 'description' => Input::get('description'),
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
			return Redirect::route('admin.offer.edit');
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

}
