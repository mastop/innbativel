@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Vendas por oferta</h6>
	        <div class="nav pull-right">
	            @if(Auth::user()->can('admin.order'))
	            <a href="{{ route('admin.order') }}" title="Listar todos os pagamentos" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            @endif
	            <a href="{{ route('admin.order.offers') }}" title="Listar pagamentos por ofertas" class="dropdown-toggle navbar-icon"><i class="icon-tags"></i></a>
	            <a href="{{ route('admin.order.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.order.offers')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('offer_id')->class('input-medium')->placeholder('ID')->label('ID') }}
			{{ Former::date('starts_on')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('ends_on')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.order.offers')) }}
			{{ Former::link('Exportar esta pesquisa para excel', 'javascript: exportar(\''.route('admin.order.list_offers_export', ['offer_id' => 'offer_id', 'starts_on' => 'starts_on', 'ends_on'=>'ends_on']).'\');') }}
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
{{ Table::headers('ID', 'Oferta', 'Data início', 'Data fim', 'Valor', 'Cupons validados', 'Máximo (todas opções)', 'Confirmados', 'Pendentes', 'Cancelados', 'Total', 'Ações') }}
{{ Table::body($offers)->ignore(['partner_id','category_id','genre_id','genre2_id','destiny_id','ngo_id','tell_us_id','title','short_title','subtitle','price_original','price_with_discount','percent_off','rules','features','popup_features','slug','starts_on','ends_on','cover_img','newsletter_img','display_map','display_order','is_product','is_available','is_active','sold','created_at','updated_at','deleted_at', 'destiny', 'offer_option', 'deleted_at'])
	->offer(function($offer) {
		if(isset($offer->title)) {
			return isset($offer->destiny) ? $offer->destiny->name . ' - ' . $offer->title : $offer->title;
		}
		return '--';
	})
	->starts_onn(function($offer) {
		if(isset($offer->starts_on)) {
			return $offer->starts_on;
		}
		return '--';
	})
	->ends_onn(function($offer) {
		if(isset($offer->ends_on)) {
			return $offer->ends_on;
		}
		return '--';
	})
	->price(function($offer) {
		if(isset($offer->price_with_discount)) {
			return $offer->price_with_discount;
		}
		return '--';
	})
	->used_vouchers(function($offer) {
		return $offer->qty_used;
	})
	->max(function($offer) {
		return $offer->max_qty;
	})
	->pago(function($offer) {
		return link_to_route('admin.order.offers_export', $offer->qty_sold, ['offer_id' => $offer->id, 'status' => 'pago']);
	})
	->pendente(function($offer) {
		return link_to_route('admin.order.offers_export', $offer->qty_pending, ['offer_id' => $offer->id, 'status' => 'pendente']);
	})
	->cancelado(function($offer) {
		return link_to_route('admin.order.offers_export', $offer->qty_cancelled, ['offer_id' => $offer->id, 'status' => 'cancelado']);
	})
	->total(function($offer) {
		return link_to_route('admin.order.offers_export', $offer->qty, ['offer_id' => $offer->id]);
	})
	->actions(function($offer) {
		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Ver vouchers', route('admin.order.voucher', ['offer_id' => $offer->id])],
				    ])
				)->pull_right()->split();
	})
}}
{{ Table::close() }}
</div>

{{ $offers->links() }}

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
