@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('painel.order.offers') }}" title="Listar ofertas" class="dropdown-toggle navbar-icon"><i class="icon-taggs"></i></a>
	            <a href="{{ route('painel.order.voucher') }}" title="Listar vouchers" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.order.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('offer_option_id', 'Oferta')->addOption('Todas', null)->options($offersOptions, $offer_option_id) }}
			{{ Former::number('id')->class('input-medium')->placeholder('Chave do cupom')->label('Chave do cupom (primeiros digitos)') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('painel.order.voucher')) }}
			{{ Former::link('Exportar pesquisa acima para excel', 'javascript: exportar(\''.route('painel.order.voucher_export', ['id' =>'id', 'offer_option_id' => 'offer_option_id']).'\');') }}
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
{{ Table::headers('Chave do cupom', 'Código', 'Agendado?', 'Nome', 'E-mail', 'Ações') }}
{{ Table::body($vouchers)->ignore(['offer_option_id', 'order_id', 'name', 'email', 'used', 'order', 'offer_option', 'created_at', 'updated_at'])
	->is_used(function($voucher) {
		if(isset($voucher)) {
			return ($voucher->used == 1)?'Sim':'Não';
		}
		return '?';
	})
	->namee(function($voucher) {
		if(isset($voucher['order'])) {
			return $voucher['order']->first_name.' '.$voucher['order']->last_name;
		}
		return '?';
	})
	->emaill(function($voucher) {
		if(isset($voucher['order'])) {
			return $voucher['order']->email;
		}
		return '?';
	})
	->acoes(function($voucher) {
        if($voucher->used == 1){
	        return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Desagendar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher->id, 'used' => 0]).'\', \'desagendar\', \''.$voucher->id.'\');'],
			    ])
			)->pull_right()->split();
        }
        else{
        	return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Agendar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher->id, 'used' => 1]).'\', \'agendar\', \''.$voucher->id.'\');'],
			    ])
			)->pull_right()->split();
        }
	})
}}
{{ Table::close() }}
</div>

{{ $vouchers->links() }}

<script type="text/javascript">
function action(url, action, voucher_id){
	var href = url;
	var message = 'Realmente deseja '+action+' o cupom cuja chave é '+voucher_id+'?';
	var title = 'Atenção: '+action;

	if (!$('#dataConfirmModal').length) {
	    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body"><p class="modal-message">'+message+'</p></div><div class="modal-footer"><button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Não, voltar</button><a class="btn btn-danger" id="dataConfirmOK">Sim</a></div></div>');
	}

	$('#dataConfirmModal').find('.modal-message').text(message);
	$('#dataConfirmModal').find('#dataConfirmLabel').text(title);
	$('#dataConfirmOK').attr('href', 'javascript: submit_action("'+url+'")');
	$('#dataConfirmModal').modal({show:true});
}

function submit_action(url){
	window.location.href = url + '{{ $offer_option_id }}';
}

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
