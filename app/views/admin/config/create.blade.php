@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'value' => 'required',
        ]) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::textarea('value', 'Valor')->class('span12')->value(' ') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>
@stop
