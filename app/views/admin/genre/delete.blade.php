@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($genreArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($genreArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.genre')) }}

        {{ Former::close() }}

    </div>

@stop
