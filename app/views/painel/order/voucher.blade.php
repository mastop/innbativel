@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Cupons</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('painel.order.offers') }}" title="Listar ofertas" class="dropdown-toggle navbar-icon"><i class="icon-tags"></i></a>
	            <a href="{{ route('painel.order.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.order.voucher')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('offer_option_id', 'Oferta')->addOption('Todas', null)->options($offersOptions, $offer_option_id) }}
			{{ Former::number('id')->class('input-medium')->placeholder('Chave do cupom')->label('Chave do cupom (primeiros digitos)') }}
			{{ Former::submit('Enviar') }}
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
	        	->select($pag)
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
{{ Table::open() }}
{{ Table::headers('Chave do cupom', 'Código', 'ID da Oferta', 'Validado?', 'Nome', 'Código de rastreamento', 'Ações') }}
{{ Table::body($vouchers)->ignore(['offer_option_id', 'order_id', 'name', 'email', 'status', 'tracking_code', 'used', 'order', 'offer_option_offer', 'created_at', 'updated_at', 'price'])
	->offer_id(function($voucher) {
		if(isset($voucher['offer_option_offer'])) {
			return link_to_route('painel.offer.view', $voucher['offer_option_offer']['offer']['id'], $voucher['offer_option_offer']['offer']['id']);
		}
		return '?';
	})
	->is_used(function($voucher) {
		if(isset($voucher)) {
			return ($voucher['used'] == 1)?'Sim':'Não';
		}
		return '?';
	})
	->namee(function($voucher) {
		if(isset($voucher)) {
			return $voucher['name'];
		}
		return '?';
	})
	->tracking_codee(function($voucher) {
		if(isset($voucher['tracking_code'])) {
			return $voucher['tracking_code'];
		}
		return '-';
	})
	->acoes(function($voucher) {
        if($voucher['used'] == 1){
        	if($voucher['offer_option_offer']['offer']['is_product']){
        		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Desvalidar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher['id'], 'used' => '0']).'\', \'desvalidar\', \''.$voucher['id'].'\');'],
						['Atualizar código de rastreamento', 'javascript: update_tracking_code(\''.route('painel.order.update_tracking_code', ['id' => $voucher['id']]).'\', \''.$voucher['id'].'\');'],
				    ])
				)->pull_right()->split();
        	}
        	else{
        		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Desvalidar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher['id'], 'used' => '0']).'\', \'desvalidar\', \''.$voucher['id'].'\');'],
				    ])
				)->pull_right()->split();
        	}
        }
        else{
        	if($voucher['offer_option_offer']['offer']['is_product']){
        		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Validar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher['id'], 'used' => '1']).'\', \'validar\', \''.$voucher['id'].'\');'],
						['Atualizar código de rastreamento', 'javascript: update_tracking_code(\''.route('painel.order.update_tracking_code', ['id' => $voucher['id']]).'\', \''.$voucher['id'].'\');'],
				    ])
				)->pull_right()->split();
        	}
        	else{
        		return DropdownButton::normal('Ações',
				  	Navigation::links([
						['Validar', 'javascript: action(\''.route('painel.order.schedule', ['id' => $voucher['id'], 'used' => '1']).'\', \'validar\', \''.$voucher['id'].'\');'],
				    ])
				)->pull_right()->split();
        	}
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
	window.location.href = url;
}

function update_tracking_code(url, voucher_id){
	var href = url;
	var message = 'Insira o código de rastreamento do produto com chave do cupom #'+voucher_id;
	var title = 'Código de rastreamento';
	var submit = 'javascript: document.getElementById(\'update-tracking-code\').submit()';

	if (!$('#dataConfirmModal').length) {
		var modal =  '<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
			modal += '	<div class="modal-header">'
			modal += '		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
			modal += '		<h3 id="dataConfirmLabel">'+title+'</h3>'
			modal += '	</div>'
			modal += '	<div class="modal-body">'
			modal += '		<p id="modal-message">'+message+'</p>'
			modal += '		<form action="'+url+'" method="post" id="update-tracking-code">'
			modal += '			<input type="text" name="tracking_code" id="tracking_code" style="width: 100%;" autofocus="autofocus"/>'
			modal += '		</form>'
			modal += '	</div>'
			modal += '	<div class="modal-footer">'
			modal += '		<button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Voltar</button>'
			modal += '		<a class="btn btn-danger" id="dataConfirmOK" onclick="'+submit+'">Enviar</a>'
			modal += '	</div>'
			modal += ' </div>';
	    $('body').append(modal);
	}

	$('#dataConfirmModal').find('#modal-message').text(message);
	$('#dataConfirmModal').find('#dataConfirmLabel').text(title);
	$('#dataConfirmOK').attr('href', submit);
	$('#dataConfirmModal').modal({show:true});
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
