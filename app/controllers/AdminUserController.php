<?php

class AdminUserController extends BaseController {

	/**
	 * User Repository
	 *
	 * @var User
	 */
	protected $user;

	/**
	 * Profile Repository
	 *
	 * @var Profile
	 */
	protected $profile;

	/**
	 * Construct Instance
	 */
	public function __construct(User $user, Profile $profile)
	{
		/*
		 * Enable Sidebar
		 */

		$this->sidebar = true;

		/*
		 * Enable and Set Actions
		 */

		$this->actions = 'admin.user';

		/*
		 * Models Instance
		 */

		$this->user = $user;
		$this->profile = $profile;
	}

    public function missingMethod($parameters)
    {
        Redirect::route('admin.user');
    }

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$user = $this->user->select(['id', 'email', 'created_at'])->with(['profile', 'roles']);

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
		if (Input::has('email')) {
			$user = $user->where('email', 'like', '%'. Input::get('email') .'%');
		}

		/*
		 * Finally Obj
		 */
		$user = $user->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'email' => Input::get('email'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.user.list', compact('sort', 'order', 'pag', 'user'));
	}

	public function getView($id)
	{
		$data['userData'] = $this
			->user
			->findOrFail($id)
			->with([
				'profile',
				'roles',
			])
			->get([
				'id',
				'email',
				'created_at'
			])
			->where('id', $id)
			->first()
			->toArray();

		$data['userArray'] = null;

		foreach ($data['userData'] as $key => $value) {
			if (!is_array($value)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$blackList = [
			'img',
			'facebook_id',
			'user_id',
			'total_purchasses',
			'credit',
			'ip',
			'created_at',
			'updated_at',
		];

		foreach ($data['userData']['profile'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$data['userArray'][Lang::get('user.role')] = '~ ';

		foreach ($data['userData']['roles'] as $roles) {
			foreach ($roles as $key => $value) {
				if ($key == 'description') {
					$data['userArray'][Lang::get('user.role')] .= $value .' ~ ';
				}
			}
		}

		foreach ($data['userArray'] as $key => $value) {
			if (is_null($value) || empty($value)) {
				$data['userArray'][$key] = '~ '. Lang::get('messages.undefined'). ' ~';
			}
		}

		$this->layout->content = View::make('admin.user.view', $data);
	}

	public function getCreate()
	{
		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->name] = [
				'value' => $role->id,
				'name' => 'roles['. $role->name .']'
			];
		}

        Former::populateField('roles', $roles);

		$this->layout->content = View::make('admin.user.create', compact('roles'));
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email',
        	'profile.first_name' => 'required',
        	'profile.last_name' => 'required',
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$created = $this->user->create($inputs)->id;

			$inputs['profile']['user_id'] = $created;

			$user = User::find($created);
			$user->profile()->create($inputs['profile']);

			/*
			 * Roles
			 */
			$roles = [];

			foreach ($inputs['roles'] as $key => $value) {
				$roles[] = $value;
			}

			$user->roles()->sync($roles);

			return Redirect::route('admin.user');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.user.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$user = $this->user->with(['profile', 'roles'])->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->name] = [
				'value' => $role->id,
				'name' => 'roles['. $role->name .']',
				'checked' => $user->is($role->name) ? 'checked' : null,
			];
		}

        Former::populate($user);
        Former::populateField('roles', $roles);

		$this->layout->content = View::make('admin.user.edit', compact('user', 'roles'));
	}

