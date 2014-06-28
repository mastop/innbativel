@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap-editable/css/bootstrap-editable.css') }}">
@stop

@section('javascript')
	<script src="{{ asset('assets/vendor/bootstrap-editable/js/bootstrap-editable.min.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container user-account">
		
		<div class="row">

			<div class="col-12 col-sm-12 col-lg-12">
				<h2>Minha conta</h2>
				
				<ul class="buy-itens buy-combo checkout-combo nocheck cupoms">
					<h3>Meus cupons <span class="glyphicon glyphicon-chevron-down"></span></h3>
					
					<li>
						<figure><img src="assets/uploads/camarao.jpg"></figure>
						<div class="offer-combo cupom">
							<a href="#combo1-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Sequência de Camarão para 1 Pessoa</a>
						</div>
						<div>
							<div class="text-center">25/03/2014 a 31/10/2014</div>
							<div class="text-center">1 cupom</div>
							<div class="text-center">Aguardando</div>
							<div class="buttons">
								<a href="https://www.pagador.com.br/post/pagador/reenvia.asp/ea60e3e1-8e48-4ecd-93c7-0b98313b575a" target="_blank" title="Gere o boleto para pagamento" class="btn btn-include">Boleto</a>
							</div>
						</div>
					</li>

					<li>
						<figure><img src="assets/uploads/camarao.jpg"></figure>
						<div class="offer-combo cupom">
							<a href="#combo1-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Sequência de Frutos do Mar para 2 Pessoas</a>
						</div>
						<div>
							<div class="text-center">25/03/2014 a 31/10/2014</div>
							<div class="text-center">1 cupom</div>
							<div class="text-center">Disponível</div>
							<div class="buttons">
								<a href="{{ route('cupom', ['id'=>'448']) }}" target="_blank" title="Gere o boleto para pagamento" class="btn btn-include">Abrir</a>
							</div>
						</div>
					</li>

					<li>
						<figure><img src="assets/uploads/camarao.jpg"></figure>
						<div class="offer-combo cupom">
							<a href="#combo1-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Sequência de Camarão para 4 Pessoas</a>
						</div>
						<div>
							<div class="text-center">25/03/2014 a 31/10/2014</div>
							<div class="text-center">1 cupom</div>
							<div class="text-center">Finalizado</div>
							<div class="buttons">
								<!-- <a href="https://www.pagador.com.br/post/pagador/reenvia.asp/ea60e3e1-8e48-4ecd-93c7-0b98313b575a" target="_blank" title="Gere o boleto para pagamento" class="btn btn-include">Boleto</a> -->
							</div>
						</div>
					</li>

				</ul>

				<br/>

				<div class="user-credits">
					Meus créditos <span class="glyphicon glyphicon-chevron-right"></span>
					<div>
						<!-- você não tem créditos -->
						você tem <strong>R$ 50</strong> em créditos
					</div>
				</div>

				<br/>

				<table class="table table-bordered user-data">
					<thead>
						<tr>
							<th colspan="2">Meus dados <span class="glyphicon glyphicon-chevron-down"></span></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="30%">Nome completo</td>
							<td width="70%"><a href="#" id="username" data-type="text" data-pk="1" data-title="Digite seu nome completo">Fulano da Silva</a></td>
						</tr>
						<tr>
							<td width="30%">Telefone</td>
							<td width="70%"><a href="#" id="userphone" data-type="text" data-pk="1" data-title="Digite seu telefone">4812341234</a></td>
						</tr>
						<tr>
							<td width="30%">Estado</td>
							<td width="70%"><a href="#" id="userstate" data-type="select" data-pk="1" data-title="Escolha seu estado">Acre</a></td>
						</tr>
					</tbody>
				</table>

			</div>

		</div>
	</div>
	
	<div id="combo1-info" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-combo combo-control">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close over-img" data-dismiss="modal" aria-hidden="true">&times;</button>
					<img src="assets/uploads/camarao.jpg">
					<h4 class="modal-title">Sequência de Camarão para 2 Pessoas</h4>
				</div>
				<div class="modal-body">
					<p>
						A Sequência inclui: Camarão ao Alho e Óleo, Camarão ao Bafo, Camarão à Milanesa, Bolinho de Siri, Filé Peixe ao Molho de Camarão, Pirão, Salada e Batata Frita.
					</p>
					<p>
						Restaurante de frente para o mar, na praia da Barra da Lagoa.
					</p>
					<p>
						O Restaurante oferece cadeiras, espreguiçadeiras, guarda-sóis na areia, ducha de água doce e amplo estacionamento. Convide alguém especial, os amigos ou a família!
					</p>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		//turn to inline mode
		$.fn.editable.defaults.mode = 'inline';

		$(document).ready(function() {
			$('#username').editable();
			$('#userphone').editable();
		});

		$(function(){
			$('#userstate').editable({
				value: 0,    
				source: [
					{value: '0', text: 'Selecione'},
					{value: 'AC', text: 'Acre'},
					{value: 'AL', text: 'Alagoas'},
					{value: 'AM', text: 'Amazonas'},
					{value: 'AP', text: 'Amapá'},
					{value: 'BA', text: 'Bahia'},
					{value: 'CE', text: 'Ceará'},
					{value: 'DF', text: 'Distrito Federal'},
					{value: 'ES', text: 'Espírito Santo'},
					{value: 'GO', text: 'Goías'},
					{value: 'MA', text: 'Maranhão'},
					{value: 'MG', text: 'Minas Gerais'},
					{value: 'MS', text: 'Mato Grosso do Sul'},
					{value: 'MT', text: 'Mato Grosso'},
					{value: 'PA', text: 'Pará'},
					{value: 'PB', text: 'Paraíba'},
					{value: 'PE', text: 'Pernambuco'},
					{value: 'PI', text: 'Piauí'},
					{value: 'PR', text: 'Paraná'},
					{value: 'RJ', text: 'Rio de Janeiro'},
					{value: 'RN', text: 'Rio Grande do Norte'},
					{value: 'RO', text: 'Rondônia'},
					{value: 'RR', text: 'Roraima'},
					{value: 'RS', text: 'Rio Grande do Sul'},
					{value: 'SC', text: 'Santa Catarina'},
					{value: 'SE', text: 'Sergipe'},
					{value: 'SP', text: 'São Paulo'},
					{value: 'TO', text: 'Tocantins'}
				]
			});
		});
	</script>
@stop
