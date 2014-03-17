<?php

class AdminSuggestATripController extends BaseController {

	/**
	 * Suggest a trip Repository
	 *
	 * @var Suggest a trip
	 */
	protected $suggest;

	/**
	 * Constructor
	 */
	public function __construct(SuggestATrip $suggest)
	{
		/*
		 * Set Suggest a trip Instance
		 */

		$this->suggest = $suggest;

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
		$suggest = $this->suggest;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'email', 'destiny']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$suggest = $suggest->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('email')) {
			$suggest = $suggest->where('email', 'like', '%'. Input::get('email') .'%');
		}

		if (Input::has('destiny')) {
			$suggest = $suggest->where('destiny', 'like', '%'. Input::get('destiny') .'%');
		}

		if (Input::has('suggestion')) {
			$suggest = $suggest->where('suggestion', 'like', '%'. Input::get('suggestion') .'%');
		}

		/*
		 * Finally Obj
		 */
		$suggest = $suggest->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
			'email' => Input::get('email'),
			'destiny' => Input::get('destiny'),
			'suggestion' => Input::get('suggestion'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.suggest.list', compact('sort', 'order', 'pag', 'suggest'));
	}

	/**
	 * Display Suggest a trip Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.suggest.create');
	}

	/**
	 * Create Suggest a trip.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'destiny' => 'required',
        	'name' => 'required',
        	'email' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->suggest->create($inputs);

			return Redirect::route('admin.suggest');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.suggest.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Suggest a trip Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$suggest = $this->suggest->find($id);

		if (is_null($suggest))
		{
			return Redirect::route('admin.suggest');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.suggest.edit', compact('suggest'));
	}

	/**
	 * Update Suggest a trip.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::all();

		$rules = [
        	'destiny' => 'required',
        	'name' => 'required',
        	'email' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$suggest = $this->suggest->find($id);

			if ($suggest)
			{
				$suggest->update($inputs);
			}

			return Redirect::route('admin.suggest');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.suggest.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Suggest a trip Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$suggest = $this->suggest->find($id);

		if (is_null($suggest))
		{
			return Redirect::route('admin.suggest');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta sugestão de viagem? Esta operação não poderá ser desfeita.');

		$data['suggestData'] = $suggest->toArray();
		$data['suggestArray'] = null;

		foreach ($data['suggestData'] as $key => $value) {
			$data['suggestArray'][Lang::get('suggest.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.suggest.delete', $data);
	}

	/**
	 * Delete Suggest a trip.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->suggest->find($id)->delete();

		Session::flash('success', 'Sugestão de viagem excluída com sucesso.');

		return Redirect::route('admin.suggest');
	}

}
