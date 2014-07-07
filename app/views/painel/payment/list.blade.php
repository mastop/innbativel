@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pagamentos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('painel.payment') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.payment')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('id')->class('input-medium')->placeholder('ID')->label('ID') }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('painel.payment')) }}
			{{ Former::link('Exportar pesquisa para excel', 'javascript: exportar(\''.route('painel.payment.export', ['id'=>'id', 'payment_id'=>'payment_id']).'\');') }}
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
	.column-totall{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>ID</th>
			<th>Período</th>
			<th>Data a ser pago</th>
			<th>Data do pagamento</th>
			<th style="text-align: right;">Valor Total das Vendas (R$)</th>
			<th>Ações</th>
		</tr>
	</thead>
	{{ Table::body($paymentPartnerData)
			->ignore(['id', 'partner_id', 'payment_id', 'total', 'paid_on', 'payment', 'partner'])
			->idd(function($data) {
				if(isset($data['id'])){
					return $data['payment_id'];
				}
				return '--';
			})
			->period(function($data) {
				if(isset($data['payment']['sales_from'])){
					return date("d/m/Y H:i:s", strtotime($data['payment']['sales_from'])).' - '.date("d/m/Y H:i:s", strtotime($data['payment']['sales_to']));
				}
				return '--';
			})
			->date(function($data) {
				if(isset($data['payment']['date'])){
					return date("d/m/Y", strtotime($data['payment']['date']));
				}
				return '--';
			})
			->paid_onn(function($data) {
				return $data['paid_on'] != '0000-00-00 00:00:00'?date("d/m/Y", strtotime($data['paid_on'])):'<span class="text-error">Não pago</span>';
			})
			->totall(function($data) {
				if(isset($data['total'])){
					return number_format($data['total'], 2, ',', '.');
				}
				return '--';
			})
			->acoes(function($data) {
				return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Ver mais detalhes', route('painel.payment.voucher', ['payment_id' => $data['payment']['id']])],
				    ])
				)->pull_right()->split();
			})
			
	}}
	<thead>
		<tr>
			<th>Total</th>
			<th></th>
			<th></th>
			<th></th>
			<th style="text-align: right;">{{ number_format($totals['transfer'], 2, ',', '.') }}</th>
			<th></th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $paymentPartnerData->getFrom() }}</strong> a <strong>{{ $paymentPartnerData->getTo() }}</strong> registros do total de <strong>{{ $paymentPartnerData->getTotal() }}</strong></div>
		{{ $paymentPartnerData->links() }}
	</div>
</div>

<script type="text/javascript">
function exportar(url){
	var id = ($('#id').val() == '')?'null':$('#id').val();
	var payment_id = ($('#payment_id').val() == '')?'null':$('#payment_id').val();

	url = url.replace('/id', '/'+id);
	url = url.replace('/payment_id', '/'+payment_id);

	window.location.href = url;
};
</script>

@stop
