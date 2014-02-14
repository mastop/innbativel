@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        	'description' => 'required',
        ]) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('description', 'Descrição')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
