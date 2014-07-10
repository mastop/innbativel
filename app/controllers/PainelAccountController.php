<?php

class PainelAccountController extends BaseController {

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

		$this->actions = 'painel.account';

		/*
		 * Models Instance
		 */

		$this->partner = $partner;
		$this->profile = $profile;
	}

    public function missingMethod($parameters)
    {
        Redirect::route('painel');
    }

	public function getEdit()
	{
		$id = Auth::user()->id;
		$partner = $this->partner->with(['profile', 'roles'])->find($id);

		if (is_null($partner))
		{
			return Redirect::route('painel.account');
		}

        Former::populate($partner);
        $this->layout->page_title = 'Minha conta';
		$this->layout->content = View::make('painel.account.edit', compact('partner'));
	}

	public function postEdit()
	{
		/*
		 * partner
		 */
		$inputs = Input::all();

		$id = Auth::user()->id;

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email,'.$id,
			'api_key' => 'required|unique:users,api_key,'.$id,
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

			Session::flash('success', 'Conta atualizada com sucesso.');

			return Redirect::route('painel.account.edit');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('painel.account.edit')
			->withInput()
			->withErrors($validation);
	}

	public function getEditPassword()
	{
        $this->layout->page_title = 'Alterar minha senha';
		$this->layout->content = View::make('painel.account.edit_password', compact('partner'));
	}

	public function postEditPassword()
	{
		$inputs = Input::all();

		$rules = [
        	'pass' => 'required',
        	'newpass' => 'required|min:6|confirmed',
        	'newpass_confirmation' => 'required|min:6',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes()){
			$old = Input::get('pass');
	        $user = User::findOrFail(Auth::user()->id);

	        if(Hash::check($user->salt.$old, $user->password))
	        {
	            $user->password = Input::get('newpass');
                $user->save();

                Session::flash('success', 'Senha alterada com sucesso.');
                return Redirect::route('painel.password.edit');
	        }
	        else
	        {
	            return Redirect::route('painel.password.edit')->with('error', 'Senha atual inválida');
	        }
		}

        /*
		 * Return and display Errors
		 */
		return Redirect::route('painel.password.edit')
			->withInput()
			->withErrors($validation);
	}

}
