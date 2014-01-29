@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Ofertas</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>

	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.offer')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->label('')->class('input-medium')->placeholder('Nome') }}
			{{ Former::text('description')->label('')->class('input-medium')->placeholder('Descrição') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.offer')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->label('')
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
	{{ Table::headers('#', 'Título', 'Destino', 'Início', 'Término', 'Ações') }}
	{{ Table::body($offer)
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.offer.edit', $body['id'])],
					['Excluir', route('admin.offer.delete', $body['id'])],
					])
				)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $offer->getFrom() }}</strong> a <strong>{{ $offer->getTo() }}</strong> registros do total de <strong>{{ $offer->getTotal() }}</strong></div>
		{{ $offer->links() }}
	</div>
</div>

@stop
