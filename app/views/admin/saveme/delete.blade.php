@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($savemeArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($savemeArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')

          ->primary_link('Cancelar', route('admin.saveme')) }}
        {{ Former::close() }}

    </div>

@stop
