@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::text('title', 'Título')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
