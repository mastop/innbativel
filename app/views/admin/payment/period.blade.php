@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Períodos de Fechamentos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.payment') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.payment.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	            <a href="{{ route('admin.payment.period') }}" title="Listar períodos de fechamentos" class="dropdown-toggle navbar-icon"><i class="icon-time"></i></a>
	            <a href="{{ route('admin.payment.create') }}" title="Criar período de fechamento" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.payment.period')) }}
			{{ Former::label('Pesquisar: ') }}
	        {{ Former::select('id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.payment.period')) }}
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

	{{ Table::open() }}
	{{ Table::headers('Vendas de', 'Vendas até', 'Data a pagar', 'Fechamento realizado?', 'Ação') }}
	{{ Table::body($paymentData)
			->ignore(['id', 'sales_from', 'sales_to', 'date', 'is_sales_close', 'cronjob'])
			->from(function($data) {
				if(isset($data['sales_from'])){
					return date("d/m/Y H:i:s", strtotime($data['sales_from']));
				}
				return '--';
			})
			->to(function($data) {
				if(isset($data['sales_to'])){
					return date("d/m/Y H:i:s", strtotime($data['sales_to']));
				}
				return '--';
			})
			->datee(function($data) {
				if(isset($data['date'])){
					return date("d/m/Y", strtotime($data['date']));
				}
				return '--';
			})
			->is_sales_closee(function($data) {
				if(isset($data['is_sales_close'])){
					return $data['is_sales_close'] == true ? 'Sim' : 'Não';
				}
				return '--';
			})
			->acoes(function($data) {
				if(strtotime($data['date']) > strtotime('now')){
					return DropdownButton::normal('Ações',
					  	Navigation::links([
							['Editar', route('admin.payment.edit', $data['id'])],
							['Excluir', route('admin.payment.delete', $data['id'])],
					    ])
					)->pull_right()->split();
				}
			})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $paymentData->getFrom() }}</strong> a <strong>{{ $paymentData->getTo() }}</strong> registros do total de <strong>{{ $paymentData->getTotal() }}</strong></div>
		{{ $paymentData->links() }}
	</div>
</div>


@stop
