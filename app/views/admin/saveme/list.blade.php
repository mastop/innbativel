@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Permissões</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.saveme.create') }}" title="Criar Permissão" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.saveme')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::text('geocode')->class('input-medium')->placeholder('Geocode')->label('Geocode') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.saveme')) }}
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
	{{ Table::headers('Título', 'Geocode', 'Ações') }}
	{{ Table::body($saveme)
		->ignore(['id', 'created_at', 'updated_at'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.saveme.edit', $body['id'])],
					['Excluir', route('admin.saveme.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $saveme->getFrom() }}</strong> a <strong>{{ $saveme->getTo() }}</strong> registros do total de <strong>{{ $saveme->getTotal() }}</strong></div>
		{{ $saveme->links() }}
	</div>
</div>

@stop
