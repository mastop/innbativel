@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de FAQs</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.faq.create') }}" title="Criar FAQ" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.faq')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('question')->class('input-medium')->placeholder('Pergunta')->label('Pergunta') }}
			{{ Former::text('answer')->class('input-medium')->placeholder('Resposta')->label('Resposta') }}
			{{ Former::text('group_title')->class('input-medium')->placeholder('Grupo')->label('Grupo') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.faq')) }}
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
	{{ Table::headers('Questão', 'Resposta', 'Grupo', 'Ações') }}
	{{ Table::body($faq)
		->ignore(['id'])
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Editar', route('admin.faq.edit', $body['id'])],
					['Excluir', route('admin.faq.delete', $body['id'])],
			    ])
			)->pull_right()->split();
		})
	}}

	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $faq->getFrom() }}</strong> a <strong>{{ $faq->getTo() }}</strong> registros do total de <strong>{{ $faq->getTotal() }}</strong></div>
		{{ $faq->links() }}
	</div>
</div>
@stop
