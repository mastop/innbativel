@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'name' => 'required',
        	'description' => 'required',
        	'img' => 'required',
        ]) }}

        {{ Former::text('name', 'Nome')->class('span12') }}
        {{ Former::text('description', 'Descrição')->class('span12') }}
        {{ Former::file('img', 'Imagem (NN x MM)')->accept('png', 'jpg', 'jpeg')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
