@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'question' => 'required',
			    'answer' => 'required',
        ]) }}

        {{ Former::populate($faq) }}

        {{ Former::text('question', 'Pergunta')->class('span12') }}
        {{ Former::textarea('answer', 'Resposta')->rows(10)->columns(20)->class('span12 redactor') }}
        {{ Former::select('faq_group_id', 'Grupo')
                 ->addOption('-- selecione uma opção --', null)
                 ->fromQuery(DB::table('faqs_groups')->select(['id', 'title'])->orderBy('display_order', 'asc'), 'title', 'id')
                 ->class('span12')
        }}

        {{ Former::actions()
          ->primary_submit('Enviar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

    <script type="text/javascript">
    $('.redactor').redactor({
        lang: 'pt_br',
        linebreaks: true,
        observeLinks: true,
        convertVideoLinks: true,
        plugins: ['fontsize'],
        buttons: ['html', 'formatting',  'bold', 'italic', 'unorderedlist', 'orderedlist', 'image', 'video', 'file', 'table', 'link', 'alignment', 'horizontalrule']
    });
    </script>

@stop
