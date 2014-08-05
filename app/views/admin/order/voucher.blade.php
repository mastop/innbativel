@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons</h6>
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
			{{ Former::inline_open(route('admin.order.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('offer_id', 'Oferta')->addOption('Todas', null)->options($offers, $offer_id) }}
			{{ Former::number('id')->class('input-medium')->placeholder('Chave do cupom')->label('Chave do cupom (primeiros digitos)') }}
			{{ Former::select('sort', 'Ordernar por')
	        	->addOption('Chave do cupom', 'vouchers.id')
	        	->addOption('Opção da oferta', 'offers_options.title')
                ->select($sort)
	        }}
	        {{ Former::select('order', 'Em ordem')
	        	->addOption('Crescente', 'asc')
	        	->addOption('Decrescente', 'desc')
                ->select($order)
	        }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.order.voucher')) }}
			{{ Former::link('Exportar esta pesquisa para excel', 'javascript: exportar(\''.route('admin.order.voucher_export', ['sort' =>'sort', 'order' => 'order2', 'id' =>'id', 'offer_id' => 'offer_id']).'\');') }}
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
			{{ Former::close() }}
		</div>
	</div>
{{ Table::open() }}
{{ Table::headers('Data e hora', 'Chave do cupom', 'Código', 'ID da Oferta', 'Oferta', 'Opção', 'Validado?', 'Nome', 'E-mail', 'Código de rastreamento', 'Ações') }}
{{ Table::body($vouchers)->ignore(['id', 'display_code', 'offer_option_id', 'order_id', 'status', 'price', 'tracking_code', 'name', 'email', 'used', 'order', 'offer_option_offer', 'order_customer', 'created_at', 'updated_at', 'offer_id','title','subtitle','price_original','price_with_discount','transfer','min_qty','max_qty','percent_off','voucher_validity_start','voucher_validity_end','display_order','deleted_at'])
	->datetime(function($voucher) {
		if(isset($voucher['order_customer'])) {
			return date('d/m/Y H:i:s', strtotime($voucher['order_customer']['created_at']));
		}
		return '?';
	})
	->idd(function($voucher) {
		if(isset($voucher->id)) {
			return $voucher->id;
		}
		return '?';
	})
	->display_codee(function($voucher) {
		if(isset($voucher->display_code)) {
			return $voucher->display_code;
		}
		return '?';
	})
	->offer_id(function($voucher) {
		if(isset($voucher->offer_option_offer)) {
			return link_to_route('oferta-nova-ou-antiga', $voucher->offer_option_offer->offer->id, ['slug' => $voucher->offer_option_offer->offer->slug], ['target' => 'blank']);
		}
		return '?';
	})
	->offer(function($voucher) {
		if(isset($voucher->offer_option_offer->title)) {
			return isset($voucher->offer_option_offer->offer->destiny) ? $voucher->offer_option_offer->offer->destiny->name : substr($voucher->offer_option_offer->offer->title,0,40) . '...';
		}
		return '?';
	})
	->offer_option(function($voucher) {
		if(isset($voucher->offer_option_offer->offer->title)) {
			return $voucher->offer_option_offer->title . (isset($voucher->offer_option_offer->subtitle) && $voucher->offer_option_offer->subtitle != ''?'<br/>(' . $voucher->offer_option_offer->subtitle . ')':'');
		}
		return '?';
	})
	->is_used(function($voucher) {
		if(isset($voucher)) {
			return ($voucher->used == 1)?'Sim':'Não';
		}
		return '?';
	})
	->namee(function($voucher) {
		if(isset($voucher)) {
			return $voucher->name;
		}
		return '?';
	})
	->emaill(function($voucher) {
		if(isset($voucher)) {
			return $voucher->email;
		}
		return '?';
	})
	->tracking_codee(function($voucher) {
		if(isset($voucher->tracking_code)) {
			return $voucher->tracking_code;
		}
		return '--';
	})
	->acoes(function($voucher) {
        return DropdownButton::normal('Ações',
		  	Navigation::links([
		  		['Visualizar', route('admin.order.voucher.view', ['id' => base64_encode($voucher->id)])],
		    ])
		)->pull_right()->split();
	})
}}
{{ Table::close() }}
</div>

{{ $vouchers->links() }}

<script type="text/javascript">

function exportar(url){
	//{sort}/{order}/{offer_option_id?}/{id?}
	var sort = $('#sort').val();
	var order = $('#order').val();
	var id = ($('#id').val() == '')?'null':$('#id').val();
	var offer_id = ($('#offer_id').val() == '')?'null':$('#offer_id').val();

	url = url.replace('/sort', '/'+sort);
	url = url.replace('/order2', '/'+order);
	url = url.replace('/id', '/'+id);
	url = url.replace('/offer_id', '/'+offer_id);

	window.location.href = url;
};

</script>

@stop
