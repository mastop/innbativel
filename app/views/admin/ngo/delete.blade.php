@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($ngoArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($ngoArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.ngo')) }}

        {{ Former::close() }}

    </div>

@stop
