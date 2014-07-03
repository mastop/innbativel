@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        ]) }}

        {{ Former::populate($perm) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('description', 'Descrição')->class('span12') }}
        {{ Former::select('is_menu', 'Listar no menu?')
                 ->addOption('Não', 0)
                 ->addOption('Sim', 1)
        }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
