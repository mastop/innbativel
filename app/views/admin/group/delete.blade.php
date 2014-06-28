@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($groupArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($groupArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.group')) }}

        {{ Former::close() }}

    </div>

@stop
