@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de destinos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.destiny.create') }}" title="Criar destino" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.destiny')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.destiny')) }}
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
	{{ Table::headers('ID', 'Nome', 'Ações') }}
	{{ Table::body($destiny)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.destiny.edit', $body['id'])],
					['Excluir', route('admin.destiny.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $destiny->getFrom() }}</strong> a <strong>{{ $destiny->getTo() }}</strong> registros do total de <strong>{{ $destiny->getTotal() }}</strong></div>
		{{ $destiny->links() }}
	</div>
</div>

@stop
