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
                                    <a href="#combo{{$voucher->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">{{isset($voucher->offer_option_offer->offer->destiny)?$voucher->offer_option_offer->offer->destiny->name:$voucher->offer_option_offer->offer->title}} <span class="entypo chevron-right"></span> {{$voucher->offer_option_offer->title}}</a>
                                </div>
                                <div>
                                    <div class="text-center">{{$voucher->offer_option_offer->voucher_validity_start}} a {{$voucher->offer_option_offer->voucher_validity_end}}</div>
                                    <div class="text-center">&nbsp;</div>
                                    <div class="text-center">
                                        @if(($voucher->status != 'pendente' && $voucher->status != 'pago') || $voucher->offer_option_offer->is_expired)
                                        Finalizado
                                        @elseif($voucher->status == 'pendente')
                                        Aguardando
                                        @else
                                        Disponível
                                        @endif
                                    </div>
                                    <div class="buttons">
                                        @if(($voucher->status != 'pendente' && $voucher->status != 'pago') || $voucher->offer_option_offer->is_expired)
                                        <!-- Aqui não vai nada? -->
                                        @elseif($voucher->status == 'pendente' && $voucher->order->payment_terms == 'Boleto')
                                            @if($voucher->order->payment_terms == 'Boleto')
                                        <a href="{{$voucher->order->boleto}}" target="_blank" title="Gere o boleto para pagamento" class="btn btn-include">Boleto</a>
                                            @else
                                                Aguardando aprovação do pagamento
                                            @endif
                                        @else
                                            <a href="{{route('cupom', ['id'=>base64_encode($voucher->id)])}}" target="_blank" title="Acesse o seu voucher" class="btn btn-include">Abrir</a>
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
							<td width="30%">Nome</td>
							<td width="70%"><a href="#" id="first_name" class="editable" data-type="text" data-pk="1" data-title="Digite seu nome">{{Auth::user()->profile->first_name}}</a></td>
						</tr>
                        @if(Auth::user()->profile->cnpj)
                        <tr>
                            <td width="30%">Razão Social</td>
                            <td width="70%"><a href="#" id="company_name" class="editable" data-type="text" data-pk="1" data-title="Digite sua razão social">{{Auth::user()->profile->company_name}}</a></td>
                        </tr>
                        @else
                        <tr>
                            <td width="30%">Sobrenome</td>
                            <td width="70%"><a href="#" id="last_name" class="editable" data-type="text" data-pk="1" data-title="Digite seu sobrenome">{{Auth::user()->profile->last_name}}</a></td>
                        </tr>
                        @endif
						<tr>
							<td width="30%">E-mail</td>
                            <td width="70%"><a href="#" id="email" class="editable" data-type="text" data-pk="1" data-title="Digite seu e-mail">{{Auth::user()->email}}</a></td>
						</tr>
                        @if(Auth::user()->profile->cnpj)
                        <tr>
                            <td width="30%">CNPJ</td>
                            <td width="70%"><a href="#" id="cnpj" class="editable" data-type="text" data-pk="1" data-title="Digite seu CNPJ">{{Auth::user()->profile->cnpj}}</a></td>
                        </tr>
                        @else
                        <tr>
                            <td width="30%">CPF</td>
                            <td width="70%"><a href="#" id="cpf" class="editable" data-type="text" data-pk="1" data-title="Digite seu CPF">{{Auth::user()->profile->cpf}}</a></td>
                        </tr>
                        @endif
						<tr>
							<td width="30%">Telefone 1</td>
							<td width="70%"><a href="#" id="telephone" class="editable"  data-type="text" data-pk="1" data-title="Digite seu telefone">{{Auth::user()->profile->telephone}}</a></td>
						</tr>
						<tr>
							<td width="30%">Telefone 2</td>
							<td width="70%"><a href="#" id="telephone2" class="editable"  data-type="text" data-pk="1" data-title="Digite seu telefone">{{Auth::user()->profile->telephone2}}</a></td>
						</tr>
						<tr>
							<td width="30%">Endereço</td>
							<td width="70%"><a href="#" id="street" class="editable"  data-type="text" data-pk="1" data-title="Digite seu endereço">{{Auth::user()->profile->street}}</a> Nº <a href="#" id="number" class="editable"  data-type="text" data-pk="1" data-title="Digite seu número">{{Auth::user()->profile->number}}</a> - Comp. (<a href="#" id="complement" class="editable"  data-type="text" data-pk="1" data-title="Digite seu complemento">{{Auth::user()->profile->complement}}</a>)</td>
						</tr>
						<tr>
							<td width="30%">Bairro</td>
							<td width="70%"><a href="#" id="neighborhood" class="editable"  data-type="text" data-pk="1" data-title="Digite seu bairro">{{Auth::user()->profile->neighborhood}}</a> CEP <a href="#" id="zip" class="editable"  data-type="text" data-pk="1" data-title="Digite seu CEP">{{Auth::user()->profile->zip}}</a></td>
						</tr>
						<tr>
							<td width="30%">Cidade</td>
							<td width="70%"><a href="#" id="city" class="editable"  data-type="text" data-pk="1" data-title="Digite sua cidade">{{Auth::user()->profile->city}}</a></td>
						</tr>
						<tr>
							<td width="30%">Estado</td>
							<td width="70%"><a href="#" id="state" data-type="select" data-pk="1" data-title="Escolha seu estado">{{Auth::user()->profile->state}}</a></td>
						</tr>
                        <tr>
                            <td width="30%">Site</td>
                            <td width="70%"><a href="#" id="site" class="editable"  data-type="text" data-pk="1" data-title="Digite seu site">{{Auth::user()->profile->site}}</a></td>
                        </tr>
					</tbody>
				</table>

                <br/>
                <form method="post" action="{{route('trocar-senha')}}">
                    <table class="table table-bordered user-data">
                        <thead>
                            <tr>
                                <th colspan="2">Trocar a Senha <span class="glyphicon glyphicon-chevron-down"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="30%">Senha Atual</td>
                                <td width="70%"><input type="password" name="pass"></td>
                            </tr>
                            <tr>
                                <td width="30%">Nova Senha</td>
                                <td width="70%"><input type="password" name="newpass"></td>
                            </tr>
                            <tr>
                                <td width="30%">Repita Nova Senha</td>
                                <td width="70%"><input type="password" name="newpass2"></td>
                            </tr>
                            <tr>
                                <td width="30%"></td>
                                <td width="70%"><input type="submit" class="btn btn-primary" value="Trocar a Minha Senha"></td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                </form>

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
					<h4 class="modal-title">{{isset($voucher->offer_option_offer->offer->destiny)?$voucher->offer_option_offer->offer->destiny->name:$voucher->offer_option_offer->offer->title}} <span class="entypo chevron-right"></span> {{$voucher->offer_option_offer->title}}</h4>
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
                url:   '{{route("ajax-myaccount")}}',
                emptytext: 'Não Informado'
            });
		});

		$(function(){
			$('#state').editable({
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
				],
                url:   '{{route("ajax-myaccount")}}'
			});
		});
	</script>
@stop
