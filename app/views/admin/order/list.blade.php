@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pagamentos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.order') }}" title="Listar todos os pagamentos" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.order.offers') }}" title="Listar pagamentos por ofertas" class="dropdown-toggle navbar-icon"><i class="icon-tags"></i></a>
	            <a href="{{ route('admin.order.voucher') }}" title="Listar cupons" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.order')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('status', 'Status')
	        	->addOption('', '')
	        	->addOption('Revisão', 'revisao')
	        	->addOption('Pendente', 'pendente')
	        	->addOption('Cancelado', 'cancelado')
	        	->addOption('Pago', 'pago')
	        }}
	        {{ Former::select('terms', 'Meio de pagamento')
	        	->addOption('', '')
	        	->addOption('Cartão', 'cartão')
	        	->addOption('Boleto', 'boleto')
	        	->addOption('Créditos e/ou Cupom de desconto', 'créditos')
	        }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail')->label('E-mail') }}
			{{ Former::text('braspag_order_id')->class('input-medium')->placeholder('Número do pedido')->label('Número do pedido') }}
			{{ Former::text('offer_id')->class('input-medium')->placeholder('ID da oferta')->label('ID da oferta') }}
			{{ Former::date('date_start')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('date_end')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.order')) }}
			{{ Former::link('Exportar pesquisa acima para excel', 'javascript: exportar(\''.route('admin.order.list_paym_export', ['status'=>'status', 'terms'=>'terms', 'name'=>'name', 'email'=>'email', 'braspag_order_id'=>'braspag_order_id', 'offer_id'=>'offer_id', 'date_start'=>'date_start', 'date_end'=>'date_end']).'\');') }}
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
{{ Table::headers('Data e hora', 'Número do Pedido', 'Cliente', 'ID das Ofertas', 'Forma de pagamento', 'Status', 'Valor', 'Ações') }}
{{ Table::body($orderArray)->ignore(['buyer', 'offer_option_offer', 'id', 'user_id', 'braspag_order_id', 'braspag_order_id_string', 'status', 'total', 'payment_terms', 'antifraud_id', 'braspag_id', 'coupon_id', 'first_digits_card', 'holder_card', 'donation', 'card_boletus_rate', 'antecipation_rate', 'interest_rate', 'credit_discount', 'coupon_discount', 'cpf', 'telephone', 'is_gift', 'boleto', 'capture_date', 'history', 'created_at', 'updated_at'])
	->datetime(function($order) {
		if(isset($order['created_at'])) {
			return date('d/m/Y H:i:s', strtotime($order['created_at']));
		}
		return '--';
	})
	->braspag_order_idd(function($order) {
		if(isset($order['id'])) {
			return '<a href=\'javascript: view('.$order['id'].')\'>'.$order['braspag_order_id_string'].'</a>';
		}
		return '--';
	})
	->cliente(function($order) {
		if(isset($order->buyer->profile)) {
			$name = $order->buyer->profile->first_name . ' ' . $order->buyer->profile->last_name;
			$id = $order->buyer->id;
			return link_to_route('admin.user.view', $name, ['id'=>$id]);
		}
		return '--';
	})
	->oferta(function($order) {
		if($order->offer_option_offer){
			$id = '| ';
			foreach ($order->offer_option_offer as $offer_option) {
				if(strpos($id, $offer_option->offer_id) == false){
					$id .= link_to_route('oferta', $offer_option->offer_id, ['slug' => $offer_option->offer->slug]).' | ';
				}
			}
			return $id;
		}
		return '--';
	})
	->payment_termss(function($order) {
		if(isset($order['payment_terms'])) {
			return $order['payment_terms'];
		}
		return '--';
	})
	->statuss(function($order) {
		if(isset($order['status'])) {
			return $order['status'];
		}
		return '--';
	})
	->totall(function($order) {
		if(isset($order['total'])) {
			return $order['total'];
		}
		return '--';
	})
	->acoes(function($order) {
		$order['braspag_order_id_string'] = isset($order['braspag_order_id_string'])?$order['braspag_order_id_string']:$order['created_at'];
		if($order['status'] == 'revisao'){
	        return DropdownButton::normal('Ações',
			  	Navigation::links([
			  		['Ver detalhes', 'javascript: view('.$order['id'].')'],
					['Aprovar', 'javascript: action(\''.route('admin.order.approve', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'aprovar\', \''.$order['braspag_order_id_string'].'\');'],
					['Rejeitar', 'javascript: action(\''.route('admin.order.cancel', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'rejeitar\', \''.$order['braspag_order_id_string'].'\');'],
			    ])
			)->pull_right()->split();
		}
	    else if($order['status'] == 'pago'){
	    	return DropdownButton::normal('Ações',
			  	Navigation::links([
			  		['Ver detalhes', 'javascript: view('.$order['id'].')'],
					['Cancelar', 'javascript: action(\''.route('admin.order.cancel', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'cancelar\', \''.$order['braspag_order_id_string'].'\');'],
					['Cancelar e converter valor em créditos', 'javascript: action(\''.route('admin.order.convert_value_2_credit', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'converter valor em créditos\', \''.$order['braspag_order_id_string'].'\');'],
			    ])
			)->pull_right()->split();
	    }
	    else{
	    	return DropdownButton::normal('Ações',
			  	Navigation::links([
			  		['Ver detalhes', 'javascript: view('.$order['id'].')'],
			    ])
			)->pull_right()->split();
	    }
	})
}}
{{ Table::close() }}
</div>

{{ $orderArray->links() }}

<script type="text/javascript">
function action(url, action, braspag_order_id){
	var href = url;
	var message = 'Realmente deseja '+action+' a compra '+braspag_order_id+'? Se sim, comente abaixo o motivo da ação.';
	var title = 'Atenção: '+action;

	if (!$('#dataConfirmModal').length) {
	    var modal = '<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
	    				+'<div class="modal-header">'
								+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
								+'<h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body">'
								+'<p id="modal-message">'+message+'</p>'
								+'<input type="text" id="comment-on-action" style="width: 100%;" autofocus="autofocus"/>'
							+'</div>'
							+'<div class="modal-footer">'
								+'<button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Não, voltar</button>'
								+'<a class="btn btn-danger" id="dataConfirmOK">Sim</a>'
							+'</div>'
						+'</div>';

	    $('body').append(modal);
	}

	$('#dataConfirmModal').find('#modal-message').text(message);
	$('#dataConfirmModal').find('#dataConfirmLabel').text(title);
	$('#dataConfirmOK').attr('href', 'javascript: submit_action("'+url+'")');
	$('#dataConfirmModal').modal({show:true});
}

function submit_action(url){
	window.location.href = url + $('#comment-on-action').val();
}

function exportar(url){
	var status = ($('#status').val() == '')?'null':$('#status').val();
	var terms = ($('#terms').val() == '')?'null':$('#terms').val();
	var name = ($('#name').val() == '')?'null':$('#name').val()
	var email = ($('#email').val() == '')?'null':$('#email').val()
	var braspag_order_id = ($('#braspag_order_id').val() == '')?'null':$('#braspag_order_id').val()
	var offer_id = ($('#offer_id').val() == '')?'null':$('#offer_id').val()
	var date_start = ($('#date_start').val() == '')?'null':$('#date_start').val()
	var date_end = ($('#date_end').val() == '')?'null':$('#date_end').val()

	url = url.replace('/status', '/'+status);
	url = url.replace('/terms', '/'+terms);
	url = url.replace('/name', '/'+name);
	url = url.replace('/email', '/'+email);
	url = url.replace('/braspag_order_id', '/'+braspag_order_id);
	url = url.replace('/offer_id', '/'+offer_id);
	url = url.replace('/date_start', '/'+date_start);
	url = url.replace('/date_end', '/'+date_end);

	window.location.href = url;
};

function view(id){
	if (!$('#viewOrder').length) {
		var modal = '<div id="viewOrder" class="modal" style="width: 80%; height:80%; margin-left:0px; left:10%; margin-top:0px; top:10%; overflow:scroll;" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
						+'<div class="modal-header" style="text-align: right;">'
							+'<button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">×</button>'
						+'</div>'
						+'<div class="modal-footer" id="viewOrderContent" style="text-align: left;">'
						+'</div>'
					+'</div>';
			    $('body').append(modal);
	}

	var url = "{{ route('admin.order.view', ['id' => '_id_']) }}";
	url = url.replace('_id_', id);
	
    $.ajax({
        type: "GET",
        url: url,
        success: function(data){
            $('#viewOrderContent').html(data);
            $('#viewOrder').modal({show:true});
            $('.modal-backdrop').on('click', function (e) {
				e.preventDefault();
				$('#viewOrder').modal('hide');
			});
        },
        headers: {
            'X-CSRF-Token': '{{ csrf_token() }}'
        }
    });
}

</script>

@stop
