@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ofertas</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('painel.order.offers') }}" title="Listar ofertas" class="dropdown-toggle navbar-icon"><i class="icon-tags"></i></a>
	            <a href="{{ route('painel.order.voucher') }}" title="Listar vouchers" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.order.offers')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('offer_id')->class('input-medium')->placeholder('ID da oferta')->label('ID da oferta') }}
			{{ Former::date('starts_on')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('ends_on')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('painel.order.offers')) }}
			{{ Former::link('Exportar esta pesquisa para excel', 'javascript: exportar(\''.route('painel.order.list_offers_export', ['offer_id' =>'offer_id', 'starts_on' => 'starts_on', 'ends_on'=>'ends_on']).'\');') }}
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
{{ Table::headers('ID da Oferta', 'Oferta', 'Data início', 'Data fim', 'Valor', 'Cupons validados', 'Vendidos', 'Ações') }}
{{ Table::body($offers)->ignore(['partner_id','category_id','genre_id','genre2_id','destiny_id','ngo_id','tell_us_id','title','short_title','subtitle','price_original','price_with_discount','percent_off','rules','features','popup_features','slug','starts_on','ends_on','cover_img','newsletter_img','display_map','display_order','is_product','is_available','is_active','sold','created_at','updated_at','deleted_at', 'destiny', 'offer_option', 'deleted_at'])
	->offer(function($offer) {
		if(isset($offer->title)) {
			return $offer->title;
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
	->pago(function($offer) {
		return $offer->qty_sold;
	})
	->actions(function($offer) {
		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Ver cupons', route('painel.order.voucher', ['offer_id' => $offer->id])],
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
