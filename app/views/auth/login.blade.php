@section('content')

<div id="main" class="container">
	<div class="login">
		<div class="navbar">
			<div class="navbar-inner">
				<h6><i class="icon-user"></i>{{ Lang::get('auth.login-title') }}</h6>
				<div class="nav pull-right">
					<a href="#" class="dropdown-toggle navbar-icon" data-toggle="dropdown"><i class="icon-cog"></i></a>
					<ul class="dropdown-menu pull-right">
						<li><a href="#"><i class="icon-plus"></i>{{ Lang::get('auth.login-register') }}</a></li>
						<li><a href="#"><i class="icon-refresh"></i>{{ Lang::get('auth.password-recovery') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	    <a href="{{ route('facebook') }}">
	        <img alt="Acesse via Facebook" src="//innbativel.s3.amazonaws.com/facebook-connect.png">
	    </a>
	    <br /><br />
		<div class="well">
			{{ Former::horizontal_open()->class('row-fluid')->rules(['email' => 'required', 'password' => 'required', ]) }}
			{{ Former::text('email')->class('span12')->placeholder('E-mail') }}
			{{ Former::password('password')->label('Senha')->class('span12')->placeholder('Senha') }}
			{{ Former::checkbox()->text('Mantenha-me logado')->name('remember')->check() }}
			<div class="login-btn">
				{{ Former::danger_submit('Entrar')->class('btn btn-danger btn-block') }}
			</div>
			{{ Former::close() }}

	        <br />
	        Ainda não é cadastrado? <a href="{{ route('account.get') }}">Clique aqui e faça já sua conta!</a>
		</div>
	</div>
</div>

@stop
