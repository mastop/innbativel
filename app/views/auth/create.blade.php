@section('content')

<a href="{{ route('login.facebook') }}">
    <img alt="Cadastre-se via Facebook" src="//{{Configuration::get("s3url")}}/facebook-connect.png">
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
