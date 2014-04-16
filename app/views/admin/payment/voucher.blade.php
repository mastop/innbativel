@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pagamentos aos Parceiros</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.payment.voucher') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.payment.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('partner_id', 'Parceiro')
	        	->addOption('', null)
				->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.id', 9), 'name', 'id')
	        }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.payment.voucher')) }}
			{{ Former::link('Exportar pesquisa para excel', 'javascript: exportar(\''.route('admin.payment.voucher_export', ['status'=>'status', 'terms'=>'terms', 'name'=>'name', 'email'=>'email', 'braspag_order_id'=>'braspag_order_id', 'offer_id'=>'offer_id', 'date_start'=>'date_start', 'date_end'=>'date_end']).'\');') }}
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
	.column-transfer, .column-price{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>Data</th>
			<th>ID da Compra</th>
			<th>Cliente</th>
			<th>Código do Cupom</th>
			<th>Oferta e opção escolhida</th>
			<th>Status</th>
			<th style="text-align: right;">Valor do Cupom (R$)</th>
			<th style="text-align: right;">Valor Parceiro (R$)</th>
		</tr>
	</thead>
	{{ Table::body($transactionVoucherData)
			->ignore(['id', 'transaction_id', 'voucher_id', 'payment_partner_id', 'status', 'transaction', 'voucher'])
			->date(function($data) {
				if(isset($data['transaction']['created_at'])){
					return date("d/m/Y H:i:s", strtotime($data['transaction']['created_at']));
				}
				return '--';
			})
			->order_id(function($data) {
				if(isset($data['transaction']['order']['braspag_order_id'])){
					return $data['transaction']['order']['braspag_order_id'];
				}
				return '--';
			})
			->customer(function($data) {
				if(isset($data['transaction']['order']['user']['first_name'])){
					return $data['transaction']['order']['user']['first_name'].' '.$data['transaction']['order']['user']['last_name'];
				}
				return '--';
			})
			->voucherr(function($data) {
				if(isset($data['voucher'])){
					return $data['voucher']['id'].'-'.$data['voucher']['display_code'].'-'.$data['voucher']['offer_option']['offer_id'];
				}
				return '--';
			})
			->offer(function($data) {
				if(isset($data['voucher']['offer_option']['offer_id'])){
					return $data['voucher']['offer_option']['offer_id'].' | '.$data['voucher']['offer_option']['offer_title'].' ('.$data['voucher']['offer_option']['title'].')';
				}
				return '--';
			})
			->statuss(function($data) {
				if(isset($data['status'])){
					if($data['status'] == 'pagamento'){
						return '<span class="text-info">'.$data['status'].'</span>';
					}
					else{
						return '<span class="text-error">'.$data['status'].'</span>';
					}
				}
				return '--';
			})
			->price(function($data) {
				if(isset($data['voucher']['offer_option']['price_with_discount'])){
					if($data['status'] == 'pagamento'){
						return number_format($data['voucher']['offer_option']['price_with_discount'], 2, ',', '.');
					}
					else{
						return number_format(($data['voucher']['offer_option']['price_with_discount'] * -1), 2, ',', '.');
					}
				}
				return '--';
			})
			->transfer(function($data) {
				if(isset($data['voucher']['offer_option']['transfer'])){
					if($data['status'] == 'pagamento'){
						return number_format($data['voucher']['offer_option']['transfer'], 2, ',', '.');
					}
					else{
						return number_format(($data['voucher']['offer_option']['transfer'] * -1), 2, ',', '.');
					}
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
		<th></th>
		<th></th>
		<th style="text-align: right;">{{ number_format($totals['voucher_price'], 2, ',', '.') }}</th>
		<th style="text-align: right;">{{ number_format($totals['transfer'], 2, ',', '.') }}</th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $transactionVoucherData->getFrom() }}</strong> a <strong>{{ $transactionVoucherData->getTo() }}</strong> registros do total de <strong>{{ $transactionVoucherData->getTotal() }}</strong></div>
		{{ $transactionVoucherData->links() }}
	</div>
</div>

@stop
