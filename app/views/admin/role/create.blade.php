@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required|alpha',
        	'description' => 'required',
        	'level' => 'required|numeric',
        ]) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('description', 'Descrição')->class('span12') }}
        {{ Former::text('level', 'Nível')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
