@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($faqGroupArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($faqGroupArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir Grupo de FAQs')
          ->primary_link('Cancelar', route('admin.faq.group')) }}

        {{ Former::close() }}

    </div>

@stop
