@section('content')
    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
            'password' => 'required',
        ]) }}

        {{ Former::uneditable('email', 'E-mail')->class('span12') }}
        {{ Former::uneditable('profile[first_name]', 'Nome')->class('span12') }}
        {{ Former::uneditable('profile[company_name]', 'Razão Social')->class('span12') }}
        {{ Former::password('password', 'Nova senha')->class('span12') }}

		{{ Former::hidden('username') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
