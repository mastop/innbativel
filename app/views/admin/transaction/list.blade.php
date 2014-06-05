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
			{{ Former::date('date_start')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('date_end')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.transaction')) }}
			{{ Former::link('Exportar pesquisa para excel', 'javascript: exportar(\''.route('admin.transaction.export', ['date_start' => 'date_start', 'date_end' => 'date_end']).'\');') }}
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
	.column-vouchersValue, .column-paid, .column-creditDiscount, .column-couponDiscount, .column-cardBoletusRate, .column-antecipationRate, .column-transfer, .column-gainn, .column-nVouchers{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>Data</th>
			<th>ID da Compra</th>
			<th>Cliente</th>
			<th>Tipo</th>
			<th>Forma de pagamento</th>
			<th style="text-align: right;">Valor dos cupons (R$)</th>
			<th style="text-align: right;">Créditos do usuário (R$)</th>
			<th style="text-align: right;">Cupons de desconto (R$)</th>
			<th style="text-align: right;">Total pago (R$)</th>
			<th style="text-align: right;">Taxa cartão/boleto (R$) *</th>
			<th style="text-align: right;">Taxa de antecipação (R$) **</th>
			<th style="text-align: right;">Valor parceiro (R$) ***</th>
			<th style="text-align: right;">Faturamento (R$)</th>
			<th style="text-align: right;">Número de Cupons</th>
		</tr>
	</thead>
	{{ Table::body($transactions)
		->ignore(['id', 'order_id', 'status', 'total', 'credit_discount', 'coupon_discount', 'created_at', 'updated_at', 'order', 'voucher', 'vouchers', 'transfers', 'gain', 'card_boletus_rate', 'antecipation_rate','display_codes'])
		->date(function($transaction) {
			if(isset($transaction->created_at)){
				return date("d/m/Y H:i:s", strtotime($transaction->created_at));
			}
			return '--';
		})
		->order_id(function($transaction) {
			if(isset($transaction->order->braspag_order_id)){
				return link_to_route('admin.order.view', $transaction->order->braspag_order_id, ['id' => $transaction->order->id]);
			}
			return '--';
		})
		->customer(function($transaction) {
			if(isset($transaction->order->buyer->profile)){
				return $transaction->order->buyer->profile->first_name.(isset($transaction->order->buyer->profile->last_name)?' '.$transaction->order->buyer->profile->last_name:'');
			}
			return '--';
		})
		->statuss(function($transaction) {
			if(isset($transaction->order->braspag_order_id)){
				if($transaction->status == 'pagamento'){
					return '<span class="text-info">'.$transaction->status.'</span>';
				}
				else{
					return '<span class="text-error">'.$transaction->status.'</span>';
				}
			}
			return '--';
		})
		->payment_terms(function($transaction) {
			if(isset($transaction->order)){
				return $transaction->order->payment_terms;
			}
			return '--';
		})
		->vouchersValue(function($transaction) {
			if(isset($transaction->vouchers)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->vouchers, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->vouchers, 2, ',', '.');
				}
			}
		})
		->creditDiscount(function($transaction) {
			if(isset($transaction->credit_discount)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->credit_discount, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->credit_discount, 2, ',', '.');
				}
			}
			return '--';
		})
		->couponDiscount(function($transaction) {
			if(isset($transaction->coupon_discount)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->coupon_discount, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->coupon_discount, 2, ',', '.');
				}
			}
			return '--';
		})
		// ->donation(function($transaction) {
		// 	if(isset($transaction->donation)){
		// 		if($transaction->status == 'pagamento'){
		// 			return number_format($transaction->donation, 2, ',', '.');
		// 		}
		// 		else{
		// 			return number_format(-1 * $transaction->donation, 2, ',', '.');
		// 		}
		// 	}
		// 	return '--';
		// })
		->paid(function($transaction) {
			if(isset($transaction->total)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->total, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->total, 2, ',', '.');
				}
			}
			return '--';
		})
		->cardBoletusRate(function($transaction) {
			if(isset($transaction->order)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->card_boletus_rate, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->card_boletus_rate, 2, ',', '.');
				}
			}
			return '--';
		})
		->antecipationRate(function($transaction) {
			if(isset($transaction->order)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->antecipation_rate, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->antecipation_rate, 2, ',', '.');
				}
			}
			return '--';
		})
		->transfer(function($transaction) {
			if(isset($transaction->transfers)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->transfers, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->transfers, 2, ',', '.');
				}
			}
		})
		->gainn(function($transaction) {
			if(isset($transaction->gain)){
				if($transaction->status == 'pagamento'){
					return number_format($transaction->gain, 2, ',', '.');
				}
				else{
					return number_format(-1 * $transaction->gain, 2, ',', '.');
				}
			}
			return '--';
		})
		->nVouchers(function($transaction) {
			if(isset($transaction->transfers)){
				if($transaction->status == 'pagamento'){
					return count($transaction->voucher);
				}
				else{
					return -1 * count($transaction->voucher);
				}
			}
		})
	}}
	<thead>
		<tr>
			<th>Total</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th style="text-align: right;">{{ number_format($total['vouchers'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['credits'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['coupons'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['paid'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['cardBoletusRate'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['antecipationRate'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['transfer'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($total['gain'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ $total['n_vouchers'] }}</th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $transactions->getFrom() }}</strong> a <strong>{{ $transactions->getTo() }}</strong> registros do total de <strong>{{ $transactions->getTotal() }}</strong></div>
		{{ $transactions->links() }}
	</div>
</div>

<script type="text/javascript">
function exportar(url){
	var date_start = ($('#date_start').val() == '')?'null':$('#date_start').val();
	var date_end = ($('#date_end').val() == '')?'null':$('#date_end').val();

	url = url.replace('/date_start', '/'+date_start);
	url = url.replace('/date_end', '/'+date_end);

	window.location.href = url;
}
</script>
@stop
