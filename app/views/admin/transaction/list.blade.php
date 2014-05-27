@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Transações</h6>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.transaction')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.transaction')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        	->select($pag)
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
	<style type="text/css">
	.column-voucherValue, .column-paid, .column-transfer, .column-cardTax, .column-antecipationTax, .column-gain{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>Data</th>
			<th>Cliente</th>
			<th>Compra</th>
			<th>Tipo</th>
			<th style="text-align: right;">Valor do cupom (R$)</th>
			<th style="text-align: right;">Total pago (R$)</th>
			<th style="text-align: right;">Valor parceiro (R$)</th>
			<th style="text-align: right;">Taxa cartão/boleto (R$)</th>
			<th style="text-align: right;">Taxa de antecipação (R$)</th>
			<th style="text-align: right;">Faturamento (R$)</th>
		</tr>
	</thead>
	{{ Table::body($transaction)
		->ignore(['id', 'order_id', 'status', 'total', 'credit_discount', 'coupon_discount', 'created_at', 'updated_at', 'order'])
		->date(function($transaction) {
			if(isset($transaction->created_at)){
				return date("d/m/Y H:i:s", strtotime($transaction->created_at));
			}
			return '--';
		})
		->customer(function($transaction) {
			if(isset($transaction->order->buyer->profile)){
				return $transaction->order->buyer->profile->first_name.(isset($transaction->order->buyer->profile->last_name)?' '.$transaction->order->buyer->profile->last_name:'');
			}
			return '--';
		})
		->orderr(function($transaction) {
			if(isset($transaction->status)){
				return link_to_route('admin.order.view', $transaction->order->braspag_order_id, ['id' => $transaction->order->id]);
			}
			return '--';
		})
		->statuss(function($transaction) {
			if(isset($transaction->order->braspag_order_id)){
				return $transaction->status;
			}
			return '--';
		})
		->voucherValue(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
		->paid(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
		->transfer(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
		->cardTax(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
		->antecipationTax(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
		->gain(function($transaction) {
			if(isset($transaction->created_at)){
				return '--';
			}
			return '--';
		})
	}}
	<thead>
		<tr>
		<th>Total</th>
		<th></th>
		<th></th>
		<th></th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format(1, 2, ',', '.') }}</th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $transaction->getFrom() }}</strong> a <strong>{{ $transaction->getTo() }}</strong> registros do total de <strong>{{ $transaction->getTotal() }}</strong></div>
		{{ $transaction->links() }}
	</div>
</div>

@stop
