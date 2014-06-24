@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($holidayArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($holidayArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.holiday')) }}

        {{ Former::close() }}

    </div>

@stop
