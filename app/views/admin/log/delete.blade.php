@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($logArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($logArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.log')) }}

        {{ Former::close() }}

    </div>

@stop
