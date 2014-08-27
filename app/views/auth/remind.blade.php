@section('content')

<div id="main" class="container">

	@if (Session::has('error'))
	  {{ trans(Session::get('reason')) }}
	@elseif (Session::has('success'))
	  An email with the password reset has been sent.
	@endif

	{{ Form::open(array('route' => 'password.request')) }}

	  <p>{{ Form::label('email', 'E-mail') }}
	  {{ Form::text('email') }}</p>

	  <p>{{ Form::submit('Submit') }}</p>

	{{ Form::close() }}

</div>

@stop
