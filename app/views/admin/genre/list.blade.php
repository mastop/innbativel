@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Gêneros</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.genre.create') }}" title="Criar ONG" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.genre')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.genre')) }}
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
	{{ Table::headers('Nome', 'Ícone', 'Ações') }}
	{{ Table::body($genre)
		->ignore(['id', 'created_at', 'updated_at'])
		->icon(function($body) {
			if(isset($body->icon)){
				return '<span class="map-icon map-icon-'.$body->icon.'"></span>';
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.genre.edit', $body['id'])],
					['Excluir', route('admin.genre.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $genre->getFrom() }}</strong> a <strong>{{ $genre->getTo() }}</strong> registros do total de <strong>{{ $genre->getTotal() }}</strong></div>
		{{ $genre->links() }}
	</div>
</div>

@stop
