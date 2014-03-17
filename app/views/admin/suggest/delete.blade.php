@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($suggestArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($suggestArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.suggest')) }}

        {{ Former::close() }}

    </div>

@stop
