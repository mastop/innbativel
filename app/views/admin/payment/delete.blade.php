@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($paymentArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($paymentArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Excluir Período')
          ->primary_link('Cancelar', route('admin.payment.period')) }}

        {{ Former::close() }}

    </div>

@stop
