@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Usuário que se Cadastraram por Indicação e ainda não Compraram na INNBatível</h6>
	        <div class="nav pull-right">

	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.credit_indication')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome do cliente')->label('Nome do cliente') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail do cliente')->label('E-mail do cliente') }}
			{{ Former::text('new_name')->class('input-medium')->placeholder('Nome do novo cliente')->label('Nome do novo cliente') }}
			{{ Former::text('new_email')->class('input-medium')->placeholder('E-mail do novo cliente')->label('E-mail do novo cliente') }}
			{{ Former::text('value')->class('input-medium')->placeholder('Valor do crédito')->label('Valor do crédito') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.credit_indication')) }}
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
	{{ Table::headers('Nome do cliente', 'E-mail do cliente', 'Nome do novo cliente', 'E-mail do novo cliente', 'Crédito (se o novo usuário comprar)') }}
	{{ Table::body($credit_indication)
		->ignore(['id', 'user_id', 'new_user_id', 'user', 'new_user', 'value', 'created_at', 'updated_at'])
		->name(function($body) {
			if(isset($body['user'])){
				return $body['user']->first_name.' '.$body['user']->last_name;
			}
			return '--';
		})
		->email(function($body) {
			if(isset($body['user'])){
				return $body['user']->email;
			}
			return '--';
		})
		->new_name(function($body) {
			if(isset($body['new_user'])){
				return $body['new_user']->first_name.' '.$body['new_user']->last_name;
			}
			return '--';
		})
		->new_mail(function($body) {
			if(isset($body['new_user'])){
				return $body['new_user']->email;
			}
			return '--';
		})
		->valuee(function($body) {
			if(isset($body->value)){
				return $body->value;
			}
			return '--';
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $credit_indication->getFrom() }}</strong> a <strong>{{ $credit_indication->getTo() }}</strong> registros do total de <strong>{{ $credit_indication->getTotal() }}</strong></div>
		{{ $credit_indication->links() }}
	</div>
</div>

@stop
