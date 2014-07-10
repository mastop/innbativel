@section('content')
    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
            'pass' => 'required',
            'newpass' => 'required|min:6|confirmed',
            'newpass_confirmation' => 'required|min:6',
        ]) }}

        {{ Former::password('pass', 'Senha atual')->class('span12') }}
        {{ Former::password('newpass', 'Nova senha')->class('span12') }}
        {{ Former::password('newpass_confirmation', 'Repita nova senha')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
