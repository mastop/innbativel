<?php

class AdminRoleController extends BaseController {

	/**
	 * Roleuration Repository
	 *
	 * @var Roleuration
	 */
	protected $role;

	public function __construct(Role $role)
	{
		$this->role = $role;
		$this->sidebar = true;
	}

	/**
	 * Display all Roles.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$role = $this->role->select(['id','name','level']);

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
		if (Input::has('name')) {
			$role = $role->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('level')) {
			$role = $role->where('level', 'like', '%'. Input::get('level') .'%');
		}

		/*
		 * Finally Obj
		 */
		$role = $role->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'level' => Input::get('level'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.role.list', compact('sort', 'order', 'pag', 'role'));
	}

	public function getCreate()
	{
		$this->layout->content = View::make('admin.role.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required|alpha',
        	'level' => 'required',
        	'level' => 'required|numeric',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->role->create($inputs);

			return Redirect::route('admin.role');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.role.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$role = $this->role->find($id);

		if (is_null($role))
		{
			return Redirect::route('admin.role');
		}

		$permAllowed = [];

		foreach ($role->permissions as $permission)
		{
		    $permAllowed[] = $permission->name;
		}

		$permissions = [];
		foreach (Permission::all() as $permission) {
			$permissions[$permission->name] = [
				'value' => $permission->id,
				'name' => 'permissions['. $permission->name .']',
				'checked' => in_array($permission->name, $permAllowed) ? 'checked' : null,
			];
		}

        Former::populate($role);
        Former::populateField('permissions', $permissions);

		$this->layout->content = View::make('admin.role.edit', compact('role', 'permissions'));
	}

	public function postEdit($id)
	{
		/*
		 * Role
		 */
		$inputs = Input::all();

		$rules = [
        	'name' => 'required|alpha',
        	'level' => 'required',
        	'level' => 'required|numeric',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$role = $this->role->find($id);

			if ($role)
			{
				$role->update($inputs);
			}

			/*
			 * Roles
			 */
			$permissions = [];

			if (isset($inputs['permissions']))
			{
				foreach ($inputs['permissions'] as $key => $value) {
					$permissions[] = $value;
				}

				$role->permissions()->sync($permissions);
			}

			else
			{
				$role->permissions()->sync([]);
			}

			return Redirect::route('admin.role');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.role.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$role = $this->role->find($id);

		if (is_null($role))
		{
			return Redirect::route('admin.role');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta roleuração? Esta operação não poderá ser desfeita.');

		$data['roleData'] = $role->toArray();
		$data['roleArray'] = null;

		foreach ($data['roleData'] as $key => $value) {
			$data['roleArray'][Lang::get('role.'. $key)] = $value;
		}

		$this->layout->content = View::make('admin.role.delete', $data);
	}

	public function postDelete($id)
	{
		$this->role->find($id)->delete();

		Session::flash('success', 'Papel de usuário excluído com sucesso.');

		return Redirect::route('admin.role');
	}

}
