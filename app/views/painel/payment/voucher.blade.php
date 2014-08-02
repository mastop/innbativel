@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Transações de Cupons</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('painel.payment.voucher') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.payment.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('painel.payment.voucher')) }}
			{{ Former::link('Exportar pesquisa para excel', 'javascript: exportar(\''.route('painel.payment.voucher_export', ['payment_id'=>'payment_id']).'\');') }}
			<div class="dataTables_length">
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        	->addOption('1000', '1000')
	        	->addOption('10000', '10000')
	        	->select($pag)
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>

	<style type="text/css">
	.column-qty, .column-transfer, .column-price{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>Data</th>
			<th>Cliente</th>
			<th>Código do Cupom</th>
			<th>Oferta e opção escolhida</th>
			<th>Status</th>
			<th style="text-align: right;">Valor do Cupom (R$)</th>
			<th style="text-align: right;">Valor a Receber (R$)</th>
			<th style="text-align: right;">Quantidade</th>
		</tr>
	</thead>
	{{ Table::body($transactionVoucherData)
			->ignore(['id', 'transaction_id', 'voucher_id', 'payment_partner_id', 'status', 'created_at', 'updated_at', 'voucher'])
			->date(function($data) {
				if(isset($data->created_at)){
					return date("d/m/Y H:i:s", strtotime($data->created_at));
				}
				return '--';
			})
			
			->customer(function($data) {
				if(isset($data->voucher->order_customer->buyer) && isset($data->voucher->order_customer->buyer->profile)){
					return $data->voucher->order_customer->buyer->profile->first_name.' '.$data->voucher->order_customer->buyer->profile->last_name;
				}
				return '--';
			})
			->voucherr(function($data) {
				if(isset($data->voucher)){
					return $data->voucher->id.'-'.$data->voucher->display_code.'-'.$data->voucher->offer_option_offer->offer->id;
				}
				return '--';
			})
			->offer(function($data) {
				if(isset($data->voucher->offer_option_offer->offer->id)){
					return link_to_route('oferta', $data->voucher->offer_option_offer->offer->id.' | '.$data->voucher->offer_option_offer->offer->title, ['slug' => $data->voucher->offer_option_offer->offer->slug]).' ('.$data->voucher->offer_option_offer->title.')';
				}
				return '--';
			})
			->statuss(function($data) {
				if(isset($data->status)){
					if($data->status == 'pagamento'){
						return '<span class="text-info">'.$data->status.'</span>';
					}
					else{
						return '<span class="text-error">'.$data->status.'</span>';
					}
				}
				return '--';
			})
			->price(function($data) {
				if(isset($data->voucher->offer_option_offer->price_with_discount)){
					if($data->status == 'pagamento'){
						return number_format($data->voucher->offer_option_offer->price_with_discount, 2, ',', '.');
					}
					else{
						return number_format(($data->voucher->offer_option_offer->price_with_discount * -1), 2, ',', '.');
					}
				}
				return '--';
			})
			->transfer(function($data) {
				if(isset($data->voucher->offer_option_offer->transfer)){
					if($data->status == 'pagamento'){
						return number_format($data->voucher->offer_option_offer->transfer, 2, ',', '.');
					}
					else{
						return number_format(($data->voucher->offer_option_offer->transfer * -1), 2, ',', '.');
					}
				}
				return '--';
			})
			->qty(function($data) {
				return $data->status == 'pagamento' ? 1 : -1;
			})
	}}
	<thead>
		<tr>
			<th>Total</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th style="text-align: right;">{{ number_format($totals['voucher_price'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ number_format($totals['transfer'], 2, ',', '.') }}</th>
			<th style="text-align: right;">{{ $totals['n_vouchers'] }}</th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $transactionVoucherData->getFrom() }}</strong> a <strong>{{ $transactionVoucherData->getTo() }}</strong> registros do total de <strong>{{ $transactionVoucherData->getTotal() }}</strong></div>
		{{ $transactionVoucherData->links() }}
	</div>
</div>

<script type="text/javascript">
function exportar(url){
	var payment_id = ($('#payment_id').val() == '')?'null':$('#payment_id').val();

	url = url.replace('/payment_id', '/'+payment_id);

	window.location.href = url;
};
</script>

@stop
