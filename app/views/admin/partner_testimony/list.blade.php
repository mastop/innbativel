@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de depoimentos do Conte pra Gente</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.partner_testimony.create') }}" title="Criar Depoimento" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.partner_testimony.sort') }}" title="Ordenar Depoimentos" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.partner_testimony')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('destiny')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::text('sponsor')->class('input-medium')->placeholder('Responsável')->label('Responsável') }}
			{{ Former::text('role')->class('input-medium')->placeholder('Cargo do responsável')->label('Cargo do responsável') }}
			{{ Former::text('testimony')->class('input-medium')->placeholder('Depoimento')->label('Depoimetno') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.partner_testimony')) }}
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
	{{ Table::headers('Nome', 'Destino', 'Responsável', 'Cargo do responsável', 'Depoimento', 'Ordem de exibição', 'Imagem', 'Ações') }}
	{{ Table::body($partner_testimony)
		->ignore(['id', 'img', 'created_at', 'updated_at'])
		->image(function($body) {
			if(isset($body->img)){
				return '<a href="'.$body->img.'">Link para a imagem</a>';
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.partner_testimony.edit', $body['id'])],
					['Excluir', route('admin.partner_testimony.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $partner_testimony->getFrom() }}</strong> a <strong>{{ $partner_testimony->getTo() }}</strong> registros do total de <strong>{{ $partner_testimony->getTotal() }}</strong></div>
		{{ $partner_testimony->links() }}
	</div>
</div>

@stop
