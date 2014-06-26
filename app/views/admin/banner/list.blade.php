@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Banners</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.banner.create') }}" title="Criar ONG" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.banner')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
            {{ Former::select('is_active', 'Ativo')
            ->addOption('Todos', -1)
            ->options(array('Inativos', 'Ativos'))
            }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.banner')) }}
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
	{{ Table::headers('ID', 'Título', 'Imagem', 'Link', 'Cliques', 'Ativo', 'Ações') }}
	{{ Table::body($banner)
		->ignore(['is_active'])
		->img(function($body) {
			if(isset($body->img)){
				return '<img src="'.$body->img.'" style="max-width: 100px;"/>';
			}
			return '--';
		})
        ->ativo(function($body) {
			if($body->is_active){
				return 'Sim';
			}
			return 'Não';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.banner.edit', $body['id'])],
					['Excluir', route('admin.banner.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $banner->getFrom() }}</strong> a <strong>{{ $banner->getTo() }}</strong> registros do total de <strong>{{ $banner->getTotal() }}</strong></div>
		{{ $banner->links() }}
	</div>
</div>

@stop
