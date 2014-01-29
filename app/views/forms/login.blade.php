{{ Former::horizontal_open(route('login.post'))->class('row-fluid')->rules(['email' => 'required', 'password' => 'required', ]) }}
{{ Former::text('email')->class('span12')->placeholder('E-mail') }}
{{ Former::password('password')->label('Senha')->class('span12')->placeholder('Senha') }}
{{ Former::checkbox()->text('Mantenha-me logado')->name('remember')->check()->label('') }}
<div class="login-btn">
    {{ Former::danger_submit('Entrar')->class('btn btn-danger btn-block') }}
</div>
<div class="login-request">
	<a href="{{ route('password.remind') }}">Recuperar Senha</a>
</div>
{{ Former::close() }}

<span id="login-or">ou</span>

<a href="{{ route('login.facebook') }}" id="facebook-login">Login com Facebook</a>
