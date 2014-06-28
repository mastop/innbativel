@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de "grupos"</h6>
	        <div class="nav pull-right">
	        	<a href="{{ route('admin.group.order') }}" title="Popular e Ordenar Grupos de Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-filter"></i></a>
	            <a href="{{ route('admin.group.create') }}" title="Criar Grupo" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.group')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.group')) }}
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
	{{ Table::headers('ID', 'Título', 'URL (link do grupo)', 'Ícone', 'Ordem', 'Ações') }}
	{{ Table::body($group)
		->ignore(['icon', 'display_order'])
        ->iconn(function($body) {
            if(isset($body->icon)){
                return '<span class="entypo entypo-'.$body->icon.'"></span>';
            }
            return '--';
        })
        ->display_orderr(function($body) {
            if(isset($body->display_order)){
                return $body->display_order;
            }
            return '--';
        })
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.group.edit', $body['id'])],
					['Excluir', route('admin.group.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $group->getFrom() }}</strong> a <strong>{{ $group->getTo() }}</strong> registros do total de <strong>{{ $group->getTotal() }}</strong></div>
		{{ $group->links() }}
	</div>
</div>

@stop
