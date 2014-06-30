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
		}else{
            return Redirect::route('home', array('destination' => Input::get('destination', '/minha-conta')));
        }

		//$this->layout->content = View::make('auth.login');
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
                    if (Auth::attempt(array('email' => Input::get('email'), 'password' => $this->user->setPasswordAttribute(Input::get('password')))))
                    {
                        return Redirect::back()
                            ->with('success', 'Login efetuado com sucesso!')
                            ->withInput();
                    }
				}
				catch (Toddish\Verify\UserNotFoundException $e)
				{
					return Redirect::back()
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
					return Redirect::back()
                        ->with('warning', 'Usuário Inativo ou Bloqueado.')
                        ->withInput();
				}
				catch (Toddish\Verify\UserDeletedException $e)
				{
					return Redirect::back()
                        ->with('warning', 'Usuário excluído.')
                        ->withInput();
				}
				catch (Toddish\Verify\UserPasswordIncorrectException $e)
				{
                    try{
                        // Caso o usuário tenha senha em MD5
                        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>md5(Input::get('password')))))
                        {
                            $auth = true;
                            Auth::user()->password = Input::get('password');
                            Auth::user()->save();

                            return Redirect::back()
                            ->with('success', 'Login efetuado com sucesso!')
                            ->withInput();
                        }
                    }
                    catch (Toddish\Verify\UserPasswordIncorrectException $e)
                    {
					    return Redirect::route('home', array('destination' => Input::get('destination', Session::get('destination'))))
                            ->with('warning', 'Usuário e/ou senha incorretos.')
                            ->withInput();
                    }
				}
			}
		}


		if($auth){

			$destination = Input::get('destination', Session::get('destination'));

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
				return Redirect::route('painel')
				->with('success', Lang::get('auth.loggin-success'))
				->with('success', Lang::get('auth.loggin-as-partner'));
			}

			elseif (Auth::user()->is('cliente'))
			{
				return Redirect::back()
				->with('success', Lang::get('auth.loggin-success'))
				->with('success', Lang::get('auth.loggin-as-customer'));
			}

			else
			{
				return Redirect::back()
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
        if(Session::has('fb_token')){
            $helper = new Facebook();
            $session = new FacebookSession( Session::get('fb_token') );
            if($session) return Redirect::to($helper->getLogoutUrl($session, route('home')));
        }
		return Redirect::route('home');
	}

	public function getRemind()
	{
		$this->layout->content = View::make('auth.remind');
	}

	public function postRequest()
	{
		$credentials = array('email' => Input::get('email', Input::get('passRecoverEmail')));
        $ret = [];
        try{
            Password::remind($credentials);
            $ret['error'] = 0;
            $ret['message'] = 'Senha enviada por e-mail';
        }catch (Exception $v){
            $ret['error'] = 1;
            //$ret['message'] = $v->getMessage();
            $ret['message'] = 'E-mail não encontrado';
        }
		return Response::json($ret);
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

			return Redirect::route('home', array('destination' => '/minha-conta'))->with('warning', 'Sua senha foi alterada');
		});
	}

	public function getFacebook()
	{
        $destination = Input::get('destination', Session::get('destination', '/'));

        $helper = new Facebook();

        // Check if existing session exists
        if ( Session::has('fb_token') ) {

            // Create new session from saved access_token
            $session = new FacebookSession( Session::get('fb_token') );

            // Validate the access_token to make sure it's still valid
            try {
                if ( ! $session->validate() ) {
                    $session = null;
                }
            } catch ( Exception $e ) {
                // Catch any exceptions
                Log::error($e);
                $session = null;
            }
        } else {
            // No session exists
            try {
                $session = $helper->getSessionFromRedirect();
            } catch( FacebookRequestException $ex ) {
                // When Facebook returns an error
                Log::error($ex);
            } catch( Exception $ex ) {
                // When validation fails or other local issues
                Log::error($ex);
            }
        }

        // Check if a session exists
        if ( isset( $session ) ) {

            // Save the session
            Session::put('fb_token', $session->getToken());

            // Create session using saved token or the new one we generated at login
            $session = new FacebookSession( $session->getToken() );

            // Create the logout URL (logout page should destroy the session)
            // $logoutURL = $helper->getLogoutUrl( $session, 'http://yourdomain.com/logout' );
        }else{
            return Redirect::back()
                ->with('warning', 'Erro ao se comunicar com o Facebook')
                ->withInput();
        }
        // Graph API to request user data
        $request = (new FacebookRequest( $session, 'GET', '/me' ))->execute();

        // Get response as an array
        $user = $request->getGraphObject()->asArray();
		/**
		 * If User ID is not null
		 */
		if($user)
        {
            /**
             * Exemplo de $user
             *
             *
            array (size=14)
            'id' => string '100002078826091' (length=15)
            'birthday' => string '02/27/1983' (length=10)
            'email' => string 'fernando@mastop.com.br' (length=22)
            'first_name' => string 'Fernando' (length=8)
            'gender' => string 'male' (length=4)
            'hometown' =>
            object(stdClass)[1546]
            public 'id' => string '112047398814697' (length=15)
            public 'name' => string 'SÃ£o Paulo, Brazil' (length=18)
            'last_name' => string 'Santos' (length=6)
            'link' => string 'http://www.facebook.com/100002078826091' (length=39)
            'location' =>
            object(stdClass)[1547]
            public 'id' => string '106339232734991' (length=15)
            public 'name' => string 'FlorianÃ³polis, Santa Catarina' (length=30)
            'locale' => string 'en_US' (length=5)
            'name' => string 'Fernando Santos' (length=15)
            'timezone' => int -3
            'updated_time' => string '2014-05-08T19:55:19+0000' (length=24)
            'verified' => boolean true
             *
             *
             */
            $uid = $user['id'];
            $email = $user['email'];
            $emailExists = User::where('email', '=', $email)->first();
            $profileExists = Profile::where('facebook_id', '=', $uid)->first();

            if (!is_null($emailExists))
            {
                $userObj = User::find($emailExists->id);

                $profileObj = $userObj->profile;

                if ($profileObj) {

                    $facebookExists = $userObj->profile->facebook_id;

                    if (!is_null($facebookExists)) {
                        $profileUpdate = Profile::where('user_id', $userObj->id)->first();
                        $profileUpdate->facebook_id = $uid;
                        $profileUpdate->first_name = $user['first_name'];
                        $profileUpdate->last_name = $user['last_name'];
                        if(isset($user['location']->name)){
                            $location = explode(',', $user['location']->name);
                            $profileUpdate->city = (isset($location[0]) && !empty($location[0])) ? trim($location[0]) : "";
                            $profileUpdate->state = (isset($location[1]) && !empty($location[1])) ? trim($location[1]) : "";
                        }
                        if(isset($user['birthday'])){
                            $birth = explode('/', $user['birthday']);
                            $profileUpdate->birthday = $birth[2].'-'.$birth[0].'-'.$birth[1];
                        }
                        $profileUpdate->update();
                    }
                }
                Auth::login($userObj);
                return Redirect::to($destination)->with('success', 'Seja bem-vindo, <strong>'.$profileObj->first_name.'</strong>!');
            }elseif(!is_null($profileExists)){
                $userObj = User::find($profileExists->user_id);
                // Atualiza o profile
                $profileExists->first_name = $user['first_name'];
                $profileExists->last_name = $user['last_name'];
                if(isset($user['location']->name)){
                    $location = explode(',', $user['location']->name);
                    $profileExists->city = (isset($location[0]) && !empty($location[0])) ? trim($location[0]) : "";
                    $profileExists->state = (isset($location[1]) && !empty($location[1])) ? trim($location[1]) : "";
                }
                if(isset($user['birthday'])){
                    $birth = explode('/', $user['birthday']);
                    $profileExists->birthday = $birth[2].'-'.$birth[0].'-'.$birth[1];
                }
                $profileExists->update();
                Auth::login($userObj);
                return Redirect::to($destination)->with('success', 'Seja bem-vindo, <strong>'.$profileExists->first_name.'</strong>!');
            }else{
                // Novo usuário
                $new = [
                    'email' => $user['email'],
                    'username' => Str::lower(Str::slug($user['email']) . '-' .Str::random(16)),
                    'password' => Str::random(8),
                ];

                $created = $this->user->create($new)->id;

                $createdUser = [
                    'user_id' => $created,
                    'facebook_id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                ];
                if(isset($user['birthday'])){
                    $birth = explode('/', $user['birthday']);
                    $createdUser['birthday'] = $birth[2].'-'.$birth[0].'-'.$birth[1];
                }
                if (isset($user['location']->name))
                {
                    $location = explode(',', $user['location']->name);
                    $createdUser['city'] = (isset($location[0]) && !empty($location[0])) ? trim($location[0]) : "";
                    $createdUser['state'] = (isset($location[1]) && !empty($location[1])) ? trim($location[1]) : "";
                }

                $user = User::find($created);
                $user->profile()->create($createdUser);

                Auth::login($user);
                return Redirect::to($destination)->with('success', 'Seja bem-vindo, <strong>'.$user->profile->first_name.'</strong>!');
            }
			 return Redirect::to($destination);
		}

        return Redirect::route('home')->with('warning', 'Falha ao tentar logar com os dados do Facebook');
	}

	public function getCreate()
	{
        return Redirect::route('home', ['open' => 'register']);
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
            'registerEmail' => 'required|email',
            'registerFullName' => 'required',
            'registerPhone' => 'required|numeric',
            'registerPassword'      => 'required|min:6|confirmed',
            'registerPassword_confirmation' => 'required|min:6',
		];

		$validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
            $userData = [];
            $userData['username'] = Str::lower(Str::slug(Input::get('registerEmail')));
            $userData['api_key'] = md5($userData['username']);
            //$inputs['password'] = $this->user->setPasswordAttribute($inputs['password']);
            $userData['password'] = $inputs['registerPassword'];
            $userData['email'] = $inputs['registerEmail'];
            if ($user = $this->user->create($userData))
            {
                $profileData = [];
                $profileData['user_id'] = $user->id;
                $FullNameArray = explode(' ', $inputs['registerFullName']);
                $profileData['first_name'] = array_shift($FullNameArray);
                $profileData['last_name'] = implode(' ', $FullNameArray);
                $profileData['telephone'] = $inputs['registerPhone'];
                $profileData['allow_newsletter'] = Input::get('registerNewsletter', 0);

                $user->profile()->create($profileData);

                $user->roles()->sync(array(10)); // 10 = Cliente

                // Email de boas vindas
                Mail::send('emails.auth.welcome', $user, function($message) use ($user){
                    $message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Bem-vindo ao INNBatível');
                });

                // Loga o usuário
                $userdata = array(
                    'email'      => $userData['email'],
                    'password'   => $userData['password']
                );
                $destination = Input::get('destination', Session::get('destination', '/'));
                try
                {
                    if ( Auth::attempt($userdata ) ) {
                        return Redirect::to($destination)->with('success', 'Seja bem-vindo, <strong>'.$profileData['first_name'].'</strong>!');
                    }
                }
                catch (Exception $e)
                {
                    // Redirect to the register page
                    return //Redirect::route('home')
                        Redirect::to($destination)
                            ->with('warning', 'Bem-vindo, <strong>'.$profileData['first_name'].'</strong>! Você está cadastrado.');
                }
            }
		}
		/*
		 * Return and display Errors
		 */
		return Redirect::route('home')
			->withInput()
			->withErrors($validation);
	}

}
