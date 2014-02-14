@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($tagArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($tagArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.tag')) }}

        {{ Former::close() }}

    </div>

@stop
