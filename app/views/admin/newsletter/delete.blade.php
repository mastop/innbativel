@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($categoryArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($categoryArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.category')) }}

        {{ Former::close() }}

    </div>

@stop
