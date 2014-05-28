@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons de Desconto</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.coupon.create') }}" title="Criar Cupom de Desconto" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.coupon')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('display_code')->class('input-medium')->placeholder('Código')->label('Código') }}
			{{ Former::date('starts_on')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('ends_on')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.coupon')) }}
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
	{{ Table::headers('Código', 'Valor', 'Oferta', 'Usuário', 'Quantidade máxima', 'Quantidade utilizada', 'Data início', 'Data fim', 'Ações') }}
	{{ Table::body($coupon)
		->ignore(['id', 'user_id', 'value', 'offer_id', 'qty', 'qty_used', 'starts_on', 'ends_on', 'offer', 'user', 'created_at', 'updated_at'])
		->valuee(function($body) {
			if(isset($body->value)) {
				return $body->value;
			}
			return '--';
		})
		->offerr(function($body) {
			if(isset($body['offer'])) {
				return $body['offer']->id.' | '.$body['offer']['destiny']->name;
			}
			return 'Todas';
		})
		->userr(function($body) {
			if(isset($body['user'])) {
				return $body['user']->first_name.' '.$body['user']->last_name.' | '.$body['user']->email;
			}
			return 'Todos';
		})
		->qtyy(function($body) {
			if(isset($body->qty)) {
				return $body->qty;
			}
			return '--';
		})
		->qty_usedd(function($body) {
			if(isset($body->qty_used)) {
				return $body->qty_used;
			}
			return '--';
		})
		->starts_onn(function($body) {
			if(isset($body->starts_on)) {
				return $body->starts_on;
			}
			return '--';
		})
		->ends_onn(function($body) {
			if(isset($body->ends_on)) {
				return $body->ends_on;
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.coupon.edit', $body['id'])],
					['Excluir', route('admin.coupon.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $coupon->getFrom() }}</strong> a <strong>{{ $coupon->getTo() }}</strong> registros do total de <strong>{{ $coupon->getTotal() }}</strong></div>
		{{ $coupon->links() }}
	</div>
</div>

@stop
