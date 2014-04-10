<?php

class PainelUserController extends BaseController {

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
        Redirect::route('painel.user');
    }

    public function getEdit()
    {
        if (!Auth::check())
        {
            return Redirect::route('login')
                ->with('warning', 'Por favor, informe seu Usuário e senha.')
                ->withInput();
        }

        $user = $this->user->with(['profile', 'roles'])->find(Auth::user()->id);
        if (is_null($user))
        {
            return Redirect::route('login')
                ->with('warning', 'Por favor, informe seu Usuário e senha.')
                ->withInput();
        }

        Former::populate($user);
        $this->layout->content = View::make('painel.user.edit', compact('user'));
    }

    public function postEdit()
    {
        if (!Auth::check())
        {
            return Redirect::route('login')
                ->with('warning', 'Por favor, informe seu Usuário e senha.')
                ->withInput();
        }

        $user = $this->user->with(['profile', 'roles'])->find(Auth::user()->id);
        if (is_null($user))
        {
            return Redirect::route('login')
                ->with('warning', 'Por favor, informe seu Usuário e senha.')
                ->withInput();
        }

        /*
         * User
         */
        $inputs = Input::all();

        $inputs['username'] = Str::lower(Str::slug(Input::get('email')));
        $rules = [
            'email' => 'required|email|unique:users,email,'. $user->id,
            'profile.first_name' => 'required|Max:255',
            'profile.last_name' => 'required|Max:255',
            'profile.cpf' => 'required|numeric',
            'profile.city' => 'required|Max:255',
            'profile.state' => 'required|Max:255|Alpha',
            'profile.country' => 'required|Max:255|Alpha',
            'profile.birth' => 'date_format:d/m/Y',
            'profile.number' => 'numeric',
            'profile.telephone' => 'numeric',
            'profile.zip' => 'numeric',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes())
        {
            if ($user)
            {
                /*
                 * User
                 */
                $user->update($inputs);

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

            Session::flash('success', 'Usuário <em>'. $user->email .'</em> atualizado.');

            return Redirect::route('painel');
        }

        /*
         * Return and display Errors
         */
        return Redirect::route('painel.user.edit')
            ->withInput()
            ->withErrors($validation);
    }
}

