@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        	'geocode' => 'required',
        ]) }}

        {{ Former::populate($saveme) }}

        {{ Former::text('title', 'Título')->class('span12') }}
        {{ Former::text('geocode', 'Geocode')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
