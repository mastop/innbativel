	@stylesheets('backend')
	<style type="text/css">
	.column-totall, .column-creditDiscount, .column-couponDiscount{
		text-align: right;
	}
	</style>

    <div class="well widget row-fluid">

        <div class="control-group"><h1>Cliente</h1></div>

        <div class="control-group required">
            <b class="control-label">Nome</b>
            <div class="controls">{{ link_to_route('admin.user.view', (isset($order->buyer->profile->first_name)?$order->buyer->profile->first_name:'').(isset($order->buyer->profile->last_name)?(' '.$order->buyer->profile->last_name):''), ['id' =>$order->buyer->id], ['title' => 'Ver usuário']) }}</div>

            <b class="control-label">E-mail</b>
            <div class="controls">{{ $order->buyer->email }}</div>
        </div>

        <div class="control-group"><h1>Pedido</h1></div>

        <div class="control-group required">
        	<b class="control-label">Status</b>
            <div class="controls">{{ $order->status }}</div>

            <b class="control-label">Número do pedido</b>
            <div class="controls">{{ $order->braspag_order_id }}</div>

            <b class="control-label">Braspag ID</b>
            <div class="controls">{{ $order->braspag_id }}</div>

            <b class="control-label">Antifraud ID</b>
            <div class="controls">{{ $order->antifraud_id }}</div>

            <b class="control-label">Número de itens comprados</b>
            <div class="controls">{{ count($order->offer_option_offer) }}</div>

            <b class="control-label">Total pago</b>
            <div class="controls">R${{ number_format($order->total, '2', ',', '.') }}</div>

            <b class="control-label">Créditos do usuário usados nesta compra</b>
            <div class="controls">R${{ number_format($order->credit_discount, '2', ',', '.') }}</div>

            <b class="control-label">Cupom de desconto usado nesta compra</b>
            <div class="controls">{{ isset($order->discount_coupon)?('R$'.number_format($order->discount_coupon->value, '2', ',', '.').' | '.link_to_route('admin.coupon', $order->discount_coupon->display_code, ['display_code' => $order->discount_coupon->display_code], ['title' => 'Ver cupom de desconto'])):'Nenhum' }}</div>

            <b class="control-label">Meio de pagamento</b>
            <div class="controls">{{ $order->full_payment_terms }}</div>

            @if($order->payment_terms  == 'Cartão de crédito')
	            <b class="control-label">Titular do cartão</b>
	            <div class="controls">{{ isset($order->holder_card)?$order->holder_card:'--' }}</div>

	            <b class="control-label">Primeiros dígitos do número do cartão</b>
	            <div class="controls">{{ isset($order->first_digits_card)?$order->first_digits_card:'****' }} **** **** ****</div>

	            <b class="control-label">CPF ou CNPJ do titular do cartão</b>
            	<div class="controls">{{ isset($order->cpf)?$order->cpf:'--' }}</div>
            @elseif($order->payment_terms == 'Boleto')
	            <b class="control-label">Link do boleto</b>
	            <div class="controls">{{ link_to($order->boleto, $order->boleto, ['target' => 'blank']) }}</div>
            @endif

            <b class="control-label">Telefone</b>
            <div class="controls">{{ isset($order->telephone)?$order->telephone:(isset($order->buyer->profile)?$order->buyer->profile->telephone:'--') }}</div>
        </div>

        <div class="control-group"><h1>Cupons</h1></div>
        
        <div class="control-group required">
	        {{ Table::open() }}
			{{ Table::headers('Código', 'Status', 'Validado (usado)?', 'Cupom válido de', 'até', 'Código de rastreamento', 'Oferta', 'Opção escolhida', 'Ações') }}
			{{ Table::body($order->offer_option_offer)
				->ignore(['id', 'offer_id', 'title', 'subtitle', 'price_original', 'price_with_discount', 'transfer', 'min_qty', 'max_qty', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'display_order', 'is_active', 'pivot', 'offer', 'deleted_at'])
				->display_code(function($body) {
					if(isset($body->pivot)){
						return $body->pivot->id.'-'.$body->pivot->display_code;
					}
					return '--';
				})
				->status(function($body) {
					if(isset($body->pivot)){
						return $body->pivot->status;
					}
					return '--';
				})
				->used(function($body) {
					if(isset($body->pivot)){
						return ($body->pivot->used == 1)?'Sim':'Não';
					}
					return '--';
				})
				->validity_start(function($body) {
					if(isset($body->voucher_validity_start)){
						return $body->voucher_validity_start;
					}
					return '--';
				})
				->validity_end(function($body) {
					if(isset($body->voucher_validity_end)){
						return $body->voucher_validity_end;
					}
					return '--';
				})
				->tracking_code(function($body) {
					if(isset($body->pivot)){
						return isset($body->pivot->tracking_code)?$body->pivot->tracking_code:'--';
					}
					return '--';
				})
				->offerr(function($body) {
					if(isset($body->offer_id)){
						return $body->offer_id.' | '.(isset($body->offer->destiny)?$body->offer->destiny->name:$body->offer->title);
					}
					return '--';
				})
				->offer_option(function($body) {
					if(isset($body->id)){
						return $body->title.' (R$'.number_format($body->price_with_discount, '2', ',', '.').')';
					}
					return '--';
				})
				->acoes(function($body) {
					if($body->pivot->status == 'pago'){
						if($body->pivot->used == 0){
							return DropdownButton::normal('Ações',
								Navigation::links([
									//['Visualizar', route('admin.voucher.view', $body->pivot->id)],
									['Cancelar', 'javascript: voucher_cancel('.$body->pivot->id.',\''.$body->pivot->display_code.'\', 0);'],
									['Cancelar e converter p/ créditos', 'javascript: voucher_cancel('.$body->pivot->id.',\''.$body->pivot->display_code.'\', 1);'],
								])
							)->pull_right()->split();
						}
					}
				})
			}}
			{{ Table::close() }}
		</div>

        <div class="control-group"><h1>Transações</h1></div>

        <div class="control-group required">
            {{ Table::open() }}
			<thead>
				<tr>
					<th>Data</th>
					<th>Tipo</th>
					<th style="text-align: right;">Total (R$)</th>
					<th style="text-align: right;">Créditos do usuário (R$)</th>
					<th style="text-align: right;">Cupom de desconto (R$)</th>
				</tr>
			</thead>
			{{ Table::body($transaction)
				->ignore(['id', 'order_id', 'status', 'total', 'credit_discount', 'coupon_discount', 'created_at', 'updated_at'])
				->created_att(function($body) {
					if(isset($body->created_at)){
						return date('d/m/Y H:i:s', strtotime($body->created_at));
					}
					return '--';
				})
				->statuss(function($body) {
					if(isset($body->status)){
						return $body->status;
					}
					return '--';
				})
				->totall(function($body) {
					if(isset($body->total)){
						if($body->status == 'pagamento'){
							return number_format($body->total, '2', ',', '.');
						}
						else{
							return number_format(-1 * $body->total, '2', ',', '.');
						}
					}
					return '--';
				})
				->creditDiscount(function($body) {
					if(isset($body->credit_discount)){
						if($body->status == 'pagamento'){
							return number_format($body->credit_discount, '2', ',', '.');
						}
						else{
							return number_format(-1 * $body->credit_discount, '2', ',', '.');
						}
					}
					return '--';
				})
				->couponDiscount(function($body) {
					if(isset($body->coupon_discount)){
						if($body->status == 'pagamento'){
							return number_format($body->coupon_discount, '2', ',', '.');
						}
						else{
							return number_format(-1 * $body->coupon_discount, '2', ',', '.');
						}
					}
					return '--';
				})
			}}
			{{ Table::close() }}
        </div>

        <div class="control-group"><h1>Outras informações</h1></div>

        <div class="control-group required">
            <b class="control-label">Início da transação</b>
            <div class="controls">{{ date('d/m/Y H:i:s', strtotime($order->created_at)) }}</div>

            <b class="control-label">Última atualização</b>
            <div class="controls">{{ date('d/m/Y H:i:s', strtotime($order->updated_at)) }}</div>

            <b class="control-label">Data e hora da captura</b>
            <div class="controls">{{ $order->capture_date != '0000-00-00 00:00:00' ? date('d/m/Y H:i:s', strtotime($order->capture_date)) : '--' }}</div>

            <b class="control-label">Histórico</b>
            <div class="controls">{{ $order->display_history }}</div>
        </div>

        <div class="control-group"><h1>Ações</h1></div>

        <div class="control-group required">
        	
        	<?php $order->braspag_order_id = isset($order->braspag_order_id)?$order->braspag_order_id:$order->created_at; ?>

			@if($order->status == 'revisao')
			
				{{ Former::link('Aprovar', 'javascript: action(\''.route('admin.order.approve', ['id' => $order->id, 'braspag_order_id' => $order->braspag_order_id, 'comment' => 'motivo: ']).'\', \'aprovar\', \''.$order->braspag_order_id.'\');') }}

            	{{ Former::link('Rejeitar', 'javascript: action(\''.route('admin.order.cancel', ['id' => $order->id, 'braspag_order_id' => $order->braspag_order_id, 'comment' => 'motivo: ']).'\', \'rejeitar\', \''.$order->braspag_order_id.'\');') }}
			
			@elseif($order->status == 'pago')
			
				{{ Former::link('Cancelar', 'javascript: action(\''.route('admin.order.cancel', ['id' => $order->id, 'braspag_order_id' => $order->braspag_order_id, 'comment' => 'motivo: ']).'\', \'cancelar\', \''.$order->braspag_order_id.'\');') }}

            	{{ Former::link('Converter valor em créditos', 'javascript: action(\''.route('admin.order.convert_value_2_credit', ['id' => $order->id, 'braspag_order_id' => $order->braspag_order_id, 'comment' => 'motivo: ']).'\', \'converter valor em créditos\', \''.$order->braspag_order_id.'\');') }}
			
			@else

				Nenhuma ação disponível.
			
			@endif

        </div>

    </div>

	<script type="text/javascript">
	function voucher_cancel(id, voucher_display_code, convert_credits){
		if(convert_credits == 0){
			var title = 'Atenção: cancelar cupom '+id+'-'+voucher_display_code;
			var message = 'Realmente deseja cancelar o cupom '+id+'-'+voucher_display_code+'? Se sim, comente abaixo o motivo da ação.';
		}
		else{
			var title = 'Atenção: cancelar cupom '+id+'-'+voucher_display_code+' e converter valor para créditos do usuário';
			var message = 'Realmente deseja cancelar o cupom '+id+'-'+voucher_display_code+' e converter o valor para créditos do usuário? Se sim, comente abaixo o motivo da ação.';
		}

		if (!$('#dataConfirmModal').length) {
			var modal = '<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
		    				+'<form method="post" action="{{ route("admin.order.voucher_cancel") }}">'
	    						+'<div class="modal-header">'
									+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
									+'<h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body">'
									+'<p id="modal-message">'+message+'</p>'
									+'<input type="text" id="comment" name="comment" style="width: 100%;" autofocus="autofocus" value=""/>'
		    						+'<input type="hidden" name="id" id="id" value="'+id+'"/>'
		    						+'<input type="hidden" name="convert_credits" id="convert_credits" value="'+convert_credits+'"/>'
		    						+'<input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}"/>'
		    						+'<input type="hidden" name="_token" value="{{ csrf_token() }}"/>'
								+'</div>'
								+'<div class="modal-footer">'
									+'<a class="btn btn-danger" data-dismiss="modal">Voltar</a>'
									+'<button class="btn btn-success" id="dataConfirmOK" aria-hidden="true">Enviar</button>'
								+'</div>'
							+'</form>'
						+'</div>';

		    $('body').append(modal);
		}

		$('#dataConfirmModal').find('#modal-message').text(message);
		$('#dataConfirmModal').find('#dataConfirmLabel').text(title);
		$('#dataConfirmModal').find('#id').val(id);
		$('#dataConfirmModal').find('#convert_credits').val(convert_credits);
		$('#dataConfirmModal').modal({show:true});
	}

	function action(url, action, braspag_order_id){
		var href = url;
		var message = 'Realmente deseja '+action+' a compra '+braspag_order_id+'? Se sim, comente abaixo o motivo da ação.';
		var title = 'Atenção: '+action;

		if (!$('#dataConfirmModal2').length) {
		    var modal = '<div id="dataConfirmModal2" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
		    				+'<div class="modal-header">'
									+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
									+'<h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body">'
									+'<p id="modal-message">'+message+'</p>'
									+'<input type="text" id="comment-on-action" style="width: 100%;" autofocus="autofocus"/>'
								+'</div>'
								+'<div class="modal-footer">'
									+'<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Não, voltar</button>'
									+'<a class="btn btn-success" id="dataConfirmOK2">Sim</a>'
								+'</div>'
							+'</div>';

		    $('body').append(modal);
		}

		$('#dataConfirmModal2').find('#modal-message').text(message);
		$('#dataConfirmModal2').find('#dataConfirmLabel').text(title);
		$('#dataConfirmOK2').attr('href', 'javascript: submit_action("'+url+'")');
		$('#dataConfirmModal2').modal({show:true});
	}

	function submit_action(url){
		window.location.href = url + $('#comment-on-action').val();
	}

	</script>
