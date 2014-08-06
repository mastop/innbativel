@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Transações de Cupons</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.payment') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.payment.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.payment.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
	        {{ Former::text('partner_name')->class('input-medium')->placeholder('Parceiro')->label('Parceiro') }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.payment.voucher')) }}
			{{ Former::link('Exportar pesquisa para excel', 'javascript: exportar(\''.route('admin.payment.voucher_export', ['partner_name'=>'partner_name', 'payment_id'=>'payment_id']).'\');') }}
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
			<th>Número do Pedido</th>
			<th>Cliente</th>
			<th>Código do Cupom</th>
			<th>Oferta e opção escolhida</th>
			<th>Status</th>
			<th style="text-align: right;">Valor do Cupom (R$)</th>
			<th style="text-align: right;">Valor Parceiro (R$)</th>
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
			->order_id(function($data) {
				if(isset($data->voucher->order_customer->braspag_order_id)){
					return link_to_route('admin.order.view', $data->voucher->order_customer->braspag_order_id, ['id' => $data->voucher->order_customer->id]);
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
				if(isset($data->voucher) && isset($data->voucher->offer_option_offer)){
					return $data->voucher->id.'-'.$data->voucher->display_code.'-'.$data->voucher->offer_option_offer->offer_id;
				}
				return '--';
			})
			->offer(function($data) {
				if(isset($data->voucher->offer_option_offer->offer->id)){
					return link_to_route('oferta-nova-ou-antiga', $data->voucher->offer_option_offer->offer->id.' | '.(isset($data->voucher->offer_option_offer->offer->destiny->name)?$data->voucher->offer_option_offer->offer->destiny->name:substr($data->voucher->offer_option_offer->offer->title,0,30).'...'), ['slug' => $data->voucher->offer_option_offer->offer->slug], ['target' => 'blank']).' ('.substr($data->voucher->offer_option_offer->title,0,40).(strlen($data->voucher->offer_option_offer->title)>40?'...':'').')';
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
	var partner_name = ($('#partner_name').val() == '')?'null':$('#partner_name').val();
	var payment_id = ($('#payment_id').val() == '')?'null':$('#payment_id').val();

	url = url.replace('/partner_name', '/'+partner_name);
	url = url.replace('/payment_id', '/'+payment_id);

	window.location.href = url;
};

$(function() {
  var availableTags = [
  	<?php
  		$partners = DB::table('profiles')
  					 ->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')
  					 ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
  					 ->where('roles.id', 9)
  					 ->get(['profiles.first_name', 'profiles.last_name']);

  		foreach ($partners as $partner) {
  			echo '"'.$partner->first_name.' '.$partner->last_name.'", ';
  		}
  	?>
  ];
  $("#partner_name").autocomplete({
    source: availableTags
  });
});
</script>

@stop
