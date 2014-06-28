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
					@if(count($vouchers) > 0)
                        @foreach($vouchers as $voucher)
                            <li>
                                <figure><img src="{{$voucher->offer_option_offer->offer->thumb}}"></figure>
                                <div class="offer-combo cupom">
                                    <a href="#combo{{$voucher->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">{{$voucher->offer_option_offer->offer->destiny->name}} <span class="entypo chevron-right"></span> {{$voucher->offer_option_offer->title}}</a>
                                </div>
                                <div>
                                    <div class="text-center">{{$voucher->offer_option_offer->voucher_validity_start}} a {{$voucher->offer_option_offer->voucher_validity_end}}</div>
                                    <div class="text-center">&nbsp;</div>
                                    <div class="text-center">
                                        @if($voucher->used == 1)
                                        Utilizado
                                        @elseif(($voucher->status != 'pendente' && $voucher->status != 'pago') || $voucher->offer_option_offer->is_expired)
                                        Finalizado
                                        @elseif($voucher->status == 'pendente')
                                        Aguardando
                                        @else
                                        Disponível
                                        @endif
                                    </div>
                                    <div class="buttons">
                                        @if($voucher->used == 1)
                                        <!-- Qual botão vai aqui? -->
                                        @elseif(($voucher->status != 'pendente' && $voucher->status != 'pago') || $voucher->offer_option_offer->is_expired)
                                        <!-- Aqui não vai nada? -->
                                        @elseif($voucher->status == 'pendente' && $voucher->order->payment_terms == 'Boleto')
                                            @if($voucher->order->payment_terms == 'Boleto')
                                        <a href="https://www.pagador.com.br/post/pagador/reenvia.asp/{{$voucher->order->braspag_order_id}}" target="_blank" title="Gere o boleto para pagamento" class="btn btn-include">Boleto</a>
                                            @else
                                                Aguardando aprovação do pagamento
                                            @endif
                                        @else
                                            <a href="{{--route('cupom', ['id'=>$voucher->id])--}}" target="_blank" title="Acesse o seu voucher" class="btn btn-include">Abrir</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                    <li>Não há cupons disponíveis.</li>
                    @endif
				</ul>

				<br/>
                @if(Auth::user() && Auth::user()->profile->credit > 0)
				<div class="user-credits">
					Meus créditos <span class="glyphicon glyphicon-chevron-right"></span>
					<div>
						<!-- você não tem créditos -->
						você tem <strong>R$ {{Auth::user()->profile->credit}}</strong> em créditos
					</div>
				</div>
                @endif

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
    @foreach($vouchers as $voucher)
	<div id="combo{{$voucher->id}}-info" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-combo combo-control">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close over-img" data-dismiss="modal" aria-hidden="true">&times;</button>
					<img src="{{$voucher->offer_option_offer->offer->thumb}}" alt="{{$voucher->offer_option_offer->offer->title}}">
					<h4 class="modal-title">{{$voucher->offer_option_offer->offer->destiny->name}} <span class="entypo chevron-right"></span> {{$voucher->offer_option_offer->title}}</h4>
				</div>
				<div class="modal-body">
					<p>
                        {{$voucher->offer_option_offer->offer->popup_features}}
					</p>
				</div>
			</div>
		</div>
	</div>
    @endforeach

	<script type="text/javascript">
		//turn to inline mode
		$.fn.editable.defaults.mode = 'inline';

		$(document).ready(function() {
            $('.editable').editable({
                url:   '{{ajax-myaccount}}'
            });
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
