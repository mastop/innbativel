@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de ONGs</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.ngo.create') }}" title="Criar ONG" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.ngo')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('description')->class('input-medium')->placeholder('Descrição')->label('Descrição') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.ngo')) }}
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
	{{ Table::headers('ID', 'Nome', 'Descrição', 'Imagem', 'Ações') }}
	{{ Table::body($ngo)
		->ignore(['img', 'created_at', 'updated_at'])
		->image(function($body) {
			if(isset($body->img)){
				return '<img src="'.$body->img.'"/>';
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.ngo.edit', $body['id'])],
					['Excluir', route('admin.ngo.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $ngo->getFrom() }}</strong> a <strong>{{ $ngo->getTo() }}</strong> registros do total de <strong>{{ $ngo->getTotal() }}</strong></div>
		{{ $ngo->links() }}
	</div>
</div>

@stop
