@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Subcategorias</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.subcategory.create') }}" title="Criar Subcategoria" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.subcategory')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
	        {{ Former::select('category_id', 'Categoria')
	        	->addOption('', null)
				->fromQuery(DB::table('categories')
							  ->orderBy('display_order', 'asc')
							  ->get(['id', 'title'])
							,'title','id')
	        }}
	        {{ Former::select('is_active', 'Ativa?')
	        	->addOption('', null)
	        	->addOption('Sim', 1)
	        	->addOption('Não', 0)
	        }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.subcategory')) }}
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
	{{ Table::headers('Título', 'Ordem', 'Categoria', 'Ativa?', 'Ações') }}
	{{ Table::body($subcategory)
		->ignore(['id', 'is_active', 'category_id','created_at', 'updated_at'])
		->category(function($body) {
			return isset($body['category']->title)?$body['category']->title:'--';
		})
		->is_active(function($body) {
			return ($body->is_active == 1)?'Sim':'Não';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
						['Editar', route('admin.subcategory.edit', $body['id'])],
						['Excluir', route('admin.subcategory.delete', $body['id'])],
					])
				)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $subcategory->getFrom() }}</strong> a <strong>{{ $subcategory->getTo() }}</strong> registros do total de <strong>{{ $subcategory->getTotal() }}</strong></div>
		{{ $subcategory->links() }}
	</div>
</div>

@stop
