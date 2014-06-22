@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::text('title', 'Nome')->class('span12') }}
        {{ Former::text('display_order', 'Ordem')->class('span12')->value(Holiday::count()+1) }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
