@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($permArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($permArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.perm')) }}

        {{ Former::close() }}

    </div>

@stop
