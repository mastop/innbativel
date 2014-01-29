@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($subcategoryArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($subcategoryArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.subcategory')) }}

        {{ Former::close() }}

    </div>

@stop
