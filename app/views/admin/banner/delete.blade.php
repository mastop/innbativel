@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($bannerArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($bannerArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.banner')) }}

        {{ Former::close() }}

    </div>

@stop
