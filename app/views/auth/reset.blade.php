@section('content')

<p>Olá {{ $email }}.</p>

{{ Former::horizontal_open(route('password.update', $token))
	->rules(['email' => 'required', 'password' => 'required', 'password_confirmation' => 'required'])
}}
{{ Former::password('password')->label('Senha')->class('span12')->placeholder('Senha') }}
{{ Former::password('password_confirmation')->label('Confirmação de Senha')->class('span12')->placeholder('Confirmação de Senha') }}
{{ Former::hidden('token', $token) }}
{{ Former::hidden('email', $email) }}
{{ Former::submit('Entrar')->class('btn') }}
{{ Former::close() }}

@stop

