@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de "itens inclusos"</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.included.create') }}" title="Criar incluso" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.included')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::text('description')->class('input-medium')->placeholder('Descrição')->label('Descrição') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.included')) }}
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
	{{ Table::headers('ID', 'Título', 'Descrição', 'Ícone', 'Ações') }}
	{{ Table::body($included)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.included.edit', $body['id'])],
					['Excluir', route('admin.included.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $included->getFrom() }}</strong> a <strong>{{ $included->getTo() }}</strong> registros do total de <strong>{{ $included->getTotal() }}</strong></div>
		{{ $included->links() }}
	</div>
</div>

@stop
