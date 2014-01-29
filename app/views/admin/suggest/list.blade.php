@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Sugestões de Viagens</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.suggest.create') }}" title="Criar Permissão" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.suggest')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('destiny')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::text('suggestion')->class('input-medium')->placeholder('Sugestão')->label('Sugestão') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail')->label('E-mail') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.suggest')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
	{{ Table::open() }}
	{{ Table::headers('Destino', 'Sugestão', 'Nome', 'E-mail', 'Ações') }}
	{{ Table::body($suggest)
		->ignore(['id', 'created_at', 'updated_at'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.suggest.edit', $body['id'])],
					['Excluir', route('admin.suggest.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $suggest->getFrom() }}</strong> a <strong>{{ $suggest->getTo() }}</strong> registros do total de <strong>{{ $suggest->getTotal() }}</strong></div>
		{{ $suggest->links() }}
	</div>
</div>

@stop
