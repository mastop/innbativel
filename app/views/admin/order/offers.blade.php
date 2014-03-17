@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Pagamentos por oferta</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.order') }}" title="Listar todos os pagamentos" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.order.offers') }}" title="Listar pagamentos por ofertas" class="dropdown-toggle navbar-icon"><i class="icon-taggs"></i></a>
	            <a href="{{ route('admin.order.voucher') }}" title="Listar vouchers" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.order.offers')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('offer_id')->class('input-medium')->placeholder('ID da oferta')->label('ID da oferta') }}
			{{ Former::date('starts_on')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('ends_on')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.order.offers')) }}
			{{ Former::link('Exportar pesquisa acima para excel', 'javascript: exportar(\''.route('admin.order.list_offers_export', ['offer_id' =>'offer_id', 'starts_on' => 'starts_on', 'ends_on'=>'ends_on']).'\');') }}
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
{{ Table::headers('ID Oferta', 'Oferta', 'Opção', 'Data início', 'Data fim', 'Valor', 'Cupons usados', 'Máximo', 'Confirmados', 'Pendentes', 'Cancelados', 'Total', 'Ações') }}
{{ Table::body($offersOptions)->ignore(['id', 'title', 'subtitle', 'included', 'price_original', 'price_with_discount', 'min_qty', 'max_qty', 'max_qty_per_buyer', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'rules', 'display_order', 'offer', 'qty_sold', 'used_vouchers'])
	->main_offer(function($offer_option) {
		if(isset($offer_option['offer'])) {
			return $offer_option['offer']->title;
		}
		return '--';
	})
	->offer_option(function($offer_option) {
		if(isset($offer_option['title'])) {
			return $offer_option['title'];
		}
		return '--';
	})
	->starts_on(function($offer_option) {
		if(isset($offer_option['offer'])) {
			return $offer_option['offer']->starts_on;
		}
		return '--';
	})
	->ends_on(function($offer_option) {
		if(isset($offer_option['offer'])) {
			return $offer_option['offer']->ends_on;
		}
		return '--';
	})
	->price(function($offer_option) {
		if(isset($offer_option['price_with_discount'])) {
			return $offer_option['price_with_discount'];
		}
		return '--';
	})
	->used_vouchers(function($offer_option) {
		if(isset($offer_option['used_vouchers'])) {
			$used_qty = isset($offer_option['used_vouchers']{0})?$offer_option['used_vouchers']{0}->qty:'0';
			return $used_qty;
		}
		return '--';
	})
	->max(function($offer_option) {
		if(isset($offer_option['max_qty'])) {
			return $offer_option['max_qty'];
		}
		return '--';
	})
	->approved(function($offer_option) {
		if(isset($offer_option['qty_sold'])) {
			$approved = 0;

			foreach ($offer_option['qty_sold'] as $order) {
				if(in_array($order['status'], array('aprovado', 'pago'))){
					$approved += $order['pivot']->qty;
				}
			}

			return link_to_route('admin.order.offers_export', $approved, ['offer_option_id' => $offer_option['id'], 'status' => 'approved']);
		}
		return '--';
	})
	->pending(function($offer_option) {
		if(isset($offer_option['qty_sold'])) {
			$pending = 0;

			foreach ($offer_option['qty_sold'] as $order) {
				if(in_array($order['status'], array('iniciado', 'revisao', 'pendente'))){
					$pending += $order['pivot']->qty;
				}
			}

			return link_to_route('admin.order.offers_export', $pending, ['offer_option_id' => $offer_option['id'], 'status' => 'pending']);
		}
		return '--';
	})
	->cancelled(function($offer_option) {
		if(isset($offer_option['qty_sold'])) {
			$cancelled = 0;

			foreach ($offer_option['qty_sold'] as $order) {
				if(in_array($order['status'], array('revisao', 'rejeitado', 'nao_finalizado', 'abortado', 'estornado', 'cancelado', 'nao_pago'))){
					$cancelled += $order['pivot']->qty;
				}
			}

			return link_to_route('admin.order.offers_export', $cancelled, ['offer_option_id' => $offer_option['id'], 'status' => 'cancelled']);
		}
		return '--';
	})
	->total(function($offer_option) {
		if(isset($offer_option['qty_sold'])) {
			$total = 0;

			foreach ($offer_option['qty_sold'] as $order) {
				$total += $order['pivot']->qty;
			}

			return link_to_route('admin.order.offers_export', $total, ['offer_option_id' => $offer_option['id'], 'status' => 'total']);
		}
		return '--';
	})
	->actions(function($offer_option) {
		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Ver vouchers', route('admin.order.voucher', ['offer_option_id' => $offer_option->id])],
				    ])
				)->pull_right()->split();
	})
}}
{{ Table::close() }}
</div>

{{ $offersOptions->links() }}

<script type="text/javascript">

function exportar(url){
	var offer_id = ($('#offer_id').val() == '')?'null':$('#offer_id').val();
	var starts_on = ($('#starts_on').val() == '')?'null':$('#starts_on').val();
	var ends_on = ($('#ends_on').val() == '')?'null':$('#ends_on').val()

	url = url.replace('/offer_id', '/'+offer_id);
	url = url.replace('/starts_on', '/'+starts_on);
	url = url.replace('/ends_on', '/'+ends_on);

	window.location.href = url;
};

</script>

@stop
