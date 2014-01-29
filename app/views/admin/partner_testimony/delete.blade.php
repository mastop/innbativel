@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($partnerTestimonyArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($partnerTestimonyArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir')
          ->primary_link('Cancelar', route('admin.partner_testimony')) }}

        {{ Former::close() }}

    </div>

@stop
