@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Pré-reservas</h6>
	        <div class="nav pull-right">

	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.prebooking')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome do cliente')->label('Nome do cliente') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail do cliente')->label('E-mail do cliente') }}
			{{ Former::text('destiny')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::number('offer_id')->class('input-medium')->placeholder('ID da oferta')->label('ID da oferta') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.prebooking')) }}
			{{ Former::link('Exportar pesquisa acima para excel', 'javascript: exportar(\''.route('admin.prebooking.export', ['offer_id' =>'offer_id', 'destiny' => 'destiny', 'name'=>'name', 'email'=>'email']).'\');') }}
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
	{{ Table::headers('ID da oferta', 'Destino', 'Nome do cliente', 'E-mail do cliente', 'Telefone do cliente') }}
	{{ Table::body($prebooking)
		->ignore(['id', 'user_id', 'user', 'offer', 'created_at', 'updated_at'])
		->destiny(function($body) {
			if(isset($body['offer'])){
				return $body['offer']->destiny;
			}
			return '--';
		})
		->name(function($body) {
			if(isset($body['user'])){
				return $body['user']->first_name.' '.$body['user']->last_name;
			}
			return '--';
		})
		->email(function($body) {
			if(isset($body['user'])){
				return $body['user']->email;
			}
			return '--';
		})
		->telephone(function($body) {
			if(isset($body['user'])){
				return $body['user']->telephone;
			}
			return '--';
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $prebooking->getFrom() }}</strong> a <strong>{{ $prebooking->getTo() }}</strong> registros do total de <strong>{{ $prebooking->getTotal() }}</strong></div>
		{{ $prebooking->links() }}
	</div>
</div>

<script type="text/javascript">

function exportar(url){
	var offer_id = ($('#offer_id').val() == '')?'null':$('#offer_id').val();
	var destiny = ($('#destiny').val() == '')?'null':$('#destiny').val();
	var name = ($('#name').val() == '')?'null':$('#name').val();
	var email = ($('#email').val() == '')?'null':$('#email').val();

	url = url.replace('/offer_id', '/'+offer_id);
	url = url.replace('/destiny', '/'+destiny);
	url = url.replace('/name', '/'+name);
	url = url.replace('/email', '/'+email);

	window.location.href = url;
};

</script>

@stop
