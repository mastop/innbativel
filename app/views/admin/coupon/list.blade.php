@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons de Desconto</h6>
	        <div class="nav pull-right">
	        	<a href="{{ route('admin.coupon.deleted') }}" title="Cupons de desconto desativados" class="dropdown-toggle navbar-icon"><i class="icon-filter"></i></a>
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
			{{ Former::submit('Enviar') }}
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
	{{ Table::headers('Código', 'Valor', 'Oferta', 'Categoria', 'Usuário', 'Quantidade máxima', 'Quantidade utilizada', 'Data início', 'Data fim', 'Ações') }}
	{{ Table::body($coupon)
		->ignore(['id', 'user_id', 'value', 'offer_id', 'category_id', 'qty', 'qty_used', 'starts_on', 'ends_on', 'offer', 'category', 'user', 'created_at', 'updated_at', 'deleted_at'])
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
			return 'Qualquer';
		})
		->categoryy(function($body) {
			if(isset($body['category'])) {
				return $body['category']->title;
			}
			return 'Qualquer';
		})
		->userr(function($body) {
			if(isset($body['user'])) {
				return $body->user->profile->first_name.' '.$body->user->profile->last_name.' | '.$body->user->email;
			}
			return 'Qualquer';
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
				return date('d/m/Y H:i:s', strtotime($body->starts_on));
			}
			return '--';
		})
		->ends_onn(function($body) {
			if(isset($body->ends_on)) {
				return date('d/m/Y H:i:s', strtotime($body->ends_on));
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.coupon.edit', $body['id'])],
					['Desativar', route('admin.coupon.delete', $body['id'])],
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
