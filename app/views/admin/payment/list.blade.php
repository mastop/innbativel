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
			<th>Parceiro</th>
			<th>Período</th>
			<th>Data a ser pago</th>
			<th>Data do pagamento</th>
			<th style="text-align: right;">Valor Parceiro (R$)</th>
		</tr>
	</thead>
	{{ Table::body($paymentPartnerData)
			->ignore(['id', 'partner_id', 'payment_id', 'total', 'paid_on', 'payment', 'partner'])
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
				return isset($data['paid_on'])?date("d/m/Y H:i:s", strtotime($data['paid_on'])):'<span class="text-error">Não pago</span>';
			})
			->totall(function($data) {
				if(isset($data['total'])){
					return number_format($data['total'], 2, ',', '.');
				}
				return '--';
			})
	}}
	<thead>
		<tr>
		<th>Total</th>
		<th></th>
		<th></th>
		<th></th>
		<th style="text-align: right;">{{ number_format($totals['transfer'], 2, ',', '.') }}</th>
		</tr>
	</thead>
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $paymentPartnerData->getFrom() }}</strong> a <strong>{{ $paymentPartnerData->getTo() }}</strong> registros do total de <strong>{{ $paymentPartnerData->getTotal() }}</strong></div>
		{{ $paymentPartnerData->links() }}
	</div>
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
