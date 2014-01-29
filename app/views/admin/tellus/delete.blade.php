@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($tellusArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($tellusArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.tellus')) }}

        {{ Former::close() }}

    </div>

@stop
