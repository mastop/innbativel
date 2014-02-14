@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($includedArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($includedArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.included')) }}

        {{ Former::close() }}

    </div>

@stop
