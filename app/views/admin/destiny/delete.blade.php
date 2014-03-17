@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($destinyArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($destinyArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.destiny')) }}

        {{ Former::close() }}

    </div>

@stop
