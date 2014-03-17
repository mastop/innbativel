@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($roleArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($roleArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir Papél')
          ->primary_link('Cancelar', route('admin.role')) }}

        {{ Former::close() }}

    </div>

@stop
