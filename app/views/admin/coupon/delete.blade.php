@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open() }}

        {{ Former::populate($couponArray) }}

        <div class="widget">
        	<div class="body">
        		{{ Typography::horizontal_dl($couponArray) }}
        	</div>
        </div>

        {{ Former::actions()
          ->danger_submit('Desativar')
          ->primary_link('Voltar', route('admin.coupon')) }}

        {{ Former::close() }}

    </div>

@stop
