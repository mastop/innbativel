<?php

class AdminPartnerController extends BaseController {

	/**
	 * partner Repository
	 *
	 * @var partner
	 */
	protected $partner;

	/**
	 * Profile Repository
	 *
	 * @var Profile
	 */
	protected $profile;

	/**
	 * Construct Instance
	 */
	public function __construct(User $partner, Profile $profile)
	{
		/*
		 * Enable Sidebar
		 */

		$this->sidebar = true;

		/*
		 * Enable and Set Actions
		 */

		$this->actions = 'admin.partner';

		/*
		 * Models Instance
		 */

		$this->partner = $partner;
		$this->profile = $profile;
	}

    public function missingMethod($parameters)
    {
        Redirect::route('admin.partner');
    }

	/**
	 * Display all partners.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$partner = $this->partner->select(['id', 'email', 'created_at'])->with(['profile', 'roles']);

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
			$partner = $partner->where('email', 'like', '%'. Input::get('email') .'%');
		}

		/*
		 * Finally Obj
		 */
		$partner = $partner
		->whereExists(function($query){
			$query->select(DB::raw(1))
                  ->from('role_user')
				  ->join('roles', 'roles.id', '=', 'role_user.role_id')
                  ->whereRaw('role_user.user_id = users.id')
                  ->whereRaw('roles.name = \'parceiro\'');
        })
		->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'email' => Input::get('email'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.partner.list', compact('sort', 'order', 'pag', 'partner'));
	}

