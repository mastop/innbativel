@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pagamentos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.order') }}" title="Listar todos os pagamentos" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.order.offers') }}" title="Listar pagamentos por ofertas" class="dropdown-toggle navbar-icon"><i class="icon-taggs"></i></a>
	            <a href="{{ route('admin.order.voucher') }}" title="Listar vouchers" class="dropdown-toggle navbar-icon"><i class="icon-barcode"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.order')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('status', 'Status')
	        	->addOption('', '')
	        	->addOption('Iniciado', 'iniciado')
	        	->addOption('Aprovado', 'aprovado')
	        	->addOption('Rejeitado', 'rejeitado')
	        	->addOption('Revisão', 'revisao')
	        	->addOption('Pendente', 'pendente')
	        	->addOption('Não finalizado', 'nao_finalizado')
	        	->addOption('Abortado', 'abortado')
	        	->addOption('Estornado', 'estornado')
	        	->addOption('Cancelado', 'cancelado')
	        	->addOption('Pago', 'pago')
	        	->addOption('Não pago', 'nao_pago')
	        }}
	        {{ Former::select('terms', 'Meio de pagamento')
	        	->addOption('', '')
	        	->addOption('Cartão', 'cartão')
	        	->addOption('Boleto', 'boleto')
	        }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail')->label('E-mail') }}
			{{ Former::text('braspag_order_id')->class('input-medium')->placeholder('Número do pedido')->label('Número do pedido') }}
			{{ Former::text('offer_id')->class('input-medium')->placeholder('ID da oferta')->label('ID da oferta') }}
			{{ Former::date('date_start')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('date_end')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit() }}
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
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
{{ Table::open() }}
{{ Table::headers('ID', 'Status', 'Valor', 'Forma de pagamento', 'Data e hora', 'ID das Ofertas', 'Cliente', 'Ações') }}
{{ Table::body($orderArray)->ignore(['user', 'offer', 'id', 'user_id', 'antifraud_id', 'braspag_id', 'coupon_id', 'first_digits_card', 'holder_card', 'donation', 'credit_discount', 'cpf', 'telephone', 'is_gift', 'boleto', 'capture_date', 'history', 'updated_at', 'braspag_order_id_string'])
	->oferta(function($order) {
		if(isset($order['offer'])) {
			$id = '| ';
			foreach ($order['offer'] as $offer) {
				$id .= $offer->offer_id.' | ';
			}
			return $id;
		}
		return 'Não encontrada.';
	})
	->cliente(function($order) {
		if(isset($order['user'])) {
			$name = $order['user']->first_name . ' ' . $order['user']->last_name;
			$id = $order['user']->user_id;
			return link_to_route('admin.user.view', $name, ['id'=>$id]);
		}
		return 'Não informado.';
	})
	->acoes(function($order) {
		if($order['status'] == 'revisao'){
	        return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Aprovar', 'javascript: action(\''.route('admin.order.approve', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'aprovar\', \''.$order['braspag_order_id_string'].'\');'],
					['Rejeitar', 'javascript: action(\''.route('admin.order.reject', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'rejeitar\', \''.$order['braspag_order_id_string'].'\');'],
			    ])
			)->pull_right()->split();
		}
	    else if($order['status'] == 'aprovado' && date('d/m/Y') == date('d/m/Y',strtotime($order['capture_date']))){
	    	return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Cancelar', 'javascript: action(\''.route('admin.order.cancel', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'cancelar\', \''.$order['braspag_order_id_string'].'\');'],
					['Converter valor em créditos', 'javascript: action(\''.route('admin.order.convert_value_2_credit', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'converter valor em créditos\', \''.$order['braspag_order_id_string'].'\');'],
			    ])
			)->pull_right()->split();
	    }
	    else if($order['status'] == 'aprovado' && date('d/m/Y') != date('d/m/Y',strtotime($order['capture_date']))){
	        return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Estornar', 'javascript: action(\''.route('admin.order.void', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'estornar\', \''.$order['braspag_order_id_string'].'\');'],
					['Converter valor em créditos', 'javascript: action(\''.route('admin.order.convert_value_2_credit', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'converter valor em créditos\', \''.$order['braspag_order_id_string'].'\');'],
			    ])
			)->pull_right()->split();
	    }
	    else if($order['status'] == 'pago'){
	        return DropdownButton::normal('Ações',
			  	Navigation::links([
					['Cancelar boleto', 'javascript: action(\''.route('admin.order.cancel_boletus', ['id' => $order['id'], 'braspag_order_id' => $order['braspag_order_id_string'], 'comment' => 'motivo: ']).'\', \'cancelar boleto\', \''.$order['braspag_order_id_string'].'\');'],
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
	    $('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body"><p id="modal-message">'+message+'</p><input type="text" id="comment-on-action" style="width: 100%;" autofocus="autofocus"/></div><div class="modal-footer"><button class="btn btn-success" data-dismiss="modal" aria-hidden="true">Não, voltar</button><a class="btn btn-danger" id="dataConfirmOK">Sim</a></div></div>');
	}

	$('#dataConfirmModal').find('.modal-message').text(message);
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

</script>
</script>

@stop
