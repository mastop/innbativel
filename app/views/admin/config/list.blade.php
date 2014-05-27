@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de configurações</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.config.create') }}" title="Criar Configuração" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.config')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->label('')->class('input-medium')->placeholder('Nome') }}
			{{ Former::text('value')->label('')->class('input-medium')->placeholder('Valor') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.config')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->label('')
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
	{{ Table::headers('ID', 'Nome', 'Valor', 'Ações') }}
	{{ Table::body($config)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Editar', route('admin.config.edit', $body['id'])],
					['Excluir', route('admin.config.delete', $body['id'])],
			    ])
			)->pull_right()->split();
		})
	}}

	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $config->getFrom() }}</strong> a <strong>{{ $config->getTo() }}</strong> registros do total de <strong>{{ $config->getTotal() }}</strong></div>
		{{ $config->links() }}
	</div>
</div>
@stop
