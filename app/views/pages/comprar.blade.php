@section('javascript')
	<script src="{{ asset('assets/themes/floripa/frontend/js/comprar.js') }}"></script>
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
		
		
		<form class="buy-form">
			<div class="row">

				<div class="col-12 col-sm-12 col-lg-12 clearfix">
                    <ul class="buy-itens buy-combo checkout-combo nocheck">
                        <h3>Inclua também <span class="glyphicon glyphicon-chevron-down"></span></h3>
                    @if($offer->offer_additional->toArray() && count($offer->offer_additional->toArray()) > count($add))
                        @foreach($offer->offer_additional as $k => $additional)
                            @if(!in_array($additional->id, $add))
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
                    </ul>

					<ul class="buy-itens checkout-itens nocheck">

						<h3>Sua compra <span class="glyphicon glyphicon-chevron-down"></span></h3>
                        @foreach($offer->offer_option()->get() as $k => $option)
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
                                    </div>
                                    <div class="price">R$<strong>{{intval($option->price_with_discount)}}</strong></div>
                                </li>
                            @endif
                        @endforeach
                        @if($offer->offer_additional->toArray() && count($add) > 0)
                            @foreach($offer->offer_additional as $k => $additional)
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
							<figure><img src="http://innbativel.s3.amazonaws.com/ecoa.jpg" title="Ajude o planeta"></figure>
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
						<!-- no credits, data-credits="0" -->
						<li data-credits="30" class="green">
							<div class="offer-combo">
								<strong>Seus créditos</strong><br/>
								Você tem créditos que serão abatidos do total da compra
							</div>
							<div class="price discount">- R$<strong></strong></div>
						</li>
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
							<div id="total-price" class="price">R$<strong>270</strong></div>
						</li>
						<li class="payment">
							<div class="offer-combo">
								<strong>Pagamento:</strong><br/>
							</div>
							<div>
								<button id="payment-card" class="btn btn-primary">Cartão de Crédito</button>
							</div>
							<div>
								<button id="payment-boleto" class="btn btn-primary">Boleto</button>
							</div>
						</li>
					</ul>

				</div>
		
			</div>
		</form>
	</div>

	<div id="modal-payment-confirmed" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo check"></span>Compra finalizada</h4>
				</div>
				<form id="contactForm" class="form-horizontal" name="contactForm" method="post" action="send_form_contact.php">
					<div class="modal-body">
						<p>
							<strong>Obrigado por comprar no INNBatível!</strong>
						</p>
						<p>
							Assim que o pagamento for aprovado, seu cupom estará disponível em sua conta.
						</p>
						<p>
							Por favor, responda<a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">esta pesquisa</a>e ajude-nos a melhorar nosso atendimento e tornar sua experiência de compras cada vez melhor.<br></p>
						</p>
						<p>
							<a href="https://www.ebitempresa.com.br/bitrate/pesquisa1.asp?empresa=1407475" target="_blank">
								<img border="0" name="banner" src="https://www.ebitempresa.com.br/bitrate/banners/b1407475.gif" alt="O que você achou desta loja?" width="468" height="60"></a>
						</p>
						<p>
							Você será redirecionado para sua conta.
						</p>
						<!-- <div class="form-group">
							<div class="col-md-offset-3 col-md-7">
								<button type="submit" class="btn btn-default" data-dismiss="modal">Acessar minha conta</button>
							</div>
						</div> -->
					</div>
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
				<form id="paymentCardForm" class="form-horizontal" name="paymentCardForm" method="post" action="send_form_payment_card.php">
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
									<option value="visa">Visa</option>
									<option value="master">MasterCard</option>
									<option value="amex">American Express</option>
									<option value="diners">Diners Club</option>
									<option value="elo">Elo</option>
									<option value="discover">Discover</option>
									<option value="jcb">JCB</option>
									<option value="aura">Aura</option>
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
									<option value="1">01 - Janeiro</option>
									<option value="2">02 - Fevereiro</option>
									<option value="3">03 - Março</option>
									<option value="4">04 - Abril</option>
									<option value="5">05 - Maio</option>
									<option value="6">06 - Junho</option>
									<option value="7">07 - Julho</option>
									<option value="8">08 - Agosto</option>
									<option value="9">09 - Setembro</option>
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
							<label class="control-label col-md-2" for="paymentCardCPF">CPF</label>
							<div class="col-md-4">
								<input type="text" class="form-control" id="paymentCardCPF" name="paymentCardCPF" placeholder="CPF do titular" />
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
										<option value="1">&nbsp;&nbsp;1x R$200,00</option>
										<option value="2">&nbsp;&nbsp;3x R$ &nbsp;68,00</option>
										<option value="3">&nbsp;&nbsp;6x R$ &nbsp;36,00</option>
										<option value="4">10x R$ &nbsp;22,00</option>
									</select>
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
											<a href="#" class="control print">​Imprimir</a>
											<a href="#" target="_blank" class="control">Download</a>
											<h4>Ragulamento da Oferta</h4>
											<ul>
												<li>Utilize seu cupom de 20/03/14 a 21/12/14 (exceto P&aacute;scoa), mediante disponibilidade.&nbsp;</li>
												<li>Ao clicar em &ldquo;comprar&rdquo; escolha a op&ccedil;&atilde;o:</li>
											</ul>
											<p><strong>Op&ccedil;&atilde;o 1:</strong> 2 di&aacute;rias durante a semana (exceto feriados prolongados) de R$664 por R$199.</p>
											<p><strong>Op&ccedil;&atilde;o 2:</strong> 2 di&aacute;rias de sexta a domingo (exceto feriados prolongados) de R$664 por R$249.</p>
											<p><strong>Op&ccedil;&atilde;o 3:</strong> 3 di&aacute;rias de sexta a domingo (exceto feriados prolongados) de R$996 por R$359.</p>
											<p><strong>Op&ccedil;&atilde;o 4:</strong> 3 di&aacute;rias no feriado do Dia do Trabalho de R$996 por R$359.</p>
											<p><strong>Op&ccedil;&atilde;o 5:</strong> 3 di&aacute;rias no feriado de Corpus Christi de R$996 por R$359.</p>
											<ul>
												<li>V&aacute;lido exclusivamente para 2 pessoas. Incluso caf&eacute; da manh&atilde;.</li>
												<li>Sem limite de compra. Compre quantos cupons quiser.</li>
												<li><strong>N&atilde;o inclui taxa de servi&ccedil;o</strong><strong>&nbsp;e despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, </strong><strong>estacionamento</strong><strong> e outros consumos n&atilde;o citados na oferta, a ser pago no </strong><strong>check-out.</strong></li>
												<li>1 crian&ccedil;a com at&eacute; 10 anos possui hospedagem cortesia (no mesmo apartamento dos pais).</li>
												<li>Check-in a partir das 14h e check-out at&eacute; as 12h. Late check-out permitido, mediante disponibilidade e consulta pr&eacute;via.</li>
												<li>Para hospedagem de mais pessoas ou aquisi&ccedil;&atilde;o de di&aacute;ria extra, consulte o hotel.</li>
											</ul>
											<p><span style="text-decoration: underline;">Reservas</span></p>
											<ul>
												<li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail <a href="mailto:reservas@praiamole.com.br" target="_blank">reservas@praiamole.com.br</a> informando o c&oacute;digo do cupom.</li>
												<li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada &agrave; disponibilidade do hotel para a oferta.</li>
												<li>&Eacute; permitido fazer 1 reagendamento com, no m&iacute;nimo, 7 dias de anteced&ecirc;ncia.</li>
												<li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li>
												<li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es ligue: </strong><strong>(48) 3239-7500.</strong></li>
												<li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li>
											</ul>
											<p><span style="text-decoration: underline;">Cupom</span></p>
											<ul>
												<li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li>
												<li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li>
												</ul>
												<p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p>
												<ul>
												<li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrada qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento, entre em contato com o INNBat&iacute;vel atrav&eacute;s do e-mail <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li>
												<li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li>
											</ul>
											<h4>​Termos e Condições de Uso​</h4>​
											<p>
												AO CLICAR O BOTÃO “ACEITO” DA PÁGINA DE REGISTRO, O USUÁRIO ESTARÁ DECLARANDO TER LIDO E ACEITO INTEGRALMENTE, SEM QUALQUER RESERVA, ESTE CONTRATO QUE TEM COMO PARTES O USUÁRIO (“USUÁRIO”) E A ASN SERVICOS DE INFORMACOES DIGITAIS NA WEB LTDA., INSCRITA NO CNPJ SOB O Nº 12.784.420/0001-95 (“INNBATÍVEL”), LOCALIZADA NA ROD. ARMANDO CALIL BULOS, Nº 5405, FLORIANÓPOLIS - SC. ALÉM DISSO, O USUÁRIO ESTARÁ DECLARANDO QUE É MAIOR DE IDADE OU EMANCIPADO E QUE GOZA DE PLENA CAPACIDADE CIVIL E PENAL. CASO NÃO CONCORDE COM ESTE CONTRATO, O USUÁRIO NÃO DEVERÁ UTILIZAR O SITE.</p>
											<p>
												OS PAIS OU OS REPRESENTANTES LEGAIS DE MENOR DE IDADE RESPONDERÃO PELOS ATOS POR ELE PRATICADOS SEGUNDO ESTE CONTRATO, DENTRE OS QUAIS EVENTUAIS DANOS CAUSADOS A TERCEIROS, PRÁTICAS DE ATOS VEDADOS PELA LEI E PELAS DISPOSIÇÕES DESTE CONTRATO, SEM PREJUÍZO DA RESPONSABILIDADE DO CONTRATANTE, SE ESTE NÃO FOR O PAI OU O REPRESENTANTE LEGAL DO MENOR INFRATOR.</p>
											<p>
												Este Contrato regula a utilização dos serviços de intermediação de negócios e promoções, por meio da compra de cupons para obtenção de ofertas ou promoções de serviços oferecidos por terceiros licenciantes por meio do Site de propriedade do INNBatível, bem como qualquer documentação on-line ou eletrônica relacionada.</p>
											<p>
												AVISO IMPORTANTE:</p>
											<p>
												O Usuário está ciente de que o tráfego de dados que lhe dá acesso ao Site é suportado por um serviço prestado pela operadora de serviços de telecomunicações escolhido e contratado pelo Usuário e que tal contratação é completamente independente do Site. O Usuário está ciente, ainda, de que os encargos cobrados pela operadora de serviços de telecomunicação (WAP, GPRS) de sua escolha e os impostos aplicáveis podem incidir no tráfego de dados necessário a eventuais downloads e de anúncios de terceiros para seu dispositivo.</p>
											<p>
												1. Concessão de Licença de Uso. O INNBatível presta um serviço interativo de intermediação de serviços e/ou produtos de terceiros, por meio da publicação de ofertas e promoções (“Promoções”) no Site, a serem adquiridas, observadas certas condições, por meio da compra de cupons (“Cupons”). Tais serviços são operados e administrados pelo INNBatível na rede mundial de computadores (“Internet”).</p>
											<p>
												1.1 O INNBatível, neste ato, concede ao Usuário uma licença pessoal limitada, não exclusiva, não transferível, revogável, por prazo indeterminado, consoante este Contrato, para utilizar o Site, a fim de avaliar, manifestar o interesse em adquirir e eventualmente adquirir as Promoções. O direito de utilização do Site é pessoal e intransferível. Para fins de cadastramento, o Usuário forneceu ao INNBatível as informações necessárias ao seu cadastramento e criou um nome (login) e uma senha (password). O Usuário declara e reconhece que as informações sobre si fornecidas são verdadeiras, corretas, atuais e completas, responsabilizando-se civil e criminalmente por essas informações. Caso os dados informados pelo Usuário no momento do cadastramento estejam errados ou incompletos, impossibilitando a comprovação e identificação do Usuário, o INNBatível terá o direito de suspender imediatamente a prestação de serviços prestados por meio do Site, sem necessidade de prévio aviso, e haver do Usuário as perdas e danos eventualmente sofridos.</p>
											<p>
												1.2 O Usuário é responsável pela proteção da confidencialidade de sua senha pessoal. O Usuário autoriza expressamente ao INNBatível a manter em seu cadastro as informações fornecidas pelo Usuário, bem como autoriza ao INNBatível a fornecer as informações constantes de referido cadastro (i) a autoridades públicas que as solicitarem conforme permitido pela legislação em vigor e (ii) a seus parceiros estratégicos, comerciais ou técnicos, com a finalidade de oferecer melhores condições de Promoções e/ou conteúdos ao Usuário. Ademais, o Usuário autoriza expressamente ao INNBatível coletar informações para realização de acompanhamento de tráfego, com intuito de identificar grupos e perfis de usuários, bem assim para fins de orientação publicitária.</p>
											<p>
												1.3 Sem prejuízo do disposto acima, não serão aceitos e poderão ser cancelados, a qualquer tempo, endereços de correio eletrônico (e-mail) que contenham expressões ou conjuntos gráfico-denominativos que já tenham sido escolhidos anteriormente por outro usuário ou, de outra forma, que sejam injuriosos, malsoantes, coincidentes com marcas, nomes comerciais, títulos de estabelecimentos, razões sociais de empresas, expressões publicitárias, nomes e pseudônimos de pessoas de relevância pública, famosos ou registrados por terceiros, cujo uso não esteja autorizado ou que sejam, em geral, contrários à lei ou às exigências da moral e bons costumes geralmente aceitos, bem como expressões que possam induzir outras pessoas a erro, sendo certo que o Usuário responderá pelo uso indevido, tanto no âmbito civil quanto criminal, se aplicável.</p>
											<p>
												1.4 O Usuário se compromete a comunicar ao INNBatível por meio do serviço de atendimento ao cliente (“SAC”) no e-mail: <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a> ou pelo telefone (48) 3365.2790, o extravio, perda, furto ou roubo das senhas de acesso imediatamente após o conhecimento do fato. Até o momento em que efetivamente comunicar ao INNBatível o extravio, perda, furto ou roubo de senha de acesso, o Usuário será o único responsável pelos gastos e/ou prejuízos decorrentes da sua eventual utilização por terceiros, não tendo o INNBatível qualquer responsabilidade por eventuais danos decorrentes de tais fatos.</p>
											<p>
												2. Continuidade dos Serviços. O Usuário reconhece que poderão ocorrer (ii) interrupções na prestação dos serviços ou, ainda, (i) outros fatos ocorridos por motivos fora do controle do INNBatível. O INNBatível não será responsabilizado por quaisquer dados perdidos durante a transmissão de informação por meio da Internet.</p>
											<p>
												2.1 Embora o INNBatível envide todos os esforços possíveis para manter o Site em funcionamento durante 24 (vinte e quatro) horas por dia, 7 (sete) dias por semana, é possível que haja momentos em que o Site fique indisponível por diferentes motivos, inclusive em virtude da realização de manutenções rotineiras. Desta forma, o acesso ao Site e a prestação dos serviços podem ser interrompidos, suspensos ou encerrados, a qualquer momento, a exclusivo critério do INNBatível.</p>
											<p>
												2.2 O INNBatível possui o direito de, a qualquer momento e a seu exclusivo critério, descontinuar, suspender, terminar ou alterar a forma de acesso ao Site com relação a qualquer conteúdo, período de disponibilidade e equipamentos necessários ao acesso e/ou utilização do Site. O INNBatível reserva-se o direito de descontinuar a disseminação de qualquer informação, alterar ou eliminar métodos de transmissão, alterar velocidade de transmissão de dados ou quaisquer outras características de sinal. O INNBatível reserva-se o direito de, a qualquer tempo, descontinuar ou alterar o Contrato, sem necessidade de prévia notificação ao Usuário, podendo, inclusive, optar por cobrar eventuais taxas de inscrição e/ou eventuais remunerações, sendo que neste caso, a mudança só terá efeito e será aplicável às aquisições futuras dos Usuários.</p>
											<p>
												3. Equipamentos para Utilização do Site e Capacitação Técnica. O Usuário será o único responsável por adquirir e realizar a manutenção de aparelho de telefone, computador e quaisquer outros equipamentos que venham a ser necessários ao perfeito acesso e uso do Site. O Usuário será o único responsável por eventuais danos que seu equipamento vier a sofrer em decorrência do mau uso de qualquer hardware, software ou conexões.</p>
											<p>
												4. Características Individuais e Serviços. Ao utilizar o Site, o Usuário estará sujeito a quaisquer outras diretrizes ou regras aplicáveis aos serviços disponibilizados, que possam vir a ser informadas, de tempos em tempos, as quais ficam automaticamente incorporadas por referência a este Contrato. O Usuário está ciente de que algumas Promoções poderão estar sujeitas a determinadas condições para que se tornem exeqüíveis (p.ex., que determinado número de usuários manifeste o interesse em adquirir o Cupom referente a tal Promoção). O INNBatível não será responsável (i) pela não verificação de uma condição necessária à efetivação da Promoção, bem assim (ii) pela qualidade dos serviços e/ou produtos objeto das Promoções veiculadas a pedido de terceiros licenciantes.</p>
											<p>
												4.1 O INNBatível, uma vez verificada a condição necessária para aquisição do Cupom pelo Usuário, poderá debitar o valor de compra do Cupom diretamente do Usuário, sem necessidade de qualquer autorização adicional ou aviso prévio.</p>
											<p>
												5. Direito de Arrependimento e Política de Cancelamento e Estorno. Uma vez adquirido o Cupom por meio do Site, o Usuário somente poderá cancelá-lo nas situações previstas abaixo e desde que não tenha resgatado/utilizado/validado o Cupom junto ao efetivo fornecedor do bem ou serviço adquirido:</p>
											<p>
												5.1. Em até 14 (quatorze) dias, contados da disponibilização do Cupom na conta pessoal do Usuário mantida no Site, o Usuário poderá solicitar o cancelamento do Cupom, optando, a seu exclusivo critério, pelo estorno do pagamento pelo mesmo meio de pagamento utilizado na aquisição do Cupom ou pela disponibilização da quantia correspondente ao exato valor pago em créditos na conta pessoal do Usuário no Site, que poderá ser utilizado pelo Usuário na aquisição de qualquer outra Promoção. Uma vez optado pelo estorno em créditos, o Usuário deverá estar ciente de que tais créditos não poderão ser futuramente revertidos em dinheiro.</p>
											<p>
												<span style="font-size: 12px;">5.2. Em quaisquer das hipóteses acima, seja qual for o prazo, caso o Cupom tenha sido resgatado/utilizado/validado pelo Usuário junto ao efetivo fornecedor dos serviços adquiridos, o INNBatível não mais efetuará o cancelamento do mesmo.</span></p>
											<p>
												5.3. Após resgate/utilização/validação do Cupom junto ao fornecedor do serviço, o INNBatível não será mais responsável pelo cancelamento do Cupom, qualquer que seja o motivo.</p>
											<p>
												5.4. O Usuário está ciente de que determinados Cupons somente poderão ser utilizados durante um prazo determinado ou em dias específicos. A não utilização do Cupom no prazo e/ou data constantes do Cupom não ensejará sua devolução ou troca.</p>
											<p>
												6. Modificações ao Contrato. O INNBatível se reserva o direito de, a seu exclusivo critério, efetuar alterações no Contrato sem necessidade de prévia notificação. Desta forma, é recomendável que o Usuário releia este documento regularmente, de forma a se manter sempre informado sobre eventuais mudanças ocorridas.</p>
											<p>
												6.1. Se houver qualquer mudança no Contrato e o Usuário continuar utilizando o Site, o Contrato será considerado lido e aprovado pelo Usuário. Todas as alterações no Contrato tornar-se-ão efetivas imediatamente a partir de sua publicação no Site, sem a necessidade de qualquer aviso prévio ao Usuário.</p>
											<p>
												6.2. Em qualquer hipótese, as mudanças no Contrato somente terão efeito e serão aplicáveis às aquisições futuras do Usuário.</p>
											<p>
												7. Propriedade do Conteúdo do Site. Todo o conteúdo disponível no Site, incluindo os Microsites, é de propriedade exclusiva do INNBatível e de seus terceiros licenciantes. É proibida a cópia, distribuição, transmissão, publicação, conexão ou qualquer outro tipo de modificação do Site ou dos Microsites sem expressa autorização do INNBatível.</p>
											<p>
												7.1 Qualquer violação do disposto nesta cláusula constituirá infração de direitos de propriedade intelectual e sujeitará o Usuário às sanções administrativas, civis e criminais aplicáveis.</p>
											<p>
												7.2 O INNBatível e seus terceiros licenciantes reservam-se todos os direitos não expressamente licenciados de acordo com este Contrato. O Usuário declara e reconhece que o download de qualquer conteúdo do Site não lhe confere a propriedade sobre quaisquer marcas exibidas no Site.</p>
											<p>
												7.3 Quaisquer marcas exibidas no Site ou qualquer outro site operado em conjunto com o INNBatível não devem ser consideradas como de domínio público e são de propriedade exclusiva do INNBatível ou de seus terceiros licenciantes.</p>
											<p>
												7.4 O Usuário não deverá fazer upload, publicar ou de qualquer forma disponibilizar no Site qualquer material protegido por direitos autorais, registro de marcas ou qualquer outro direito de propriedade intelectual sem a prévia e expressa autorização do titular do referido direito.</p>
											<p>
												7.5 O INNBatível não tem o dever ou a responsabilidade de fornecer ao Usuário quaisquer indicações que auxiliem na identificação do conteúdo como protegido por direitos de propriedade intelectual. O Usuário será o único responsável por quaisquer danos causados a terceiros, que resultem de violação de direitos de propriedade intelectual, em virtude da utilização do referido conteúdo.</p>
											<p>
												8. Acesso e Uso do Site. Tanto o Site, quanto quaisquer outros sites, de qualquer maneira disponibilizados no Site (“Microsites”) são de propriedade privada e quaisquer interações devem ser realizadas de acordo com este Contrato. Sem prejuízo das demais obrigações do Usuário estabelecidas segundo o Contrato, o Usuário obriga-se a (i) não utilizar os conteúdos e produtos do Site com a finalidade de desrespeitar a lei, a moral, os bons costumes, as normas de direito autoral e/ou propriedade industrial, ou os direitos à honra, à vida privada, à imagem, à intimidade pessoal e familiar; (ii) observar os mais elevados padrões éticos e morais vigentes na Internet e as leis nacionais e internacionais aplicáveis; (iii) não utilizar os serviços, conteúdos e produtos fornecidos conforme o Contrato para transmitir ou divulgar material ilegal, difamatório, que viole a privacidade de terceiros, ou que seja abusivo, ameaçador, obsceno, prejudicial, vulgar, injurioso, ou de qualquer outra forma censurável; (iv) não enviar mensagens não-solicitadas, reconhecidas como "spam", "junk mail" ou correntes de correspondência ("chain letters"); não utilizar os serviços, conteúdos e produtos fornecidos conforme o Contrato para enviar/divulgar quaisquer tipos de vírus ou arquivos contendo quaisquer tipos de vírus (p.ex., "Cavalos de Tróia") ou que possam causar danos ao seu destinatário ou a terceiros; (v) cumprir todas as leis aplicáveis com relação à transmissão de dados a partir do Brasil ou do território onde o Usuário resida; (vi) não obter ou tentar obter acesso não-autorizado a outros sistemas ou redes de computadores conectados aos conteúdos e produtos do Site; (vii) responsabilizar-se integralmente pelo conteúdo dos e-mails que vier a transmitir ou retransmitir bem como pelo conteúdo e informações que vier a disponibilizar nas Promoções do Site; (viii) não interferir ou interromper os serviços ou os servidores ou redes conectados aos os serviços, conteúdos e produtos fornecidos por meio do Site ou Microsites, conforme o Contrato; e (ix) cumprir todos procedimentos, políticas, normas e regulamentos aplicáveis aos conteúdos e produtos do Site, divulgados nas páginas e links de cada conteúdo/produto ou Microsites.</p>
											<p>
												8.1 Além do disposto acima, o Usuário não poderá postar ou transmitir por meio do Site qualquer conteúdo ou informação que contenha qualquer propaganda ou proposta relacionada a quaisquer produtos e/ou serviços. O Usuário não poderá divulgar ou fazer qualquer oferta comercial, religiosa, política, ou qualquer outra oferta mesmo que sem fins comerciais, incluindo, mas não limitando oferta aos Usuários para que se tornem Usuários de outros serviços que de qualquer maneira possam competir com os serviços prestados pelo INNBatível ou quaisquer dos terceiros licenciantes, de acordo com este Contrato.</p>
											<p>
												8.2 Qualquer conduta do Usuário que, a critério exclusivo do INNBatível, possa vir a restringir ou inibir o uso do Site ou Microsites por demais Usuários ou terceiros fica expressamente proibida.</p>
											<p>
												9. Preço e Pagamento pelos Serviços. Atualmente, o fornecimento dos conteúdos e produtos constantes do Site é realizado em favor do Usuário sem necessidade de pagamento de remuneração ao INNBatível, que realizará somente a intermediação das operações de compra e venda dos Cupons referentes a Promoções oferecidas ao Usuário pelos terceiros licenciantes.</p>
											<p>
												10. Aceitação do Recebimento de Mensagens. O Usuário expressamente aceita que o INNBatível e/ou qualquer de seus parceiros enviem ao Usuário mensagens de e-mail ou de SMS de caráter informativo, referentes a comunicações específicas referentes a Promoções veiculadas em diversas praças de atuação, que estejam ou que venham a ser disponibilizadas no Site, bem como outras mensagens de natureza comercial, tais como ofertas dos terceiros licenciantes da INNBatível, novidades do Site. Caso o Usuário não deseje mais receber referidas mensagens deverá solicitar o cancelamento do seu envio no próprio Site, ou clicar no link “remova aqui” que se localiza no rodapé de todos os e-mails enviados.</p>
											<p>
												11. Privacidade das Informações. O INNBatível somente compartilha as informações pessoais dos Usuários com empresas afiliadas do INNBatível, única e exclusivamente com o objetivo de dar cumprimento ao fornecimentos dos bens e serviços, quando necessário e assim constar nas regras da oferta, ou em circunstâncias específicas como ordem judicial ou por determinação legal, quando a ordem advir de autoridades policiais. O INNBatível toma todas as medidas de segurança adequadas de proteção contra acesso, alteração, divulgação ou destruição não autorizada dos dados. Essas medidas incluem análises internas de práticas de coleta, armazenamento e processamento de dados e medidas de segurança, incluindo criptografia e medidas de segurança físicas apropriadas para proteção contra o acesso não autorizado a sistemas de armazenamento de dados pessoais. Todo o acesso aos dados dos Usuários é limitado aos funcionários, contratantes e agentes do INNBatível, de forma escalonada e com conteúdo limitado conforme a função e o tipo de processamento de tais informações para processamento em nome do INNBatível. Essas pessoas firmam contratos com o INNBatível que contém obrigações específicas de confidencialidade e podem ser submetidas a punições, incluindo rescisão de contrato e processo criminal, caso não cumpram tais obrigações.</p>
											<p>
												12. Isenções; Garantia. OS SERVIÇOS OU APLICAÇÕES DE TERCEIROS, DISPONIBILIZADOS EM CONJUNTO OU POR MEIO DO SITE, SÃO FORNECIDOS "TAL COMO ESTÃO" E "CONFORME DISPONÍVEIS" SEM GARANTIAS OU CONDIÇÕES DE QUALQUER TIPO, SEJAM ELAS EXPRESSAS OU IMPLÍCITAS. ATÉ A EXTENSÃO MÁXIMA PERMISSÍVEL EM CONFORMIDADE COM A LEGISLAÇÃO APLICÁVEL, O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS EXIMEM-SE DE TODAS AS GARANTIAS E CONDIÇÕES, EXPRESSAS OU IMPLÍCITAS, INCLUSIVE GARANTIAS IMPLÍCITAS E CONDIÇÕES DE COMERCIALIZAÇÃO, ADEQUAÇÃO PARA UM DETERMINADO OBJETIVO E NÃO VIOLAÇÃO DE DIREITOS DE PROPRIEDADE.</p>
											<p>
												12.1 O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS NÃO GARANTEM QUE OS SERVIÇOS DISPONIBILIZADOS NO SITE SEJAM ININTERRUPTOS OU LIVRES DE ERROS, QUE OS DEFEITOS SEJAM CORRIGIDOS, OU QUE OS SERVIÇOS OU O SERVIDOR QUE OS DISPONIBILIZA SEJA LIVRE DE VÍRUS OU OUTROS COMPONENTES PREJUDICIAIS.</p>
											<p>
												12.2 O INNBATÍVEL, SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS NÃO GARANTEM NEM FAZEM QUAISQUER DECLARAÇÕES RELATIVAS AO USO OU AOS RESULTADOS DA UTILIZAÇÃO DOS SERVIÇOS E DO SITE EM TERMOS DE EXATIDÃO, PRECISÃO, CONFIABILIDADE, OU DE QUALQUER OUTRA FORMA. O USUÁRIO ASSUME TODO O CUSTO DE QUALQUER SERVIÇO NECESSÁRIO, REMEDIAÇÕES OU CORREÇÕES. O USUÁRIO COMPREENDE E CONCORDA QUE ACESSARÁ O SITE E UTILIZARÁ O SITE A SEU EXCLUSIVO CRITÉRIO E PRÓPRIO RISCO E QUE SERÁ O ÚNICO RESPONSÁVEL POR QUAISQUER DANOS CAUSADOS AO SEU SISTEMA DE COMPUTADOR OU SEU DISPOSITIVO MÓVEL OU PERDA DE DADOS RESULTANTES DA UTILIZAÇÃO DOS SERVIÇOS OU DO DOWNLOAD DE MATERIAIS OU DADOS CONTIDOS NO SITE OU MICROSITES.</p>
											<p>
												13. Limites de Responsabilidade. EM NENHUMA CIRCUNSTÂNCIA, O INNBATÍVEL OU SUAS AFILIADAS, CONTRATADAS, FUNCIONÁRIOS, AGENTES OU OUTROS PARCEIROS, TERCEIROS LICENCIANTES OU FORNECEDORES SERÃO RESPONSÁVEIS POR QUAISQUER PERDAS E DANOS SOFRIDOS PELO USUÁRIO OU QUALQUER TERCEIRO QUE RESULTAREM DO SEU USO, DOS MATERIAIS DISPONÍVEIS NO SITE OU QUALQUER OUTRA INTERAÇÃO COM O SITE OU COM O INNBATÍVEL.</p>
											<p>
												13.1 ESTAS LIMITAÇÕES TAMBÉM SE APLICARÃO COM RESPEITO ÀS PERDAS E DANOS SOFRIDOS PELO USUÁRIO OU QUALQUER TERCEIRO EM RELAÇÃO A QUAISQUER PRODUTOS, SERVIÇOS, OFERTAS OU PROMOÇÕES VENDIDOS OU FORNECIDOS POR TERCEIROS, QUE NÃO O INNBATÍVEL, DIVULGADOS NOS ANÚNCIOS OU MATERIAIS PUBLICITÁRIOS ENCONTRADOS NO SITE.</p>
											<p>
												13.2 EM NENHUMA CIRCUNSTÂNCIA O INNBATÍVEL SERÁ RESPONSÁVEL PELA QUALIDADE, PONTUALIDADE OU EXATIDÃO DOS SERVIÇOS PRESTADOS E/OU DOS PRODUTOS OFERTADOS POR SEUS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS, E ANUNCIADOS NO SITE.</p>
											<p>
												13.3 AO INNBATÍVEL RESERVA-SE O DIREITO DE CANCELAR PROMOÇÕES ANUNCIADAS NO SITE, A QUALQUER TEMPO, NOS CASOS EM QUE O INNBATÍVEL IDENTIFIQUE QUALQUER RISCO AOS USUÁRIOS, POR INDÍCIOS DE QUE OS FORNECEDORES, TERCEIROS LICENCIANTES E DEMAIS PARCEIROS DEMONSTREM QUE NÃO IRÃO CUMPRIR COM OS EXATOS TERMOS DAS PROMOÇÕES, DEVENDO O INNBATÍVEL EFETUAR O REGULAR ESTORNO INTEGRAL DO PAGAMENTO EFETUADO PELO USUÁRIO NA AQUISIÇÃO DO CUPOM, PELO MESMO MEIO DE PAGAMENTO UTILIZADO.</p>
											<p>
												14. Base do Negócio. O Usuário concorda que as exclusões de garantia e limitações de responsabilidade estabelecidas acima são elementos fundamentais da base do Contrato ora celebrado com o INNBatível.</p>
											<p>
												14.1 O Usuário concorda, ainda, que o INNBatível não poderia prestar os serviços e/ou fornecer os produtos disponíveis no Site em uma base economicamente razoável sem essas limitações.</p>
											<p>
												14.2 O Usuário reconhece e concorda que as exclusões de garantia e limitações de responsabilidade refletem uma alocação razoável e justa de riscos entre o Usuário e o INNBatível. A exclusão de garantia e as limitações de responsabilidades acima são estendidas para o benefício de todos os terceiros licenciantes do INNBatível.</p>
											<p>
												15. Indenização. O INNBatível não será responsável pelo uso indevido ou inapropriado do Site pelo Usuário, nem por quaisquer perdas e danos sofridos pelo Usuário ou por qualquer terceiro em decorrência do seu uso indevido ou inapropriado.</p>
											<p>
												15.1 O Usuário concorda em guardar e manter o INNBatível, suas empresas afiliadas e seus fornecedores, terceiros licenciantes, parceiros a salvo e a indenizá-los por quaisquer reclamações, processos, ações, perdas, danos, bem como quaisquer outras responsabilidades (inclusive honorários advocatícios) decorrentes de seu uso ou utilização indevida do Site, de violação deste Contrato, violação dos direitos de qualquer outra pessoa ou entidade, ou qualquer violação das declarações, garantias e acordos feitos aqui pelo Usuário. O INNBatível reserva-se o direito de, as suas custas, assumir a defesa exclusiva e o controle de qualquer questão para com a qual Usuário esteja obrigado a indenizar o INNBatível, ficando, neste caso, o Usuário obrigado, desde já, a cooperar com a defesa do INNBatível.</p>
											<p>
												16. Rescisão. O presente Contrato é celebrado por prazo indeterminado, entrando em vigor na data de sua aceitação pelo Usuário, na forma do presente. O Usuário poderá dar por findo o presente a qualquer tempo e independentemente de motivo, mediante contato com SAC do INNBatível, sem que isto gere para qualquer das partes o direito de haver da outra indenização ou qualquer outra quantia. Neste caso, o presente Contrato será rescindido no último dia do mês civil em que o Usuário contatar o SAC do INNBatível.</p>
											<p>
												16.1 O INNBatível poderá dar por findo o presente contrato, a qualquer tempo e independentemente de motivo ou aviso dirigido ao Usuário, sem que isto gere para qualquer das partes o direito de haver da outra indenização ou qualquer outra quantia.</p>
											<p>
												16.2 O presente contrato será rescindido de pleno direito, independentemente de aviso ou notificação, podendo o INNBatível imediatamente cancelar todos os serviços, conteúdos e produtos objeto do presente, caso o Usuário venha a violar qualquer das suas obrigações previstas no Contrato, sem prejuízo do dever do Usuário de indenizar ao INNBatível.</p>
											<p>
												16.3 O INNBatível poderá suspender os serviços, conteúdos e produtos objeto do presente Contrato, caso haja suspeita ou indício de que o Usuário esteja utilizando os serviços, conteúdos e produtos do Site para a veiculação de fotografias e imagens associadas ou de qualquer forma relacionadas a pornografia infantil, ou ainda relacionadas a idéias preconceituosas quanto à origem, raça, etnia, sexo, orientação sexual, cor, idade, crença religiosa ou quaisquer outras formas de discriminação, sem prejuízo do dever do Usuário de indenizar ao INNBatível caso comprovada a violação ao presente.</p>
											<p>
												16.4 Com o término, por qualquer motivo, do presente contrato, todos os serviços, conteúdos e produtos fornecidos de acordo com o presente serão imediatamente interrompidos e cancelados e todo e qualquer arquivo, conteúdo, informação ou dados armazenados pelo Usuário nestes serviços, produtos e/ou conteúdos serão automaticamente apagados, sem que isto gere para o Usuário o direito de haver do INNBatível indenização ou qualquer outra quantia.</p>
											<p>
												16.5 O INNBatível se responsabiliza em manter a confidencialidade dos arquivos, documentos, e-mails, dados e quaisquer outros tipos de informações que tenham sido armazenados pelo INNBatível em virtude do presente Contrato.</p>
											<p>
												17. Disposições Finais.</p>
											<p>
												17.1 Tolerância. A tolerância de uma parte quanto ao descumprimento de qualquer das obrigações da outra não será considerada novação ou renúncia a qualquer direito, constituindo mera liberalidade, que não prejudicará o posterior exercício de qualquer direito.</p>
											<p>
												17.2 Lei Aplicável. Este Contrato será regido e interpretado de acordo com as leis do Brasil.</p>
											<p>
												17.3 Foro. As partes elegem Foro da Comarca de Florianópolis, Estado de Santa Catarina, para dirimir quaisquer questões oriundas do presente Contrato que não possam ser solucionadas de comum acordo entre as partes, com a exclusão de qualquer outro, por mais privilegiado que seja.</p>
											<p>
												17.4 Cessão. Este Contrato e quaisquer direitos e licenças concedidas aqui, não podem ser transferidos ou cedidos pelo Usuário, mas poderão ser transferidos ou cedidos pelo INNBatível sem qualquer restrição.</p>
											<p>
												17.5 Títulos. As referências a título existentes neste Contrato são feitas para fins de conveniência apenas, e não serão consideradas para limitar ou afetar qualquer das disposições aqui contidas.</p>
											<p>
												17.6 Contrato Integral. Este é o acordo integral entre o Usuário e o INNBatível relacionado ao assunto aqui tratado e não será alterado, salvo consoante o previsto neste próprio Contrato.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn btn-primary"><span class="entypo lock"></span>Finalizar compra segura</button> <img src="https://s3-sa-east-1.amazonaws.com/selo.siteblindado.com/seals_aw/innbativel.com.br/siteblindado_pr.gif" alt="Selo Site Blindado">
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
				<form id="paymentBoletoForm" class="form-horizontal" name="paymentBoletoForm" method="post" action="send_form_contact.php">
					<div class="modal-body">
						<p>
							Digite seus dados de contato abaixo e clique em "Finalizar compra" para gerar o boleto.
						</p>
						<div class="form-group">
							<label class="control-label col-md-3" for="paymentBoletoPhone">Seu telefone</label>
							<div class="col-md-8">
								<input type="text" class="form-control" id="paymentBoletoPhone" name="paymentBoletoPhone" placeholder="Digite seu telefone de contato com DDD"/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-3 col-md-8">
								<button type="submit" class="btn btn-primary">Finalizar compra</button>
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
					<img src="http://innbativel.s3.amazonaws.com/ecoa.jpg">
					<h4 class="modal-title">ECOA - Construindo sustentabilidade e democracia</h4>
				</div>
				<div class="modal-body">
					<p>
						A ECOA foi criada em 1989, em Campo Grande - MS, por um grupo de pesquisadores de diversas áreas profissionais, dentre elas as de biologia, comunicação, arquitetura, ciências sociais, engenharia e educação, para estabelecer um espaço de reflexão, debates e formulações e também desenvolver projetos e políticas públicas para a conservação ambiental e a sustentabilidade tanto no meio urbano quanto no rural. Nesta perspectiva o Pantanal e a bacia hidrográfica do rio da Prata foram identificados como as regiões prioritárias, sendo que no caso Pantanal concentraram-se as ações de base comunitária, o que indica, também, uma das razões para a criação da organização.
					</p>
					<p>
						A Ecoa associa investigação cientifica e ação política no sentido amplo do termo, envolvendo comunidades, instituições de ensino e pesquisa, instituições governamentais e outras organizações não governamentais.  Como ferramentas promovem campanhas e processos de diálogos multisetoriais para criar espaços de reflexão, negociação e decisão frente a questões prioritárias para a conservação ambiental e a sustentabilidade.
					</p>
					<p>
						Uma das principais características da instituição são o permanente suporte para o surgimento e desenvolvimento de redes, fóruns, articulações e organizações locais no Brasil e em outros países.
					</p>
					<p>
						É membro da União Internacional para a Conservação da Natureza (IUCN) e o Ponto Focal do Comitê Holandês da IUCN para a bacia do rio da Prata. É a Secretaria Executiva da Rede Pantanal de Ongs e Movimentos Sociais. É membro da coordenação da Articulação Frente  a Infraestrutura e Energia na América do Sul, da  Aliança Sistema Paraná Paraguai de Áreas Úmidas, da RedeBio e da Rede de Conhecimento sobre Bicombustíveis. Faz parte também do Conselho do Centro de Pesquisas do Pantanal (CPP) e outras redes nacionais e internacionais.
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
					<ul>
						<li>Utilize seu cupom de 20/03/14 a 21/12/14 (exceto P&aacute;scoa), mediante disponibilidade.&nbsp;</li>
						<li>Ao clicar em &ldquo;comprar&rdquo; escolha a op&ccedil;&atilde;o:</li>
					</ul>
					<p><strong>Op&ccedil;&atilde;o 1:</strong> 2 di&aacute;rias durante a semana (exceto feriados prolongados) de R$664 por R$199.</p>
					<p><strong>Op&ccedil;&atilde;o 2:</strong> 2 di&aacute;rias de sexta a domingo (exceto feriados prolongados) de R$664 por R$249.</p>
					<p><strong>Op&ccedil;&atilde;o 3:</strong> 3 di&aacute;rias de sexta a domingo (exceto feriados prolongados) de R$996 por R$359.</p>
					<p><strong>Op&ccedil;&atilde;o 4:</strong> 3 di&aacute;rias no feriado do Dia do Trabalho de R$996 por R$359.</p>
					<p><strong>Op&ccedil;&atilde;o 5:</strong> 3 di&aacute;rias no feriado de Corpus Christi de R$996 por R$359.</p>
					<ul>
						<li>V&aacute;lido exclusivamente para 2 pessoas. Incluso caf&eacute; da manh&atilde;.</li>
						<li>Sem limite de compra. Compre quantos cupons quiser.</li>
						<li><strong>N&atilde;o inclui taxa de servi&ccedil;o</strong><strong>&nbsp;e despesas extras como consumo de frigobar, liga&ccedil;&otilde;es telef&ocirc;nicas, restaurante, </strong><strong>estacionamento</strong><strong> e outros consumos n&atilde;o citados na oferta, a ser pago no </strong><strong>check-out.</strong></li>
						<li>1 crian&ccedil;a com at&eacute; 10 anos possui hospedagem cortesia (no mesmo apartamento dos pais).</li>
						<li>Check-in a partir das 14h e check-out at&eacute; as 12h. Late check-out permitido, mediante disponibilidade e consulta pr&eacute;via.</li>
						<li>Para hospedagem de mais pessoas ou aquisi&ccedil;&atilde;o de di&aacute;ria extra, consulte o hotel.</li>
					</ul>
					<p><span style="text-decoration: underline;">Reservas</span></p>
					<ul>
						<li>Fa&ccedil;a sua reserva atrav&eacute;s do e-mail <a href="mailto:reservas@praiamole.com.br" target="_blank">reservas@praiamole.com.br</a> informando o c&oacute;digo do cupom.</li>
						<li>A confirma&ccedil;&atilde;o da reserva est&aacute; condicionada &agrave; disponibilidade do hotel para a oferta.</li>
						<li>&Eacute; permitido fazer 1 reagendamento com, no m&iacute;nimo, 7 dias de anteced&ecirc;ncia.</li>
						<li>O n&atilde;o comparecimento &agrave; data reservada, sem pr&eacute;vio aviso, invalidar&aacute; o cupom, sem direito a reembolso.</li>
						<li><strong>Para esclarecer d&uacute;vidas ou obter informa&ccedil;&otilde;es ligue: </strong><strong>(48) 3239-7500.</strong></li>
						<li>Todos os servi&ccedil;os de compra coletiva s&atilde;o n&atilde;o reembols&aacute;veis e n&atilde;o reutiliz&aacute;veis em outras datas ou servi&ccedil;os.</li>
					</ul>
					<p><span style="text-decoration: underline;">Cupom</span></p>
					<ul>
						<li><strong>Ap&oacute;s a autoriza&ccedil;&atilde;o do pagamento, o seu cupom estar&aacute; dispon&iacute;vel na sua conta. Para resgat&aacute;-lo basta entrar com seu login e senha cadastrados no site.</strong></li>
						<li>N&atilde;o h&aacute; n&uacute;mero m&iacute;nimo de compradores para a valida&ccedil;&atilde;o desta oferta.</li>
						</ul>
						<p><span style="text-decoration: underline;">Pol&iacute;tica de Cancelamento</span></p>
						<ul>
						<li>Cancelamento GR&Aacute;TIS: Se cancelado com at&eacute; 14 dias ap&oacute;s a compra, n&atilde;o ser&aacute; cobrada qualquer penalidade. Ser&aacute; restitu&iacute;do 100% do valor pago ou transformado em cr&eacute;ditos para uso no INNBat&iacute;vel. Para solicitar o cancelamento, entre em contato com o INNBat&iacute;vel atrav&eacute;s do e-mail <a href="mailto:faleconosco@innbativel.com.br">faleconosco@innbativel.com.br</a>.</li>
						<li>Ap&oacute;s os 14 dias, o cancelamento resultar&aacute; na perda total do cupom (n&atilde;o haver&aacute; reembolso).</li>
					</ul>
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
    @foreach($offer->offer_additional as $k => $additional)
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
@stop
