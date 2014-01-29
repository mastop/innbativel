@section('content')
    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules(['email' => 'required|email']) }}

        {{ Former::email('email', 'E-mail')->class('span12') }}
        {{ Former::password('password', 'Senha')->class('span12') }}
        {{ Former::password('password_confirmation', 'Confirmação de Senha')->class('span12') }}
        {{ Former::text('profile[first_name]', 'Nome')->class('span12') }}
        {{ Former::text('profile[last_name]', 'Sobrenome')->class('span12') }}
        {{ Former::text('profile[city]', 'Cidade')->class('span12') }}
        {{ Former::select('profile[state]', 'Estado')
        	->addOption('-- selecione uma opção --', null)
        	->fromQuery(DB::table('states')->get(['id', 'name']), 'name', 'id')
        	->class('span12')
        }}
        {{ Former::text('profile[country]', 'País')->class('span12') }}
        {{ Former::text('profile[telephone]', 'Telefone')->class('span12') }}
        {{ Former::text('profile[cpf]', 'CPF')->class('span12') }}
        {{ Former::text('profile[birthday]', 'Nascimento')->class('span12') }}
        {{ Former::text('profile[street]', 'Endereço')->class('span12') }}
        {{ Former::text('profile[number]', 'Número')->class('span12') }}
        {{ Former::text('profile[neighborhood]', 'Bairro')->class('span12') }}
        {{ Former::text('profile[zip]', 'CEP')->class('span12') }}
        {{ Former::text('profile[complement]', 'Complemento')->class('span12') }}
        {{ Former::checkboxes('roles', 'Papéis de Usuário') }}

 		{{ Former::hidden('username') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
