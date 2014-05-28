@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Tipos de Usuários</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.role.create') }}" title="Criar Tipo de Usuário" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.role')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->label('')->class('input-medium')->placeholder('Nome') }}
			{{ Former::text('level')->label('')->class('input-medium')->placeholder('Nível') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.role')) }}
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
	{{ Table::headers('ID', 'Nome', 'Nível', 'Ações') }}
	{{ Table::body($role)
		->ignore(['created_at', 'updated_at'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.role.edit', $body['id'])],
					['Excluir', route('admin.role.delete', $body['id'])],
					])
				)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $role->getFrom() }}</strong> a <strong>{{ $role->getTo() }}</strong> registros do total de <strong>{{ $role->getTotal() }}</strong></div>
		{{ $role->links() }}
	</div>
</div>

@stop
