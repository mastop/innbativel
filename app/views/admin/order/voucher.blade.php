@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.order') }}" title="Listar todos os pagamentos" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.order.offers') }}" title="Listar pagamentos por ofertas" class="dropdown-toggle navbar-icon"><i class="icon-taggs"></i></a>
	            <a href="{{ route('admin.order.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.order.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('offer_option_id', 'Oferta')->addOption('Todas', null)->options($offersOptions, $offer_option_id) }}
			{{ Former::number('id')->class('input-medium')->placeholder('Chave do cupom')->label('Chave do cupom (primeiros digitos)') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.order.voucher')) }}
			{{ Former::link('Exportar pesquisa acima para excel', 'javascript: exportar(\''.route('admin.order.voucher_export', ['id' =>'id', 'offer_option_id' => 'offer_option_id']).'\');') }}
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
{{ Table::headers('Chave do cupom', 'Código', 'ID da Oferta', 'Agendado?', 'Nome', 'E-mail', 'Código de rastreamento') }}
{{ Table::body($vouchers)->ignore(['offer_option_id', 'order_id', 'status', 'tracking_code', 'name', 'email', 'used', 'order', 'offer_option_offer', 'created_at', 'updated_at'])
	->offer_id(function($voucher) {
		if(isset($voucher->offer_option_offer)) {
			return $voucher->offer_option_offer->offer->id;
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
		return '-';
	})
}}
{{ Table::close() }}
</div>

{{ $vouchers->links() }}

<script type="text/javascript">

function exportar(url){
	//{offer_option_id?}/{id?}
	var id = ($('#id').val() == '')?'null':$('#id').val();
	var offer_option_id = ($('#offer_option_id').val() == '')?'null':$('#offer_option_id').val();

	url = url.replace('/offer_option_id', '/'+offer_option_id);
	url = url.replace('/id', '/'+id);

	window.location.href = url;
};

</script>

@stop
