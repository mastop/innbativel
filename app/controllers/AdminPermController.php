<?php

class AdminPermController extends BaseController {

	/**
	 * Permission Repository
	 *
	 * @var Permission
	 */
	protected $perm;

	/**
	 * Constructor
	 */
	public function __construct(Permission $perm)
	{
		/*
		 * Set Permission Instance
		 */

		$this->perm = $perm;

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
		$perm = $this->perm;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

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
		if (Input::has('name')) {
			$perm = $perm->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('description')) {
			$perm = $perm->where('description', 'like', '%'. Input::get('description') .'%');
		}

		/*
		 * Finally Obj
		 */
		$perm = $perm->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'description' => Input::get('description'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.perm.list', compact('sort', 'order', 'pag', 'perm'));
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

		$this->layout->content = View::make('admin.perm.create');
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
        	'name' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->perm->create($inputs);

			return Redirect::route('admin.perm');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.perm.create')
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
		$perm = $this->perm->find($id);

		if (is_null($perm))
		{
			return Redirect::route('admin.perm');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.perm.edit', compact('perm'));
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
        	'name' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$perm = $this->perm->find($id);

			if ($perm)
			{
				$perm->update($inputs);
			}

			return Redirect::route('admin.perm');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.perm.edit', $id)
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
		$perm = $this->perm->find($id);

		if (is_null($perm))
		{
			return Redirect::route('admin.perm');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta permuração? Esta operação não poderá ser desfeita.');

		$data['permData'] = $perm->toArray();
		$data['permArray'] = null;

		foreach ($data['permData'] as $key => $value) {
			$data['permArray'][Lang::get('perm.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.perm.delete', $data);
	}

	/**
	 * Delete Permission.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->perm->find($id)->delete();

		Session::flash('success', 'Papel de usuário excluído com sucesso.');

		return Redirect::route('admin.perm');
	}

}