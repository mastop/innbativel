@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Logs</h6>
	        <div class="nav pull-right">
	            
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.log')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('type')->class('input-medium')->placeholder('Tipo')->label('Tipo') }}
			{{ Former::text('message')->class('input-medium')->placeholder('Mensagem')->label('Mensagem') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.log')) }}
			{{ Former::link('Zerar os Logs', route('admin.log.reset'))->class('btn btn-danger') }}
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
	{{ Table::open() }}
	{{ Table::headers('ID', 'Tipo', 'Mensagem', 'Criado em', 'Atualizado em', 'Ações') }}
	{{ Table::body($log)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Excluir', route('admin.log.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $log->getFrom() }}</strong> a <strong>{{ $log->getTo() }}</strong> registros do total de <strong>{{ $log->getTotal() }}</strong></div>
		{{ $log->links() }}
	</div>
</div>

@stop
