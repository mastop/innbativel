<?php

class AdminIncludedController extends BaseController {

	/**
	 * included Repository
	 *
	 * @var included
	 */
	protected $included;

	/**
	 * Constructor
	 */
	public function __construct(Included $included)
	{
		/*
		 * Set included Instance
		 */

		$this->included = $included;

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
		$included = $this->included;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'description']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$included = $included->where('name', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('description')) {
			$included = $included->where('description', 'like', '%'. Input::get('description') .'%');
		}

		/*
		 * Finally Obj
		 */
		$included = $included->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'title' => Input::get('title'),
			'description' => Input::get('description'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.included.list', compact('sort', 'order', 'pag', 'included'));
	}

	/**
	 * Display included Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.included.create');
	}

	/**
	 * Create included.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'title' => 'required',
        	'description' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->included->create($inputs);

			return Redirect::route('admin.included');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.included.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display included Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$included = $this->included->find($id);

		if (is_null($included))
		{
			return Redirect::route('admin.included');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.included.edit', compact('included'));
	}

	/**
	 * Update included.
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
        	'description' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$included = $this->included->find($id);

			if ($included)
			{
				$included->update($inputs);
			}

			return Redirect::route('admin.included');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.included.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display included Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$included = $this->included->find($id);

		if (is_null($included))
		{
			return Redirect::route('admin.included');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este "item incluso"? Esta operação não poderá ser desfeita.');

		$data['includedData'] = $included->toArray();
		$data['includedArray'] = null;

		foreach ($data['includedData'] as $key => $value) {
			$data['includedArray'][Lang::get('included.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.included.delete', $data);
	}

	/**
	 * Delete included.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->included->find($id)->delete();

		Session::flash('success', '"Item incluso" excluído com sucesso.');

		return Redirect::route('admin.included');
	}

}
