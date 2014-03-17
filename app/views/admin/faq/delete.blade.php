@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($faqArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($faqArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir FAQ')
          ->primary_link('Cancelar', route('admin.faq')) }}

        {{ Former::close() }}

    </div>

@stop
