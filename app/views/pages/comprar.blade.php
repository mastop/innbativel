@section('javascript')
	<script src="{{ asset('assets/themes/floripa/frontend/js/comprar.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container">
		
		<div class="row">

			<div class="col-8 col-sm-8 col-lg-8">
				<h2>Confirmação e Pagamento</h2>
			</div>

			<div class="col-4 col-sm-4 col-lg-4 offer-back">
				<a href="{{$offer->url}}" class="tooltip" data-tip="Escolha outras opções">Voltar para a Oferta</a>
			</div>

		</div>
		
		
			<div class="row">

				<div class="col-12 col-sm-12 col-lg-12 clearfix">
                    <ul class="buy-itens buy-combo checkout-combo nocheck">
                        <h3>Inclua também <span class="glyphicon glyphicon-chevron-down"></span></h3>
                    @if($offer->active_offer_additional->toArray() && count($offer->active_offer_additional->toArray()) > count($add))
                        @foreach($offer->active_offer_additional as $k => $additional)
                            @if(!in_array($additional->id, $add))
                                <li data-price="{{intval($additional->price_with_discount)}}">
                                    <figure><img src="{{$additional->offer->thumb}}" alt="{{$additional->offer->title}}"></figure>
                                    <div class="offer-combo">
                                        <a href="#combo{{$additional->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">{{$additional->offer->title}} <span class="entypo chevron-right"></span>{{$additional->title}}</a>
                                        <div class="more-info"><a href="#combo{{$additional->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">veja<strong>&plus;</strong></a></div>
                                    </div>
                                    <div class="buttons">
                                        <button class="btn btn-include" tabindex="-1"><span class="glyphicon glyphicon-plus"></span>incluir</button>
                                        <button class="btn btn-remove">remover</button>
                                    </div>
                                    <div class="quantity">Quantidade<br/>
                                        <select id="combo{{$additional->id}}-quantity" name="add-quantity[{{$additional->id}}]">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <div class="price">R$<strong>{{intval($additional->price_with_discount)}}</strong></div>
                                </li>
                            @endif
                        @endforeach
					@endif
                    </ul>
                    <div class="clearfix"></div>
                    <form class="buy-form" id="buy-form" action="{{route('pagar')}}" method="post">
					<ul class="buy-itens checkout-itens nocheck">

						<h3>Sua compra <span class="glyphicon glyphicon-chevron-down"></span></h3>
                        @foreach($offer->active_offer_option()->get() as $k => $option)
                            @if(in_array($option->id, $opt))
                                <li data-price="{{intval($option->price_with_discount)}}">
                                    <figure><img src="{{$offer->thumb}}"></figure>
                                    <div class="offer-combo">
                                        <strong>{{$offer->destiny->name}} - {{$offer->title}}</strong><br/>
                                        {{$option->title}}
                                        <div class="more-info"><a href="#regulation" class="tooltip" data-tip="Veja o Regulamento" data-toggle="modal">Regulamento</a></div>
                                    </div>
                                    <div class="quantity">Quantidade<br/>
                                        <select id="item{{$option->id}}-quantity" name="opt-quantity[{{$option->id}}]">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                        <input type="hidden" name="opt[]" value="{{$option->id}}">
                                    </div>
                                    <div class="price">R$<strong>{{intval($option->price_with_discount)}}</strong></div>
                                </li>
                            @endif
                        @endforeach
                        @if($offer->active_offer_additional->toArray() && count($add) > 0)
                            @foreach($offer->active_offer_additional as $k => $additional)
                                @if(in_array($additional->id, $add))
                                    <li data-price="{{intval($additional->price_with_discount)}}">
                                        <figure><img src="{{$additional->offer->thumb}}" alt="{{$additional->offer->title}}"></figure>
                                        <div class="offer-combo">
                                            <a href="#combo{{$additional->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">{{$additional->offer->title}} <span class="entypo chevron-right"></span>{{$additional->title}}</a>
                                            <div class="more-info"><a href="#combo{{$additional->id}}-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">veja<strong>&plus;</strong></a></div>
                                        </div>
                                        <div class="buttons">
                                            <button class="btn btn-include"><span class="glyphicon glyphicon-plus"></span>incluir</button>
                                            <button class="btn btn-remove">remover</button>
                                        </div>
                                        <div class="quantity">Quantidade<br/>
                                            <select id="combo{{$additional->id}}-quantity" name="add-quantity[{{$additional->id}}]">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                        <div class="price">R$<strong>{{intval($additional->price_with_discount)}}</strong></div>
                                    </li>
                                @endif
                            @endforeach
                        @endif
						<li class="donation">
							<figure><img src="{{$offer->ngo->thumb}}" title="{{$offer->ngo->name}}"></figure>
							<div class="offer-combo">
								<strong>Contribua para um mundo melhor.</strong><br/>
								Doe apenas <strong>R$ 1</strong>. Sua atitude transforma vidas!
								<div class="more-info"><a href="#donation-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Saiba mais</a></div>
							</div>
							<div>
								<select id="donation" name="donation">
									<option value="1">Doar</option>
									<option value="0">Não doar</option>
								</select>
							</div>
							<div class="price"><span>R$<strong>1</strong></span></div>
						</li>
                        @if(Auth::user() && Auth::user()->profile->credit > 0)
						<!-- no credits, data-credits="0" -->
						<li data-credits="{{Auth::user()->profile->credit}}" class="green">
							<div class="offer-combo">
								<strong>Seus créditos</strong><br/>
								Você tem créditos que serão abatidos do total da compra
							</div>
							<div class="price discount">- R$<strong></strong></div>
						</li>
                        @endif
						<li class="promocode green">
							<div class="offer-combo">
								<strong>Cupom de Desconto</strong><br/>
								Insira o código promocional
							</div>
							<div>
								<input type="text" id="input-promo-code" name="promoCode" placeholder="Digite o código"/>
							</div>
							<div>
								<button id="btn-promo-code" class="btn"><span class="glyphicon glyphicon-refresh"></span>validar cupom</button>
							</div>
							<div class="price discount"><span>- R$<strong></strong></span></div>
						</li>
						<li class="total-price">
							<div class="offer-combo">
								<strong>Total:</strong><br/>
							</div>
							<div id="total-price" class="price">R$<strong>0</strong></div>
						</li>
						<li class="payment">
                            <div style="text-align: left"><a href="{{$offer->url}}" class="tooltip" data-tip="Escolha outras opções">Voltar para a Oferta</a></div>
							<div class="offer-combo">
								<strong>Pagamento:</strong><br/>
							</div>
							<div id="payment-card-button">
								<button id="payment-card" class="btn btn-primary">Cartão de Crédito</button>
							</div>
							<div id='payment-boleto-button'>
								<button id="payment-boleto" class="btn btn-primary">Boleto</button>
							</div>
							<div id="payment-credit-button">
								<button id="payment-credit" class="btn btn-primary">Avançar</button>
							</div>
						</li>
					</ul>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <input type="hidden" name="offer" value="{{ $offer->id }}"/>
                        <input type="hidden" name="payment_type" value=""/>
                    </form>

				</div>
		
			</div>
	</div>

	<div id="modal-payment-card" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo credit-card"></span>Pagamento por Cartão de Crédito</h4>
				</div>
				<form id="paymentCardForm" class="form-horizontal" name="paymentCardForm" method="post">
					<div class="modal-body">
						<p>
							Preencha com os dados do cartão para finalizar sua compra.<br/>
							Compre com <strong>tranquilidade</strong> e <strong>segurança</strong>: seus dados serão criptografados e não serão armazenados.
						</p>
							<div class="form-group">
							<label class="control-label col-md-2" for="paymentCardFlag">Bandeira</label>
							<div class="col-md-5">
								<select id="paymentCardFlag" class="form-control" name="paymentCardFlag">
									<option value>Selecione</option>
									<option value="Visa">Visa</option>
									<option value="Mastercard">MasterCard</option>
									<option value="AmericanExpress">American Express</option>
									<option value="DinersClub">Diners Club</option>
									<option value="Elo">Elo</option>
									<option value="Discover">Discover</option>
									<option value="JCB">JCB</option>
									<option value="Aura">Aura</option>
								</select>
							</div>
							<div class="col-md-5">
								<span id="cc-flag"></span>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2" for="paymentCardNumber">Número</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="paymentCardNumber" name="paymentCardNumber" placeholder="Número do cartão" />
							</div>
							<label class="control-label col-md-3" for="paymentCardCode">Código seg.</label>
							<div class="col-md-2">
								<input type="text" class="form-control" id="paymentCardCode" name="paymentCardCode" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2" for="paymentCardValidityMonth">Validade</label>
							<div class="col-md-5">
								<select id="paymentCardValidityMonth" class="form-control" name="paymentCardValidityMonth">
									<option value>Mês</option>
									<option value="01">01 - Janeiro</option>
									<option value="02">02 - Fevereiro</option>
									<option value="03">03 - Março</option>
									<option value="04">04 - Abril</option>
									<option value="05">05 - Maio</option>
									<option value="06">06 - Junho</option>
									<option value="07">07 - Julho</option>
									<option value="08">08 - Agosto</option>
									<option value="09">09 - Setembro</option>
									<option value="10">10 - Outubro</option>
									<option value="11">11 - Novembro</option>
									<option value="12">12 - Dezembro</option>
								</select>
							</div>
							<div class="col-md-5">
								<select id="paymentCardValidityYear" class="form-control" name="paymentCardValidityYear">
									<option value>Ano</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2" for="paymentCardName">Nome</label>
							<div class="col-md-10">
								<input type="text" class="form-control" id="paymentCardName" name="paymentCardName" placeholder="Nome do titular como aparece no cartão" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2" for="paymentCardCPF">CPF/CNPJ</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="paymentCardCPF" name="paymentCardCPF" placeholder="CPF/CNPJ do titular" />
							</div>
							<label class="control-label col-md-2" for="paymentCardPhone">Telefone</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="paymentCardPhone" name="paymentCardPhone" placeholder="Telefone do titular do cartão" />
							</div>
						</div>
							<div class="form-group">
								<label class="control-label col-md-2" for="paymentCardInstallment">Parcelas</label>
								<div class="col-md-5">
									<select id="paymentCardInstallment" class="form-control" name="paymentCardInstallment">
										<option value="1">&nbsp;&nbsp;1x R$00,00</option>
										<option value="3">&nbsp;&nbsp;3x R$ &nbsp;00,00</option>
										<option value="6">&nbsp;&nbsp;6x R$ &nbsp;00,00</option>
										<option value="10">10x R$ &nbsp;00,00</option>
									</select>
								</div>
                                <div class="col-md-4">
									<label class="control-label" id="paymentCardTotal">Total: <strong>R$ </strong></label>
								</div>
							</div>
						<div class="form-group">
							<div class="panel-group col-md-offset-2 col-md-10" id="card-eula">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<label class="eula" for="payment-card-eula">
											<input type="checkbox" id="paymentCardEULA" name="paymentCardEULA"/>
											Aceito o<a href="#collapse-payment-card-eula" data-toggle="collapse" data-parent="#card-eula">regulamento da oferta e os termos de uso</a>
										</label>
									</div>
									<div id="collapse-payment-card-eula" class="panel-collapse collapse">
										<div id="print-payment-card-eula" class="panel-body">
											<!-- <a href="javascript:window.print();" class="control">​Imprimir</a> -->
											<!-- <a href="#" class="control print">​Imprimir</a>
											<a href="#" target="_blank" class="control">Download</a> -->
											<h4>Ragulamento da Oferta</h4>
											<p>
                                                {{$offer->rules}}
											</p>
											<h4>​Termos e Condições de Uso​</h4>​
											{{ Configuration::get('clauses') }}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-primary" id="closeOrderCard"><span class="entypo lock"></span>Finalizar compra segura</button> <img src="https://s3-sa-east-1.amazonaws.com/selo.siteblindado.com/seals_aw/innbativel.com.br/siteblindado_pr.gif" alt="Selo Site Blindado">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modal-payment-boleto" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="glyphicon glyphicon-barcode"></span>Pagamento por Boleto</h4>
				</div>
				<form id="paymentBoletoForm" class="form-horizontal" name="paymentBoletoForm" method="post">
					<div class="modal-body">
						<p>
							Após clicar em "Finalizar compra" o boleto será gerado.
						</p>
						<div class="form-group">
							<label class="control-label col-md-3" for="paymentBoletoPhone">Seu telefone</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="paymentBoletoPhone" name="paymentBoletoPhone" placeholder="Digite seu telefone de contato com DDD" value="{{ Auth::check() ? Auth::user()->profile->telephone : '' }}"/>
							</div>
						</div>
						<div class="form-group">
							<div class="panel-group col-md-11" id="card-eula">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<label class="eula" for="payment-card-eula">
											<input type="checkbox" id="paymentCardEULA" name="paymentCardEULA"/>
											Aceito o<a href="#collapse-payment-card-eula2" data-toggle="collapse" data-parent="#card-eula">regulamento da oferta e os termos de uso</a>
										</label>
									</div>
									<div id="collapse-payment-card-eula2" class="panel-collapse collapse">
										<div id="print-payment-card-eula" class="panel-body">
											<!-- <a href="javascript:window.print();" class="control">​Imprimir</a> -->
											<!-- <a href="#" class="control print">​Imprimir</a>
											<a href="#" target="_blank" class="control">Download</a> -->
											<h4>Ragulamento da Oferta</h4>
											<p>
                                                {{$offer->rules}}
											</p>
											<h4>​Termos e Condições de Uso​</h4>​
											{{ Configuration::get('clauses') }}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<button type="submit" class="btn btn-primary" id="closeOrderBoleto">Finalizar compra</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="modal-payment-credit" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="glyphicon glyphicon-asterisk"></span>Compra por Crédito e/ou Cupom de Desconto</h4>
				</div>
				<form id="paymentCreditForm" class="form-horizontal" name="paymentCreditForm" method="post">
					<div class="modal-body">
						<p>
							Após clicar em "Finalizar compra" seu cupom será disponibilizado em sua conta.
						</p>
						<div class="form-group">
							<div class="panel-group col-md-11" id="card-eula">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
										<label class="eula" for="payment-card-eula">
											<input type="checkbox" id="paymentCardEULA" name="paymentCardEULA"/>
											Aceito o<a href="#collapse-payment-card-eula2" data-toggle="collapse" data-parent="#card-eula">regulamento da oferta e os termos de uso</a>
										</label>
									</div>
									<div id="collapse-payment-card-eula2" class="panel-collapse collapse">
										<div id="print-payment-card-eula" class="panel-body">
											<!-- <a href="javascript:window.print();" class="control">​Imprimir</a> -->
											<!-- <a href="#" class="control print">​Imprimir</a>
											<a href="#" target="_blank" class="control">Download</a> -->
											<h4>Ragulamento da Oferta</h4>
											<p>
                                                {{$offer->rules}}
											</p>
											<h4>​Termos e Condições de Uso​</h4>​
											{{ Configuration::get('clauses') }}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8">
								<button type="submit" class="btn btn-primary" id="closeOrderCredit">Finalizar compra</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="donation-info" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-combo">
			<div class="modal-content">
				<div class="modal-header">
					<img src="{{$offer->ngo->img}}">
					<h4 class="modal-title">{{$offer->ngo->name}}</h4>
				</div>
				<div class="modal-body">
					<p>
                        {{$offer->ngo->description}}
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="entypo cross"></span>Não, obrigado</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="entypo check"></span>Sim, eu quero ajudar</button>
				</div>
			</div>
		</div>
	</div>

	<div id="regulation" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><span class="entypo text-doc"></span>Regulamento da Oferta</h3>
				</div>
				<div class="modal-body">
					<p>
                        {{$offer->rules}}
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><span class="entypo check"></span>Concordo</button>
				</div>
			</div>
		</div>
	</div>

	<div id="promocode-modal" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm text-center">
			<div class="modal-content">
				<div class="modal-body">
					<h4 class="modal-title">Atenção</h4><br/>
					<p>
						Código do cupom inválido.
					</p><br/>
					<button type="submit" class="btn" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
    @foreach($offer->active_offer_additional as $k => $additional)
        <!-- Infos de {{$additional->title}}-->
        <div id="combo{{$additional->id}}-info" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-sm modal-combo combo-control">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="percent-off tooltip" data-tip="Economize {{$additional->percent_off}}%"><strong>{{$additional->percent_off}}</strong>OFF</div>
                        <img src="{{$additional->offer->cover_img}}" alt="{{$additional->title}}">
                        <h4 class="modal-title">{{$additional->offer->title}} <span class="entypo chevron-right"></span>{{$additional->title}}</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            {{$additional->offer->popup_features}}
                        </p>
                        <div class="prices-info">
                            <div class="prices clearfix">
                                <div class="price price-original">De <span>R${{intval($additional->price_original)}},00</span></div>
                                <div class="price price-discount">Por R$<strong>{{intval($additional->price_with_discount)}},00</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="entypo cross"></span>Não, obrigado</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="entypo check"></span>Sim, eu quero</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Infos de {{$additional->title}}-->
    @endforeach
    @if(!Auth::check())
    <script>
        $(function(){
            // user not logged
            userAuth = 0;

            // open modal login on load page if user not logged
            $('#login').modal('show');
            //$('#login').on('hidden.bs.modal', function (e) {
            //    window.location.href = "{{$offer->url}}";
            //})
        });
    </script>
    @else
    <script>
        $(function(){
            // user not logged
            userAuth = 1;
        });
    </script>
    @endif
