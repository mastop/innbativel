@section('content')

    <div class="well widget row-fluid">

        <div class="control-group"><h1>Cliente</h1></div>

        <div class="control-group required">
            <b class="control-label">Nome</b>
            <div class="controls">{{ link_to_route('admin.user.view', $order->user->first_name.(isset($order->user->last_name)?(' '.$order->user->last_name):''), ['id' =>$order->user->id], ['title' => 'Ver usuário']) }}</div>

            <b class="control-label">E-mail</b>
            <div class="controls">{{ $order->user->email }}</div>
        </div>

        <div class="control-group"><h1>Pedido</h1></div>

        <div class="control-group required">
            <b class="control-label">Número do pedido</b>
            <div class="controls">{{ $order->braspag_order_id }}</div>

            <b class="control-label">Braspag ID</b>
            <div class="controls">{{ $order->braspag_id }}</div>

            <b class="control-label">Antifraud ID</b>
            <div class="controls">{{ $order->antifraud_id }}</div>

            <b class="control-label">Número de itens comprados</b>
            <div class="controls">{{ count($order->offer) }}</div>

            <b class="control-label">Total pago</b>
            <div class="controls">R${{ number_format($order->total, '2', ',', '.') }}</div>

            <b class="control-label">Créditos do usuário usados nesta compra</b>
            <div class="controls">R${{ number_format($order->credit_discount, '2', ',', '.') }}</div>

            <b class="control-label">Cupom de desconto usado nesta compra</b>
            <div class="controls">{{ isset($order->discount_coupon)?('R$'.number_format($order->discount_coupon->value, '2', ',', '.').' | '.$order->discount_coupon->display_code):'Nenhum' }}</div>

            <b class="control-label">Meio de pagamento</b>
            <div class="controls">{{ $order->payment_terms }}</div>

            @if(strpos(strtolower($order->payment_terms), 'cartão') != false)
	            <b class="control-label">Titular do cartão</b>
	            <div class="controls">{{ isset($order->holder_card)?$order->holder_card:'--' }}</div>

	            <b class="control-label">Primeiros dígitos do número do cartão</b>
	            <div class="controls">{{ isset($order->first_digits_card)?$order->first_digits_card:'****' }} **** **** ****</div>

	            <b class="control-label">CPF ou CNPJ do titular do cartão</b>
            	<div class="controls">{{ isset($order->cpf)?$order->cpf:'--' }}</div>
            @endif

            <b class="control-label">Telefone</b>
            <div class="controls">{{ isset($order->telephone)?$order->telephone:'--' }}</div>
        </div>

        <div class="control-group"><h1>Vouchers</h1></div>

        <div class="control-group required">
	        {{ Table::open() }}
			{{ Table::headers('Código', 'Status', 'Validado (usado)?', 'Voucher válido de', 'até', 'Código de rastreamento', 'Oferta', 'Opção escolhida', 'Ações') }}
			{{ Table::body($order->offer)
				->ignore(['id', 'offer_title', 'is_product', 'offer_id', 'title', 'subtitle', 'price_original', 'price_with_discount', 'transfer', 'min_qty', 'max_qty', 'max_qty_per_buyer', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'display_order', 'pivot'])
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
						return date('d/m/Y H:i:s', strtotime($body->voucher_validity_start));
					}
					return '--';
				})
				->validity_end(function($body) {
					if(isset($body->voucher_validity_end)){
						return date('d/m/Y H:i:s', strtotime($body->voucher_validity_end));
					}
					return '--';
				})
				->tracking_code(function($body) {
					if(isset($body->pivot)){
						return isset($body->pivot->tracking_code)?$body->pivot->tracking_code:'--';
					}
					return '--';
				})
				->offer(function($body) {
					if(isset($body->offer_id)){
						return $body->offer_id.' - '.$body->offer_title;
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
						else{
							return DropdownButton::normal('Ações',
								Navigation::links([
									//['Visualizar', route('admin.voucher.view', $body->pivot->id)],
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
			{{ Table::headers('Data', 'Tipo', 'Total', 'Créditos do usuário', 'Cupom de desconto') }}
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
						return 'R$'.number_format($body->total, '2', ',', '.');
					}
					return '--';
				})
				->credit_discountt(function($body) {
					if(isset($body->credit_discount)){
						return 'R$'.number_format($body->credit_discount, '2', ',', '.');
					}
					return '--';
				})
				->coupon_discountt(function($body) {
					if(isset($body->coupon_discount)){
						return 'R$'.number_format($body->coupon_discount, '2', ',', '.');
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
            <div class="controls">{{ date('d/m/Y H:i:s', strtotime($order->capture_date)) }}</div>

            <b class="control-label">Histórico</b>
            <div class="controls">{{ $order->history }}</div>
        </div>

    </div>

	<script type="text/javascript">
	function voucher_cancel(id, voucher_display_code, convert_credits){
		if(convert_credits == 0){
			var title = 'Atenção: cancelar voucher '+id+'-'+voucher_display_code;
			var message = 'Realmente deseja cancelar o voucher '+id+'-'+voucher_display_code+'? Se sim, comente abaixo o motivo da ação.';
		}
		else{
			var title = 'Atenção: cancelar voucher '+id+'-'+voucher_display_code+' e converter valor para créditos do usuário';
			var message = 'Realmente deseja cancelar o voucher '+id+'-'+voucher_display_code+' e converter o valor para créditos do usuário? Se sim, comente abaixo o motivo da ação.';
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

	$(function() {
	  var availableTags = [
	  	<?php
	  		$partners = DB::table('profiles')
	  					 ->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')
	  					 ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
	  					 ->where('roles.id', 9)
	  					 ->get(['profiles.first_name']);

	  		foreach ($partners as $partner) {
	  			echo '"'.$partner->first_name.'", ';
	  		}
	  	?>
	  ];
	  $("#partner_name").autocomplete({
	    source: availableTags
	  });
	});

	</script>
@stop
