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
	 * Information Restriction
	 *
	 * @var comercial_restriction
	 */
	protected $comercial_restriction;

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
		 * Comercial role can't see nothing about Tourin (partner_id = 999999999), additional SQL
		 */
		$this->comercial_restriction = Auth::user()->is('comercial') ? 'users.id != 70080' : NULL;

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
		if (Input::has('email')) {
			$partner = $partner->where('email', 'like', '%'. Input::get('email') .'%');
		}

		if(isset($this->comercial_restriction)){
			$partner = $partner->whereRaw($this->comercial_restriction);
		}

		/*
		 * Finally Obj
		 */
		$partner = $partner
				 ->whereExists(function($query){
					if (Input::has('nome')) {
						$query->select(DB::raw(1))
			                  ->from('profiles')
			                  ->whereRaw('profiles.user_id = users.id')
			                  ->whereRaw('CONCAT(CONCAT(COALESCE(profiles.first_name, ""), " ", COALESCE(profiles.last_name, "")), " ", profiles.company_name) LIKE "%'.str_replace("'", "\'", Input::get('nome')).'%"');
		            }
		         })
                 ->whereIn('id', Role::where('name', '=', 'parceiro')->first()->users()->lists('id')) // Só Parceiros
				 ->orderBy($sort, $order)->paginate($pag)->appends([
					'sort' => $sort,
					'order' => $order,
					'pag' => $pag,
					'email' => Input::get('email'),
					'nome' => Input::get('nome'),
				 ]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Parceiros';
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
				'api_key',
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

        $this->layout->page_title = 'Visualizar Parceiro #'.$id;
		$this->layout->content = View::make('admin.partner.view', $data);
	}

	public function getCreate()
	{
        $this->layout->page_title = 'Criar Parceiro';
		$this->layout->content = View::make('admin.partner.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email',
			'password' => 'required',
			'api_key' => 'required|unique:users,api_key',
        	'profile.first_name' => 'required',
        	'profile.company_name' => 'required',
        	'profile.cnpj' => 'required',
            'profile.street' => 'required',
            'profile.number' => 'required',
        	'profile.neighborhood' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required|exists:states,id',
            'profile.country' => 'required',
        	'profile.telephone' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$created = $this->partner->create($inputs)->id;

			$inputs['profile']['user_id'] = $created;

			$partner = User::find($created);
			$partner->profile()->create($inputs['profile']);

			/*
			 * Roles
			 */

			$partner->roles()->sync([9]);  // Role = Partner (Parceiro) | ID = 9

			// INÍCIO E-MAIL DE BOAS VINDAS

			$email = $inputs['email'];
			$name = $inputs['profile']['first_name'];

			$data = array('name' => $name, 'email' => $email, 'password' => $inputs['password']);

        	Mail::send('emails.partner.create', $data, function($message) use($email, $name){
				$message->to($email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Sejam bem vindos, '.$name);
			});

        	// FIM E-MAIL DE BOAS VINDAS

        	Session::flash('success', 'A empresa '.$name.' foi cadastrada e um e-mail com sua senha foi enviado para '.$email.' com sucesso.');

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

        Former::populate($partner);
        $this->layout->page_title = 'Editando Parceiro #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.edit', compact('partner'));
	}

	public function postEdit($id)
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email,'.$id,
			'api_key' => 'required|unique:users,api_key',
        	'profile.first_name' => 'required',
        	'profile.company_name' => 'required',
        	'profile.cnpj' => 'required',
            'profile.street' => 'required',
            'profile.number' => 'required',
        	'profile.neighborhood' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required|exists:states,id',
            'profile.country' => 'required',
        	'profile.telephone' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$partner = $this->partner->with(['profile', 'roles'])->find($id);

			if ($partner)
			{
				/*
				 * User
				 */
				$partner->update($inputs);

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

			Session::flash('success', 'Parceiro <em>#'. $partner->id .' - '. $partner->email .'</em> atualizado.');

			return Redirect::route('admin.partner');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getEditPassword($id)
	{
		$partner = $this->partner->with(['profile', 'roles'])->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

        Former::populate($partner);
        $this->layout->page_title = 'Editando o password do Parceiro #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.edit_password', compact('partner'));
	}

	public function postEditPassword($id)
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$partner = $this->partner->with(['profile', 'roles'])->find($id);

			if ($partner)
			{
				/*
				 * User
				 */
				$partner->update($inputs);
			}

			Session::flash('success', 'Senha do parceiro <em>#'. $partner->id .' - '. $partner->email .'</em> atualizada.');

			return Redirect::route('admin.partner.edit_password', $id);
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner.edit_password', $id)
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

		Session::flash('error', 'Você tem certeza que deleja excluir este parceiro? Esta operação não poderá ser desfeita.');

		$data['partnerData'] = $partner->toArray();
		$data['partnerArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}
        $this->layout->page_title = 'Excluir Parceiro #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.delete', $data);
	}

	public function postDelete($id)
	{
		$partner = $this->partner->find($id);
		$partner->delete();

		Session::flash('success', 'Parceiro excluído com sucesso.');

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
		if (Input::has('email')) {
			$partner = $partner->where('email', 'like', '%'. Input::get('email') .'%');
		}

		/*
		 * Finally Obj
		 */
		$partner = $partner
        ->whereIn('id', Role::where('name', '=', 'parceiro')->first()->users()->onlyTrashed()->lists('id')) // Só Parceiros
		->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'email' => Input::get('email'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Parceiros Excluídos';
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
        $this->layout->page_title = 'Visualizar Parceiro Excluído';
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
        $this->layout->page_title = 'Editando Parceiro Excluído #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.deleted.edit', compact('partner', 'roles'));
	}

	public function postDeletedEdit($id)
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

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

		Session::flash('error', 'Você tem certeza que deleja excluir este parceiro? Esta operação não poderá ser desfeita.');

		$data['partnerData'] = $partner->toArray();
		$data['partnerArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}
        $this->layout->page_title = 'Excluir PERMANENTEMENTE Parceiro #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.deleted.delete', $data);
	}

	public function postDeletedDelete($id)
	{
		$this->partner->onlyTrashed()->find($id)->forceDelete();

		Session::flash('success', 'Parceiro excluído com sucesso.');

		return Redirect::route('admin.partner.deleted');
	}

	public function getDeletedRestore($id)
	{
		$partner = $this->partner->onlyTrashed()->find($id);

		if (is_null($partner))
		{
			return Redirect::route('admin.partner');
		}

		Session::flash('error', 'Você tem certeza que deleja reativar este parceiro?');

		$data['partnerData'] = $partner->toArray();
		$data['partnerArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['partnerData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['partnerArray'][Lang::get('partner.'. $key)] = $value;
			}
		}
        $this->layout->page_title = 'Reativar Parceiro #'.$partner->id.' '.$partner->profile->company_name;
		$this->layout->content = View::make('admin.partner.deleted.restore', $data);
	}

	public function postDeletedRestore($id)
	{
		$this->partner->onlyTrashed()->find($id)->restore();

		Session::flash('success', 'Parceiro reativado com sucesso.');

		return Redirect::route('admin.partner.deleted');
	}

}