	public function postEdit($id)
	{
		/*
		 * User
		 */
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email,'. $id,
        	'profile.first_name' => 'required',
        	'profile.last_name' => 'required',
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
        	'profile.birth' => 'date_format:d/m/Y',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$user = $this->user->with(['profile', 'roles'])->find($id);

			if ($user)
			{
				/*
				 * User
				 */
				$user->update($inputs);

				/*
				 * Roles
				 */
				$roles = [];

				if (isset($inputs['roles']))
				{
					foreach ($inputs['roles'] as $key => $value) {
						$roles[] = $value;
					}

					$user->roles()->sync($roles);
				}

				else
				{
					$user->roles()->sync([]);
				}

				/*
				 * Profile
				 */
				if ($user->profile()->first()) {
					$user->profile()->update($inputs['profile']);
				}
				else
				{
					$user->profile()->create($inputs['profile']);
				}
			}

			Session::flash('success', 'Usuário <em>#'. $user->id .' - '. $user->email .'</em> atualizado.');

			return Redirect::route('admin.user');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.user.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$user = $this->user->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este usuário? Esta operação não poderá ser desfeita.');

		$data['userData'] = $user->toArray();
		$data['userArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['userData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$this->layout->content = View::make('admin.user.delete', $data);
	}

	public function postDelete($id)
	{
		$user = $this->user->find($id);
		$user->delete();

		Session::flash('success', 'Usuário excluído com sucesso.');

		return Redirect::route('admin.user');
	}

	public function anyDeleted()
	{
		/*
		 * Obj
		 */
		$user = $this->user->onlyTrashed()->select(['id', 'email', 'created_at'])->with(['profile', 'roles']);

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
		if (Input::has('email')) {
			$user = $user->where('email', 'like', '%'. Input::get('email') .'%');
		}

		/*
		 * Finally Obj
		 */
		$user = $user->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'email' => Input::get('email'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.user.deleted.list', compact('sort', 'order', 'pag', 'user'));
	}

	public function getDeletedView($id)
	{
		$data['userData'] = $this
			->user
			->onlyTrashed()
			->findOrFail($id)
			->with([
				'profile',
				'roles',
			])
			->get([
				'id',
				'email',
				'created_at'
			])
			->first()
			->toArray();

		$data['userArray'] = null;

		foreach ($data['userData'] as $key => $value) {
			if (!is_array($value)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$blackList = [
			'img',
			'facebook_id',
			'user_id',
			'total_purchasses',
			'credit',
			'ip',
			'created_at',
			'updated_at',
		];

		foreach ($data['userData']['profile'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$data['userArray'][Lang::get('user.role')] = '~ ';

		foreach ($data['userData']['roles'] as $roles) {
			foreach ($roles as $key => $value) {
				if ($key == 'description') {
					$data['userArray'][Lang::get('user.role')] .= $value .' ~ ';
				}
			}
		}

		foreach ($data['userArray'] as $key => $value) {
			if (is_null($value) || empty($value)) {
				$data['userArray'][$key] = '~ '. Lang::get('messages.undefined'). ' ~';
			}
		}

		$this->layout->content = View::make('admin.user.deleted.view', $data);
	}

	public function getDeletedEdit($id)
	{
		$user = $this->user->onlyTrashed()->with(['profile', 'roles'])->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->name] = [
				'value' => $role->id,
				'name' => 'roles['. $role->name .']',
				// 'checked' => $user->is($role->name) ? 'checked' : null,
			];
		}

        Former::populate($user);
        Former::populateField('roles', $roles);

		$this->layout->content = View::make('admin.user.deleted.edit', compact('user', 'roles'));
	}

	public function postDeletedEdit($id)
	{
		/*
		 * User
		 */
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email,'. $id,
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$user = $this->user->onlyTrashed()->with(['profile', 'roles'])->find($id);

			if ($user)
			{
				/*
				 * User
				 */
				$user->update($inputs);

				/*
				 * Roles
				 */
				$roles = [];

				if (isset($inputs['roles']))
				{
					foreach ($inputs['roles'] as $key => $value) {
						$roles[] = $value;
					}

					$user->roles()->sync($roles);
				}

				else
				{
					$user->roles()->sync([]);
				}

				/*
				 * Profile
				 */
				if ($user->profile()->first()) {
					$user->profile()->update($inputs['profile']);
				}
				else
				{
					$user->profile()->create($inputs['profile']);
				}
			}

			return Redirect::route('admin.user.deleted.edit', $id);
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.user.deleted.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDeletedDelete($id)
	{
		$user = $this->user->onlyTrashed()->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este usuário? Esta operação não poderá ser desfeita.');

		$data['userData'] = $user->toArray();
		$data['userArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['userData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$this->layout->content = View::make('admin.user.deleted.delete', $data);
	}

	public function postDeletedDelete($id)
	{
		$this->user->onlyTrashed()->find($id)->forceDelete();

		Session::flash('success', 'Usuário excluído com sucesso.');

		return Redirect::route('admin.user.deleted');
	}

}
