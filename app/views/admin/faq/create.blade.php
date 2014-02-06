@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'question' => 'required',
			'answer' => 'required',
			'group_title' => 'required',
        ]) }}

        {{ Former::text('question', 'Pergunta')->class('span12') }}
        {{ Former::text('answer', 'Resposta')->class('span12') }}
        {{ Former::text('group_title', 'Grupo')->class('span12') }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