<script>
    validaCupomURL = "{{route('valida-cupom')}}";
    calc3x = {{Configuration::get('interest-rate-3x')}};
    calc6x = {{Configuration::get('interest-rate-6x')}};
    calc10x = {{Configuration::get('interest-rate-10x')}};

    @if(Input::old('donation') != NULL)
    $('#donation').val("{{ Input::old('donation') }}");
    $('#input-promo-code').val("{{ Input::old('promoCode') }}");
    $('#paymentBoletoPhone').val("{{ Input::old('paymentBoletoPhone') }}");
    $('#paymentCardFlag').val("{{ Input::old('paymentCardFlag') }}");
    $('#paymentCardNumber').val("{{ Input::old('paymentCardNumber') }}");
    $('#paymentCardCode').val("{{ Input::old('paymentCardCode') }}");
    $('#paymentCardValidityMonth').val("{{ Input::old('paymentCardValidityMonth') }}");
    $('#paymentCardValidityYear').val("{{ Input::old('paymentCardValidityYear') }}");
    $('#paymentCardName').val("{{ Input::old('paymentCardName') }}");
    $('#paymentCardCPF').val("{{ Input::old('paymentCardCPF') }}");
    $('#paymentCardPhone').val("{{ Input::old('paymentCardPhone') }}");
    $('#paymentCardInstallment').val("{{ Input::old('paymentCardInstallment') }}");
    @endif
</script>

<script>
var masks = ['(00) 00000-0000', '(00) 0000-00009'],
    maskBehavior = function(val, e, field, options) {
    return val.length > 14 ? masks[0] : masks[1];
};

$('#paymentCardPhone').mask(maskBehavior, {onKeyPress: 
   function(val, e, field, options) {
       field.mask(maskBehavior(val, e, field, options), options);
   }
});
$('#paymentBoletoPhone').mask(maskBehavior, {onKeyPress: 
   function(val, e, field, options) {
       field.mask(maskBehavior(val, e, field, options), options);
   }
});
</script>

@stop