	public function getView($id)
	{
		$data['partnerData'] = $this
			->partner
			->findOrFail($id)
			->with([
				'profile',
				'roles',
			])
			->where('id', $id)
			->get([
				'id',
				'email',
				'created_at'
			])
			->first()
			->toArray();

		$data['partnerArray'] = null;

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$blackList = [
			'img',
			'facebook_id',
			'partner_id',
			'total_purchasses',
			'credit',
			'ip',
			'created_at',
			'updated_at',
		];

		foreach ($data['partnerData']['profile'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$data['partnerArray'][Lang::get('partner.role')] = '~ ';

		foreach ($data['partnerData']['roles'] as $roles) {
			foreach ($roles as $key => $value) {
				if ($key == 'description') {
					$data['partnerArray'][Lang::get('partner.role')] .= $value .' ~ ';
				}
			}
		}

		foreach ($data['partnerArray'] as $key => $value) {
			if (is_null($value) || empty($value)) {
				$data['partnerArray'][$key] = '~ '. Lang::get('messages.undefined'). ' ~';
			}
		}

		$this->layout->content = View::make('admin.partner.view', $data);
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

		$this->layout->content = View::make('admin.partner.create', compact('roles'));
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$inputs['partnername'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:partners,email',
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
			$created = $this->partner->create($inputs)->id;

			$inputs['profile']['partner_id'] = $created;

			$partner = partner::find($created);
			$partner->profile()->create($inputs['profile']);

			/*
			 * Roles
			 */
			$roles = [];

			foreach ($inputs['roles'] as $key => $value) {
				$roles[] = $value;
			}

			$partner->roles()->sync($roles);

			return Redirect::route('admin.partner');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$partner = $this->partner->with(['profile', 'roles'])->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->name] = [
				'value' => $role->id,
				'name' => 'roles['. $role->name .']',
				'checked' => $partner->is($role->name) ? 'checked' : null,
			];
		}

        Former::populate($partner);
        Former::populateField('roles', $roles);

		$this->layout->content = View::make('admin.partner.edit', compact('partner', 'roles'));
	}

	public function postEdit($id)
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$inputs['partnername'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:partners,email,'. $id,
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
			$partner = $this->partner->with(['profile', 'roles'])->find($id);

			if ($partner)
			{
				/*
				 * partner
				 */
				$partner->update($inputs);

				/*
				 * Roles
				 */
				$roles = [];

				if (isset($inputs['roles']))
				{
					foreach ($inputs['roles'] as $key => $value) {
						$roles[] = $value;
					}

					$partner->roles()->sync($roles);
				}

				else
				{
					$partner->roles()->sync([]);
				}

				/*
				 * Profile
				 */
				if ($partner->profile()->first()) {
					$partner->profile()->update($inputs['profile']);
				}
				else
				{
					$partner->profile()->create($inputs['profile']);
				}
			}

			Session::flash('success', 'Usuário <em>#'. $partner->id .' - '. $partner->email .'</em> atualizado.');

			return Redirect::route('admin.partner');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$partner = $this->partner->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este usuário? Esta operação não poderá ser desfeita.');

		$data['partnerData'] = $partner->toArray();
		$data['partnerArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$this->layout->content = View::make('admin.partner.delete', $data);
	}

	public function postDelete($id)
	{
		$partner = $this->partner->find($id);
		$partner->delete();

		Session::flash('success', 'Usuário excluído com sucesso.');

		return Redirect::route('admin.partner');
	}

	public function anyDeleted()
	{
		/*
		 * Obj
		 */
		$partner = $this->partner->onlyTrashed()->select(['id', 'email', 'created_at'])->with(['profile', 'roles']);

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
			$partner = $partner->where('email', 'like', '%'. Input::get('email') .'%');
		}

		/*
		 * Finally Obj
		 */
		$partner = $partner->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'email' => Input::get('email'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.partner.deleted.list', compact('sort', 'order', 'pag', 'partner'));
	}

	public function getDeletedView($id)
	{
		$data['partnerData'] = $this
			->partner
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

		$data['partnerArray'] = null;

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$blackList = [
			'img',
			'facebook_id',
			'partner_id',
			'total_purchasses',
			'credit',
			'ip',
			'created_at',
			'updated_at',
		];

		foreach ($data['partnerData']['profile'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$data['partnerArray'][Lang::get('partner.role')] = '~ ';

		foreach ($data['partnerData']['roles'] as $roles) {
			foreach ($roles as $key => $value) {
				if ($key == 'description') {
					$data['partnerArray'][Lang::get('partner.role')] .= $value .' ~ ';
				}
			}
		}

		foreach ($data['partnerArray'] as $key => $value) {
			if (is_null($value) || empty($value)) {
				$data['partnerArray'][$key] = '~ '. Lang::get('messages.undefined'). ' ~';
			}
		}

		$this->layout->content = View::make('admin.partner.deleted.view', $data);
	}

	public function getDeletedEdit($id)
	{
		$partner = $this->partner->onlyTrashed()->with(['profile', 'roles'])->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

		$roles = [];
		foreach (Role::all() as $role) {
			$roles[$role->name] = [
				'value' => $role->id,
				'name' => 'roles['. $role->name .']',
				// 'checked' => $partner->is($role->name) ? 'checked' : null,
			];
		}

        Former::populate($partner);
        Former::populateField('roles', $roles);

		$this->layout->content = View::make('admin.partner.deleted.edit', compact('partner', 'roles'));
	}

	public function postDeletedEdit($id)
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$inputs['partnername'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:partners,email,'. $id,
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$partner = $this->partner->onlyTrashed()->with(['profile', 'roles'])->find($id);

			if ($partner)
			{
				/*
				 * partner
				 */
				$partner->update($inputs);

				/*
				 * Roles
				 */
				$roles = [];

				if (isset($inputs['roles']))
				{
					foreach ($inputs['roles'] as $key => $value) {
						$roles[] = $value;
					}

					$partner->roles()->sync($roles);
				}

				else
				{
					$partner->roles()->sync([]);
				}

				/*
				 * Profile
				 */
				if ($partner->profile()->first()) {
					$partner->profile()->update($inputs['profile']);
				}
				else
				{
					$partner->profile()->create($inputs['profile']);
				}
			}

			return Redirect::route('admin.partner.deleted.edit', $id);
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner.deleted.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDeletedDelete($id)
	{
		$partner = $this->partner->onlyTrashed()->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este usuário? Esta operação não poderá ser desfeita.');

		$data['partnerData'] = $partner->toArray();
		$data['partnerArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}

		$this->layout->content = View::make('admin.partner.deleted.delete', $data);
	}

	public function postDeletedDelete($id)
	{
		$this->partner->onlyTrashed()->find($id)->forceDelete();

		Session::flash('success', 'Usuário excluído com sucesso.');

		return Redirect::route('admin.partner.deleted');
	}

}
