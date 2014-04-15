@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pagamentos aos Parceiros</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.payment') }}" title="Listar todos os pagamentos aos parceiros" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.payment')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::select('partner_id', 'Parceiro')
	        	->addOption('', null)
				->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.id', 9), 'name', 'id')
	        }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($pData['options'], $pData['selected'])
	        }}
	        {{ Former::checkbox('is_paid', '')
  				->text('Exibir somente pagos?')
	    	}}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.payment')) }}
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
{{ Table::headers('Data', 'Cliente', 'Código do Cupom', 'Oferta', 'Opção escolhida', 'Valor do Cupom', 'Forma de pagamento', 'Valor pago pelo cliente', 'Taxas Cartão/Boleto*', 'Taxa de Antecipação**', 'Valor Parceiro***', 'Pago?', 'Faturamento') }}
{{ Table::body($orderData)
		->ignore(['id', 'user_id', 'braspag_order_id', 'antifraud_id', 'braspag_id', 'coupon_id', 'status', 'first_digits_card', 'holder_card', 'donation', 'total', 'credit_discount', 'card_boletus_value', 'antecipation_value', 'cpf', 'telephone', 'is_gift', 'payment_terms', 'boleto', 'capture_date', 'history', 'created_at', 'updated_at', 'user', 'payment'])
		->date(function($order) {
			if(isset($order['created_at'])){
				return date("d/m/Y H:i:s", strtotime($order['created_at']));
			}
			return '--';
		})
		->customer(function($order) {
			if(isset($order['user'])){
				return $order['user']['first_name'].' '.$order['user']['last_name'];
			}
			return '--';
		})
		->vouchers(function($order) {
			$vouchers = '';
			foreach($order['payment'] AS $voucher){
				$vouchers .= 
			}
			if(isset($order['payment'])){
				return $order['payment']['id'].'-'.$order['payment']['display_code'].'-'.$order['payment']['offer_option']['offer_id'];
			}
			return '--';
		})
		->offer(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['offer_option']['offer_id'].' | '.$order['voucher_offer_order']['offer_option']['offer_title'];
			}
			return '--';
		})
		->offer_option(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['offer_option']['title'];
			}
			return '--';
		})
		->price(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['offer_option']['price_with_discount'];
			}
			return '--';
		})
		->payment_terms(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['order_customer']['payment_terms'];
			}
			return '--';
		})
		->paid_price(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['subtotal'];
			}
			return '--';
		})
		->card_tax(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['subtotal'];
			}
			return '--';
		})
		->installment_tax(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['subtotal'];
			}
			return '--';
		})
		->partner_tax(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['offer_option']['price_with_discount'];
			}
			return '--';
		})
		->is_paid(function($order) {
			if(isset($order['payment_partner'])){
				return is_null($order['payment_partner']['paid_on'])?'Não':'Sim';
			}
			return '--';
		})
		->gain(function($order) {
			if(isset($order['voucher_offer_order'])){
				return $order['voucher_offer_order']['offer_option']['price_with_discount'];
			}
			return '--';
		})
	}}
{{ Table::close() }}
</div>


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
