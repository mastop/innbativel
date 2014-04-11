@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($contractArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($contractArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.contract')) }}

        {{ Former::close() }}

    </div>

@stop
