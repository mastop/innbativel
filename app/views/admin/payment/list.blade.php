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
			{{ Former::text('id')->class('input-medium')->placeholder('ID')->label('ID') }}
			{{ Former::text('partner_name')->class('input-medium')->placeholder('Parceiro')->label('Parceiro') }}
	        {{ Former::select('payment_id', 'Período de venda')
	        	->addOption('Todos', null)
				->options($paymData)
	        }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.payment')) }}
			<div class="dataTables_length">
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        	->addOption('1000', '1000')
	        	->addOption('10000', '10000')
	        	->select($pag)
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>

	<style type="text/css">
	.column-totall{
		text-align: right;
	}
	</style>

	{{ Table::open() }}
	<thead>
		<tr>
			<th>ID</th>
			<th>Parceiro</th>
			<th>Período</th>
			<th>Data a ser pago</th>
			<th>Data do pagamento</th>
			<th style="text-align: right;">Valor Parceiro (R$)</th>
			<th>Ação</th>
		</tr>
	</thead>
	{{ Table::body($paymentPartnerData)
			->ignore(['id', 'partner_id', 'payment_id', 'total', 'paid_on', 'payment', 'partner'])
			->idd(function($data) {
				if(isset($data['id'])){
					return '<a href="'.route('admin.payment.voucher', ['partner_id' => $data['partner_id'], 'payment_id' => $data['payment_id']]).'">'.$data['id'].'</a>';
				}
				return '--';
			})
			->partnerr(function($data) {
				if(isset($data['partner']['first_name'])){
					return $data['partner']['first_name'].' '.$data['partner']['last_name'];
				}
				return '--';
			})
			->period(function($data) {
				if(isset($data['payment']['sales_from'])){
					return date("d/m/Y H:i:s", strtotime($data['payment']['sales_from'])).' - '.date("d/m/Y H:i:s", strtotime($data['payment']['sales_to']));
				}
				return '--';
			})
			->date(function($data) {
				if(isset($data['payment']['date'])){
					return date("d/m/Y", strtotime($data['payment']['date']));
				}
				return '--';
			})
			->paid_onn(function($data) {
				return isset($data['paid_on'])?date("d/m/Y", strtotime($data['paid_on'])):'<span class="text-error">Não pago</span>';
			})
			->totall(function($data) {
				if(isset($data['total'])){
					return number_format($data['total'], 2, ',', '.');
				}
				return '--';
			})
			->acoes(function($data) {
				if(isset($data['paid_on'])){
					return DropdownButton::normal('Ações',
					  	Navigation::links([
							['Marcar como não pago', route('admin.payment.update_status', $data['id'])],
					    ])
					)->pull_right()->split();
				}
				else{
					return DropdownButton::normal('Ações',
					  	Navigation::links([
					  		['Marcar como pago', 'javascript: marcar_pago(\''.route('admin.payment.update_status', ['id' => $data['id']]).'\','.$data['id'].');'],
					    ])
					)->pull_right()->split();
				}
			})
	}}
	<thead>
		<tr>
		<th>Total</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th style="text-align: right;">{{ number_format($totals['transfer'], 2, ',', '.') }}</th>
		<th></th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $paymentPartnerData->getFrom() }}</strong> a <strong>{{ $paymentPartnerData->getTo() }}</strong> registros do total de <strong>{{ $paymentPartnerData->getTotal() }}</strong></div>
		{{ $paymentPartnerData->links() }}
	</div>
</div>


<script type="text/javascript">
function marcar_pago(url, id){
	var href = url;
	var message = 'Informe a data do pagamento #'+id;
	var title = 'Marcar pagamento #'+id+' como pago';

	if (!$('#dataConfirmModal').length) {
		var modal = '<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true">'
	    				+'<div class="modal-header">'
								+'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>'
								+'<h3 id="dataConfirmLabel">'+title+'</h3></div><div class="modal-body">'
								+'<p id="modal-message">'+message+'</p>'
								+'<input type="text" id="date" style="width: 100%;" autofocus="autofocus" value="{{ date('d/m/Y') }}"/>'
							+'</div>'
							+'<div class="modal-footer">'
								+'<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Voltar</button>'
								+'<a class="btn btn-success" id="dataConfirmOK">Enviar</a>'
							+'</div>'
						+'</div>';

	    $('body').append(modal);

	    $('#date').mask('00/00/0000');
	}

	$('#dataConfirmModal').find('#modal-message').text(message);
	$('#dataConfirmModal').find('#dataConfirmLabel').text(title);
	$('#dataConfirmOK').attr('href', 'javascript: submit_action("'+url+'")');
	$('#dataConfirmModal').modal({show:true});
}

function submit_action(url){
	window.location.href = url + '/' + $('#date').val().replace('/', '-').replace('/', '-');
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
<script src="{{ asset('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>

@stop
