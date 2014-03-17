@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($configArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($configArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir Configuração')
          ->primary_link('Cancelar', route('admin.user')) }}

        {{ Former::close() }}

    </div>

@stop
