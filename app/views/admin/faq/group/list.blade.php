@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Grupos de FAQs</h6>
	        <div class="nav pull-right">
	            <span class="dropdown-toggle navbar-icon">Grupos de FAQs:</span>
	            <a href="{{ route('admin.faq.group') }}" title="Listar Grupos de FAQs" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.faq.group.create') }}" title="Criar Grupo de FAQ" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <span class="dropdown-toggle navbar-icon">FAQs:</span>
	            <a href="{{ route('admin.faq') }}" title="Listar FAQs" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.faq.create') }}" title="Criar FAQ" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <a href="{{ route('admin.faq.sort') }}" title="Ordenar FAQs" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.faq.group')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.faq.group')) }}
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
	{{ Table::headers('Título', 'Ações') }}
	{{ Table::body($faqGroup)
		->ignore(['id', 'display_order'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Editar', route('admin.faq.group.edit', $body['id'])],
					['Excluir', route('admin.faq.group.delete', $body['id'])],
			    ])
			)->pull_right()->split();
		})
	}}

	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $faqGroup->getFrom() }}</strong> a <strong>{{ $faqGroup->getTo() }}</strong> registros do total de <strong>{{ $faqGroup->getTotal() }}</strong></div>
		{{ $faqGroup->links() }}
	</div>
</div>
@stop
