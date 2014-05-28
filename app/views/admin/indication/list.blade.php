@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Indicações de Usuários</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.indication.create') }}" title="Criar Indicação" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.indication')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('indicated_name')->class('input-medium')->placeholder('Nome do indicado')->label('Nome do indicado') }}
			{{ Former::text('indicated_email')->class('input-medium')->placeholder('E-mail do indicado')->label('E-mail do indicado') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome do cliente')->label('Nome do cliente') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail do cliente')->label('E-mail do cliente') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.indication')) }}
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
	{{ Table::headers('Nome do indicado', 'E-mail do indicado', 'Nome do nosso cliente', 'E-mail do nosso cliente') }}
	{{ Table::body($indication)
		->ignore(['id', 'user_id', 'user', 'created_at', 'updated_at'])
		->customer_name(function($body) {
			if(isset($body['user'])){
				return $body['user']->first_name.' '.$body['user']->last_name;
			}
			return '--';
		})
		->customer_email(function($body) {
			if(isset($body['user'])){
				return $body['user']->email;
			}
			return '--';
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $indication->getFrom() }}</strong> a <strong>{{ $indication->getTo() }}</strong> registros do total de <strong>{{ $indication->getTotal() }}</strong></div>
		{{ $indication->links() }}
	</div>
</div>

@stop
