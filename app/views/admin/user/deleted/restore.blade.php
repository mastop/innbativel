@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($userArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($userArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Reativar Usuário')
          ->primary_link('Cancelar', route('admin.user')) }}

        {{ Former::close() }}

    </div>

@stop
