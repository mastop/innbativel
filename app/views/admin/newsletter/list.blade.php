@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Usuários cadastrados na newsletter</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.newsletter') }}" title="Adicionar à Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.newsletter')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Informe um nome para pesquisar')->label('Nome') }}
            {{ Former::text('email')->class('input-medium')->placeholder('Informe um e-mail para pesquisar')->label('E-mail') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.newsletter')) }}
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
	{{ Table::headers('Nome', 'E-mail', 'Ações') }}
	{{ Table::body($newsletter)
		->ignore(['id', 'updated_at'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.category.edit', $body['id'])],
					['Excluir', route('admin.category.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $newsletter->getFrom() }}</strong> a <strong>{{ $newsletter->getTo() }}</strong> registros do total de <strong>{{ $newsletter->getTotal() }}</strong></div>
		{{ $newsletter->links() }}
	</div>
</div>

@stop
