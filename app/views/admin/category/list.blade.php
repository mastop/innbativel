@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Categorias</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.category.create') }}" title="Criar Categoria" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <a href="{{ route('admin.category.sort') }}" title="Ordenar Categorias" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.category')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.category')) }}
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
	{{ Table::headers('Título', 'Ordem', 'Ações') }}
	{{ Table::body($category)
		->ignore(['id', 'slug', 'created_at', 'updated_at'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Ordenar subcategorias', route('admin.category.sort_sub', $body['id'])],
					['Editar', route('admin.category.edit', $body['id'])],
					['Excluir', route('admin.category.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $category->getFrom() }}</strong> a <strong>{{ $category->getTo() }}</strong> registros do total de <strong>{{ $category->getTotal() }}</strong></div>
		{{ $category->links() }}
	</div>
</div>

@stop
