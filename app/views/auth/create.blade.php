@section('content')

<a href="{{ route('login.facebook') }}">
    <img alt="Cadastre-se via Facebook" src="//innbativel.s3.amazonaws.com/facebook-connect.png">
</a>
<br /><br />
<div class="account-create">
	{{ $form }}
</div>

<br>
<br>
<br>
<br>

@stop
