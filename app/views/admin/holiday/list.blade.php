@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de feriados</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.holiday.create') }}" title="Criar feriado" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.holiday')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Nome do Feriado')->label('Feriado') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.holiday')) }}
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
	{{ Table::headers('ID', 'Nome', 'Ordem', 'Ações') }}
	{{ Table::body($holiday)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.holiday.edit', $body['id'])],
					['Excluir', route('admin.holiday.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $holiday->getFrom() }}</strong> a <strong>{{ $holiday->getTo() }}</strong> registros do total de <strong>{{ $holiday->getTotal() }}</strong></div>
		{{ $holiday->links() }}
	</div>
</div>

@stop
