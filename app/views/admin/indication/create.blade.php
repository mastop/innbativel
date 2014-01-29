@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'user_id' => 'required|integer',
            'email' => 'required|email',
        ]) }}

        {{ Former::select('user_id', 'Cliente')
                 ->addOption('-- selecione uma opção --', null)
                 ->fromQuery(DB::table('users')->get(['id', 'email']), 'email', 'id')
                 ->class('span12')
        }}
        {{ Former::text('name', 'Nome do indicado')->class('span12') }}
        {{ Former::text('email', 'E-mail do indicado')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
