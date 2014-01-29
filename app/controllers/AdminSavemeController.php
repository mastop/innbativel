<?php

class AdminSavemeController extends BaseController {

	/**
	 * Saveme Repository
	 *
	 * @var Saveme
	 */
	protected $saveme;

	/**
	 * Constructor
	 */
	public function __construct(Saveme $saveme)
	{
		/*
		 * Set Permission Instance
		 */

		$this->saveme = $saveme;

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
		$saveme = $this->saveme;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$saveme = $saveme->where('title', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('geocode')) {
			$saveme = $saveme->where('geocode', 'like', '%'. Input::get('geocode') .'%');
		}

		/*
		 * Finally Obj
		 */
		$saveme = $saveme->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'title' => Input::get('title'),
			'geocode' => Input::get('geocode'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.saveme.list', compact('sort', 'order', 'pag', 'saveme'));
	}

	/**
	 * Display Permission Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.saveme.create');
	}

	/**
	 * Create Permission.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'title' => 'required',
        	'geocode' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->saveme->create($inputs);

			return Redirect::route('admin.saveme');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.saveme.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Permission Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$saveme = $this->saveme->find($id);

		if (is_null($saveme))
		{
			return Redirect::route('admin.saveme');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.saveme.edit', compact('saveme'));
	}

	/**
	 * Update Permission.
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
        	'title' => 'required',
        	'geocode' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$saveme = $this->saveme->find($id);

			if ($saveme)
			{
				$saveme->update($inputs);
			}

			return Redirect::route('admin.saveme');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.saveme.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Permission Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$saveme = $this->saveme->find($id);

		if (is_null($saveme))
		{
			return Redirect::route('admin.saveme');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta localidade do Saveme? Esta operação não poderá ser desfeita.');

		$data['savemeData'] = $saveme->toArray();
		$data['savemeArray'] = null;

		foreach ($data['savemeData'] as $key => $value) {
			$data['savemeArray'][Lang::get('saveme.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.saveme.delete', $data);
	}

	/**
	 * Delete Permission.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->saveme->find($id)->delete();

		Session::flash('success', 'Localidade do Saveme excluída com sucesso.');

		return Redirect::route('admin.saveme');
	}

}
