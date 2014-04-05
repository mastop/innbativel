<?php

use Illuminate\Support\MessageBag;

class AuthController extends BaseController {

	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getLogin()
	{
		if (Auth::check())
		{
			return Redirect::route('home');
		}

		$this->layout->content = View::make('auth.login');
	}

	public function postLogin()
	{
		$user = [
            'username' => Input::get('email'),
            'password' => Input::get('password'),
		];

		$validator = Validator::make(Input::all(), [
									 'username' => 'required',
									 'password' => 'required'
									 ]);

		$isEmail = Validator::make(Input::only('email'), [
								   'email' => 'email',
								   ]);

		if ($isEmail->passes())
		{
			$user = [
			'email' => Input::get('email'),
			'password' => Input::get('password')
			];

			$validator = Validator::make(Input::all(), [
										 'email' => 'required|email',
										 'password' => 'required'
										 ]);
		}

		$errors = new MessageBag();

		if ($old = Input::old('errors'))
		{
			$errors = $old;
		}

		$data = ['errors' => $errors];
		$auth = false;

		if ($validator->passes())
		{
			try
			{
				if (Auth::attempt($user)) {
					$auth = true;
				}

			}
			catch (Exception $e)
			{
				try{
					// Caso o usuário tenha
					if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>md5(Input::get('password')))))
					{
						$auth = true;

						Auth::user()->password = Input::get('password');
						Auth::user()->save();
					}
				}
				catch (Toddish\Verify\UserNotFoundException $e)
				{
					return Redirect::route('login')
					->with('warning', 'Usuário não encontrado.')
					->withInput();
				}
				catch (Toddish\Verify\UserUnverifiedException $e)
				{
					$userId = User::where('email', $user['email'])->first()->id;
					$userToUpdate = User::find($userId);
					$userToUpdate->verified = '1';
					$userToUpdate->save();
				}
				catch (Toddish\Verify\UserDisabledException $e)
				{
					return Redirect::route('login')
					->with('warning', 'Usuário Inativo ou Bloqueado.')
					->withInput();
				}
				catch (Toddish\Verify\UserDeletedException $e)
				{
					return Redirect::route('login')
					->with('warning', 'Usuário excluído.')
					->withInput();
				}
				catch (Toddish\Verify\UserPasswordIncorrectException $e)
				{
					return Redirect::route('login')
					->with('warning', 'Usuário e/ou senha incorretos.')
					->withInput();
				}
			}
		}

		if($auth){

			$destination = Session::get('destination');

			if (!is_null($destination))
			{
				Session::forget('destination');
				return Redirect::to($destination)
				->with('success', Lang::get('auth.loggin-success'));
			}

			if (Auth::user()->is('programador') ||
				Auth::user()->is('administrador') ||
				Auth::user()->is('gerente'))
			{
				return Redirect::route('admin')
				->with('success', Lang::get('auth.loggin-success'))
				->with('success', Lang::get('auth.loggin-as-god'));
			}

			elseif (Auth::user()->is('parceiro'))
			{
				return Redirect::route('admin')
				->with('success', Lang::get('auth.loggin-success'))
				->with('success', Lang::get('auth.loggin-as-partner'));
			}

			elseif (Auth::user()->is('cliente'))
			{
				return Redirect::route('admin')
				->with('success', Lang::get('auth.loggin-success'))
				->with('success', Lang::get('auth.loggin-as-customer'));
			}

			else
			{
				return Redirect::route('home')
				->with('success', Lang::get('auth.loggin-success'));
			}

		}

		$data['errors'] = new MessageBag([
										 'username' => ['Username and/or password invalid.'],
										 'password' => ['Username and/or password invalid.'],
										 ]);

		$data['username'] = Input::get('username');

		return Redirect::back()
		->withInput($data)
		->withErrors($data['errors']);
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::route('home');
	}

	public function getRemind()
	{
		$this->layout->content = View::make('auth.remind');
	}

	public function postRequest()
	{
		$credentials = array('email' => Input::get('email'));
		return Password::remind($credentials);
	}

	public function getReset($token)
	{
		$reminder = DB::table('password_reminders')->where('token', $token)->first();

		if (is_null($reminder)) {
			return Redirect::route('home');
		}

		$email = $reminder->email;

		$this->layout->content = View::make('auth.reset', compact('token', 'email'));
	}

	public function postUpdate()
	{
		$credentials = Input::only(['token','email', 'password', 'password_confirmation']);

		$reminder = DB::table('password_reminders')
			->where('token', $credentials['token'])
			->where('email', $credentials['email'])
			->first();

		if (is_null($reminder)) {
			return Redirect::route('home');
		}

		$rules = [
			'email' => 'required|email|exists:users,email',
			'password' => 'required|between:7,15|alpha_num|confirmed',
			'password_confirmation' => 'required|alpha_num|between:7,15',
		];

		$validation = Validator::make($credentials, $rules);

		if( $validation->fails() )
		{
			return Redirect::route('password.reset', ['token' => $credentials['token']])
				->withErrors($validation->messages());
		}

		$credentials = Input::only(['email', 'password']);

		return Password::reset($credentials, function($user, $password)
		{
			$user->password = $password;
			$user->save();

			return Redirect::route('login')->with('Success', 'Your password has been reset');
		});
	}

	public function getFacebook()
	{

		/**
		 * Facebook Config
		 *
		 * @return array
		 */
		$config = Config::get('facebook');

		/**
		 * Facebook Config
		 *
		 * @return Facebook
		 */
		$facebook = new Facebook($config);


		/**
		 * Facebook User ID
		 *
		 * @return var
		 */
		$user = $facebook->getUser();

		/**
		 * If User ID is not null
		 */
		if($user){

			try
			{
				$profile = $facebook->api('/me');
			}

			catch (FacebookApiException $e)
			{
				error_log($e);
				$user = null;
			}

			if(!empty($profile))
			{
				$uid = $profile['id'];
				$email = $profile['email'];

				$emailExists = User::where('email', '=', $email)->first();
				$profileExists = Profile::where('facebook_id', '=', $uid)->first();

				if (!is_null($emailExists))
				{
					$userObj = User::find($emailExists->id);
					$profileObj = $userObj->profile->exists;

					if ($profileObj) {

						$facebookExists = $userObj->profile->facebook_id;

						if (!is_null($facebookExists)) {
							$profileUpdate = Profile::where('user_id', $userObj->id);
							$profileUpdate->facebook_id = $uid;
							$profileUpdate->update();
						}

						Auth::login($userObj);
						return Redirect::route('home');
					}
				}

				if (!is_null($emailExists))
				{
					$login = User::find($emailExists->id);
					Auth::login($login);
					return Redirect::route('home');
				}

				else
				{

					$new = [
						'email' => $profile['email'],
						'username' => Str::lower(Str::slug($profile['email']) . '-' .Str::random(16)),
						'password' => Str::random(8),
					];

					$created = $this->user->create($new)->id;

					$location = [];
					$location = explode(',', $profile['location']['name']);

					$createdUser = [
						'user_id' => $created,
						'facebook_id' => $profile['id'],
						'name' => $profile['name'],
					];

					if (isset($profile['location']) && !empty($profile['location']))
					{
						$createdUser['city'] = $location[0];
						$createdUser['state'] = $location[1];
					}

					$user = User::find($created);
					$user->profile()->create($createdUser);
				}
			}

			 return Redirect::route('home');
		}

		else
		{
			$login = $facebook->getLoginUrl([
				'scope' => 'email',
				'redirect_uri' => URL::route('login.facebook', null, true),
			]);

			return Redirect::to($login);
		}

	}

	public function getFacebookAjax()
	{

		/**
		 * Facebook Config
		 *
		 * @return array
		 */
		$config = Config::get('facebook');

		/**
		 * Facebook Config
		 *
		 * @return Facebook
		 */
		$facebook = new Facebook($config);


		/**
		 * Facebook User ID
		 *
		 * @return var
		 */
		$user = $facebook->getUser();

		/**
		 * If User ID is not null
		 */
		if($user){

			try
			{
				$profile = $facebook->api('/me');
			}

			catch (FacebookApiException $e)
			{
				error_log($e);
				$user = null;
			}

			if(!empty($profile))
			{
				$uid = $profile['id'];
				$email = $profile['email'];

				$emailExists = User::where('email', '=', $email)->first();
				$profileExists = Profile::where('facebook_id', '=', $uid)->first();

				if (!is_null($profileExists))
				{
					$login = User::find($emailExists->id);
					Auth::login($login);
					return Response::json('yep');
				}

				else
				{
					return Response::json('nope');
				}
			}

			 return 'none';
		}

	}

	public function getCreate()
	{
        $rules = [
            'email' => 'Required|Max:255|Email',
            'profile.first_name' => 'Required|Max:255|Alpha',
            'profile.last_name' => 'Required|Max:255|Alpha',
            'password'              => 'Required|confirmed',
            'password_confirmation' => 'Required',
        ];

		$form  = Former::horizontal_open(route('account.create'))->class('row-fluid')->rules($rules);

        $form .= Former::text('profile.first_name')->label('Nome')->class('span12');
        $form .= Former::text('profile.last_name')->label('Sobrenome')->class('span12');

		$form .= Former::text('email')->class('span12');
		$form .= Former::password('password')->label('Senha')->class('span12');
		$form .= Former::password('password_confirmation')->label('Confirmar senha')->class('span12');
		$form .= Former::submit('Cadastrar')->class('btn btn-danger btn-block');
		$form .= Former::close();

		$this->layout->content = View::make('auth.create', compact('form'));
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
            'email' => 'Required|Max:255|Email|Unique:users,email',
            'profile.first_name' => 'Required|Max:255',
            'profile.last_name' => 'Required|Max:255',
            'password'              => 'Required|confirmed',
            'password_confirmation' => 'Required',
		];

		$validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
            $inputs['username'] = Str::lower(Str::slug(Input::get('email')));
            $inputs['api_key'] = md5($inputs['username']);
            $inputs['password'] = $this->user->setPasswordAttribute($inputs['password']);

            if ($user = $this->user->create($inputs))
            {
                $inputs['profile']['user_id'] = $user->id;

                $user->profile()->create($inputs['profile']);

                /*
                 * Roles
                 */
                $roles = [];
                foreach ($inputs['roles'] as $key => $value) {
                    $roles[] = $value;
                }

                $user->roles()->sync($roles);

                print_r($roles);
                print_r($user->roles());

                // Data to be used on the email view
                $data = array(
                    'user' => $user,
                    'activationcode' => $user->getActivationCode()
                );
                print_r($data);

                /*
                // Send the activation code through email
                Mail::send('emails.welcome', $data, function($m) use ($user)
                {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Welcome ' . $user->first_name);
                });
                */

                // Redirect to the register page
                return Redirect::route('login')
                    ->withInput()
                    ->withErrors('success', 'Seu cadastro foi feito com sucesso!');

                //return Redirect::route('admin.user');
            }
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('account.create')
			->withInput()
			->withErrors($validation);
	}

}
