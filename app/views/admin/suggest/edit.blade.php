@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'destiny' => 'required',
        	'name' => 'required',
        	'email' => 'required',
        ]) }}

        {{ Former::populate($suggest) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('email', 'E-mail')->class('span12') }}
        {{ Former::text('destiny', 'Destino')->class('span12') }}
        {{ Former::text('suggestion', 'Sugestão')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
