@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($partnerArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($partnerArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Reativar Parceiro')
          ->primary_link('Cancelar', route('admin.partner')) }}

        {{ Former::close() }}

    </div>

@stop
