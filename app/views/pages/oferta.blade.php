@section('javascript')
	<script src="{{ asset('assets/themes/floripa/frontend/js/oferta.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container offer-page">
		
		<div class="row">
			<div class="col-8 col-sm-8 col-lg-8">
				<h2>Feriado em Florianópolis</h2>
				<h4>Páscoa ou Dia do Trabalho para curtir a Ilha da Magia</h4>
				<p class="subsubtitle">Passagens Aéreas + Hotel + Transfer Hotel / Aeroporto / Hotel saindo de SP, RJ, BH e Brasília</p>

				<div class="social-share">
					<div class="fb-like" data-href="https://innbativel.com.br" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
					
					<div class="fb-share-button" data-href="https://innbativel.com.br/oferta/santo-amaro-da-imperatriz---sc-963" data-type="button_count"></div>

					<!-- <a target="_blank" href="http://www.facebook.com/share.php?t=AVENTURE-SE! RAPEL DE CACHOEIRA NO RIO FORQUILHAS E ARVORISMO EM SANTO AMARO DA IMPERATRIZ A PARTIR DE R$30!&u=https://innbativel.com.br/oferta/santo-amaro-da-imperatriz---sc-963" title="Compartilhe no Facebook"><span class="entypo c-facebook"></span></a> -->
					
					<a target="_blank" href="http://twitter.com/home?status=AVENTURE-SE! RAPEL DE CACHOEIRA NO RIO FORQUILHAS E ARVORISMO EM SANTO AMARO DA IMPERATRIZ A PARTIR DE R$30! -> https://innbativel.com.br/oferta/santo-amaro-da-imperatriz---sc-963" title="Compartilhe no Twitter"><span class="entypo c-twitter"></span></a>
					
					<!-- <a target="_blank" href="https://plus.google.com/share?url=https://innbativel.com.br/oferta/santo-amaro-da-imperatriz---sc-963" title="Compartilhe no Google+"><span class="entypo c-google"></span></a> -->
					
					<a href="#emailShare" title="Compartilhe por Email" data-toggle="modal"><div class="circle"><span class="entypo mail"></span></div></a>
				</div>

			</div>

			<div class="col-4 col-sm-4 col-lg-4">
				<div class="price-header">
					A partir de<br/>
					<span>R$ <strong>299</strong></span>
					<p>54% OFF</p>
				</div>
			</div>
		</div>
		
		<!-- <div id="emailShare" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Compartilhe com seus amigos</h4>
					</div>
					<form id="emailShareForm" class="form-horizontal" name="commentform" method="post" action="send_form_email.php">
						<div class="modal-body">
							<p>
								Preencha os campos abaixo para compartilhar esta oferta.
							</p>
							<div class="form-group">
								<label class="control-label col-md-4" for="senderName">Seu nome</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="senderName" name="senderName" placeholder="Seu nome" data-validation="length" data-validation-length="min4"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4" for="senderEmail">Seu email</label>
								<div class="col-md-6 input-group">
									<span class="input-group-addon">@</span>
									<input type="email" class="form-control" id="senderEmail" name="senderEmail" placeholder="Seu email" data-validation="email"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4" for="receiverName">Nome do seu amigo</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="receiverName" name="receiverName" placeholder="Nome do seu amigo" data-validation="length" data-validation-length="min4"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-4" for="receiverEmail">Email do seu amigo</label>
								<div class="col-md-6 input-group">
									<span class="input-group-addon">@</span>
									<input type="email" class="form-control" id="receiverEmail" name="receiverEmail" placeholder="Email do seu amigo" data-validation="email"/>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" data-dismiss-="modal">Compartilhar</button>
						</div>
					</form>
				</div>
			</div> -->
		
		<div class="row buy-box-bottom">
			<form class="buy-form" method="post" action="{{ route('comprar') }}">

				<div itemscope class="col-8 col-sm-8 col-lg-8 clearfix buy-box-top">
					
					<!-- <div class="offer-label"><span class="entypo clock"></span>Período Limitado</div> -->
					<div class="offer-label"><span class="entypo calendar"></span>Viaje na Páscoa ou no Dia do Trabalho</div>
					<div id="fotorama" class="fotorama" data-width="100%" data-ratio="600/250" data-nav="thumbs" data-thumbwidth="90" data-thumbheight="50" data-loop="true" data-autoplay="3000" data-transition="slide" data-arrows="true" data-click="false" data-swipe="true">
						<a href="assets/uploads/oferta-home-destaque.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-destaque.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home.jpg">
							<figure>
								<img src="assets/uploads/oferta-home.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home-pn-02.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-pn-02.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home-pg-01.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-pg-01.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home.jpg">
							<figure>
								<img src="assets/uploads/oferta-home.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home-pn-02.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-pn-02.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home-pg-01.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-pg-01.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home.jpg">
							<figure>
								<img src="assets/uploads/oferta-home.jpg">
							</figure>
						</a>
						<a href="assets/uploads/oferta-home-pn-02.jpg">
							<figure>
								<img src="assets/uploads/oferta-home-pn-02.jpg">
							</figure>
						</a>
						<a href="https://www.youtube.com/watch?v=TtUadO4MODY">Título do video</a>
					</div>
					
					<div class="offer-description">
						<p>
							Conhecida por ser o ponto de encontro da juventude da ilha, a Praia Mole, que leva esse nome devido &agrave; areia solta e macia, &eacute; altamente frequentada por surfistas e praticantes de parapente. Os pais devem ficar atentos com as fortes ondas e com a profundidade que aumenta ap&oacute;s poucos passos em dire&ccedil;&atilde;o ao mar. &Agrave; beira mar, a praia &eacute; rodeada por barzinhos.
						</p>
						<ul class="offer-inclusive">
							<li>Economize at&eacute; R$637 em at&eacute; 3 di&aacute;rias no <a href="#map" class="tooltip" data-tip="Veja a localização" data-toggle="modal">Praia Mole Eco Village</a>, localizado em ponto privilegiado da ilha, entre a Praia Mole e a Lagoa da Concei&ccedil;&atilde;o.</li>
							<li>Utilize no fim de semana ou durante a semana, escolha!</li>
							<li>V&aacute;lido para os feriados do Dia do Trabalho e Corpus Christi.</li>
							<li>Para uma hospedagem confort&aacute;vel, o hotel disp&otilde;e de caf&eacute; da manh&atilde;, piscina, bar na piscina, quadra de t&ecirc;nis e campo de futebol.</li>
							<li>Confira o <a href="#regulation" class="tooltip" data-tip="Veja o Regulamento da Oferta" data-toggle="modal">Regulamento da Oferta</a></li>
							<li>Tem alguma d&uacute;vida? <a href="#contact" class="tooltip" data-tip="Entre em contato" data-toggle="modal">Fale conosco</a></li>
							<li>Escolha entre as opções abaixo antes de comprar, e selecione as quantidades na página de pagamento.</li>
						</ul>
					</div>
					
					<ul class="buy-itens buy-options">
						<h3>Opções da oferta <span class="glyphicon glyphicon-chevron-down"></span></h3>
						<li>
							<label>
								<input type="checkbox" id="opt1" name="opt" value="299">
								<div>
									<small>Opção 1</small>
									<span>2 diárias de maio a dezembro</span>
									<div>R$<strong>299</strong></div>
								</div>
								<div class="percent-off"><span><strong>50</strong>OFF</span></div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="opt2" name="opt" value="349">
								<div>
									<small>Opção 2</small>
									<span>3 diárias de maio a dezembro</span>
									<div>R$<strong>349</strong></div>
								</div>
								<div class="percent-off"><span><strong>52</strong>OFF</span></div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="opt3" name="opt" value="369">
								<div>
									<small>Opção 3</small>
									<span>2 diárias de julho a janeiro</span>
									<div>R$<strong>369</strong></div>
								</div>
								<div class="percent-off"><span><strong>55</strong>OFF</span></div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="opt4" name="opt" value="399">
								<div>
									<small>Opção 4</small>
									<span>3 diárias de agosto a fevereiro</span>
									<div>R$<strong>399</strong></div>
								</div>
								<div class="percent-off"><span><strong>53</strong>OFF</span></div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="opt5" name="opt" value="418">
								<div>
									<small>Opção 5</small>
									<span>3 diárias de maio a dezembro</span>
									<div>R$<strong>418</strong></div>
								</div>
								<div class="percent-off"><span><strong>57</strong>OFF</span></div>
							</label>
						</li>
					</ul>

					<ul class="buy-itens buy-combo">
						<h3>Inclua também <span class="glyphicon glyphicon-chevron-down"></span></h3>
						<li>
							<label>
								<input type="checkbox" id="combo1" name="opt" value="41.90">
								<figure><img src="assets/uploads/camarao.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo1-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Sequência de Camarão para 2 Pessoas</a>
									<div class="price">R$<strong>41</strong></div>
								</div>
								<div class="more-info"><a href="#combo1-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>50</strong>OFF</span></div>
							</label>
							<div id="combo1-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>50</strong>OFF</div>
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
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$83,80</span></div>
													<div class="price price-discount">Por R$<strong>41,90</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo2" name="opt" value="79.99">
								<figure><img src="assets/uploads/camarao.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo2-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Sequência de Camarão para 4 Pessoas</a>
									<div class="price">R$<strong>79</strong></div>
								</div>
								<div class="more-info"><a href="#combo2-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>52</strong>OFF</span></div>
							</label>
							<div id="combo2-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 52%"><strong>52</strong>OFF</div>
											<img src="assets/uploads/camarao.jpg">
											<h4 class="modal-title">Sequência de Camarão para 4 Pessoas</h4>
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
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$166,65</span></div>
													<div class="price price-discount">Por R$<strong>79,99</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo3" name="opt" value="29">
								<figure><img src="assets/uploads/oferta-home-pg-01.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo3-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Tirolesa em Florianópolis</a>
									<div class="price">R$<strong>29</strong></div>
								</div>
								<div class="more-info"><a href="#combo3-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>50</strong>OFF</span></div>
							</label>
							<div id="combo3-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>50</strong>OFF</div>
											<img src="assets/uploads/oferta-home-pg-01.jpg">
											<h4 class="modal-title">Tirolesa em Florianópolis</h4>
										</div>
										<div class="modal-body">
											<p>
												Tirolesa com vista panorâmica para a Praia Mole a partir de R$29! Ingresso para até 2 saltos + foto + vídeo. Na compra de pacote com 2 saltos você poderá levar um acompanhante.
											</p>
											<p>
												Única Tirolesa com acesso à rampa de salto com elevador. Sala de recepção com ambiente climatizado para seu maior conforto.
											</p>
											<p>
												Aventure-se com segurança, equipamentos adequados e guias qualificados e experientes. Menores de idade deverão estar acompanhados pelo responsável ou com autorização dos mesmos.
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$60</span></div>
													<div class="price price-discount">Por R$<strong>29</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo4" name="opt" value="15">
								<figure><img src="assets/uploads/logo-snowland.png"></figure>
								<div class="offer-combo">
									<a href="#combo4-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Ingresso Snowland<span class="entypo chevron-right"></span>Adulto</a>
									<div class="price">R$<strong>59</strong></div>
								</div>
								<div class="more-info"><a href="#combo4-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off off"><!-- <span><strong>75</strong>OFF</span> --></div>
							</label>
							<div id="combo4-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<img src="assets/uploads/logo-snowland.png">
											<h4 class="modal-title">Ingresso Snowland<span class="entypo chevron-right"></span>Adulto</h4>
										</div>
										<div class="modal-body">
											<p>
												Ingressos adulto para o Snowland Parque de Neve, em Gramado. Inclui acesso com tempo ilimitado à montanha de neve (ski, snowboard, airboarding e mais) + aluguel de roupa de neve + patinação no gelo.
											</p>
											<p>
												Ski, Snowboard, Airboard, Snowplay, Tubing, Mecatrônicos, Escola de neve, Pista de Patinação, Hot Café, Área de alimentação e diversas lojas no vilarejo alpino e muito mais!
											</p>
											<p>
												Acesso ao Vilarejo para o dia todo; 01 Aluguel de Roupas de Neve para 1 Pessoa (calça, jaqueta, capacete); 01 Par de Luvas; 01 Aluguel de Bota de Neve; 01 Acesso a montanha de neve, sem limite de tempo, incluindo as atrações: Snowplay; Tubing (acima de 7 anos); Airboarding (acima dos 10 anos); Glacial; SnowArena; 01 Bônus do Snowland e do INNBatível: 30 minutos de Patinação no gelo (para maiores de 6 anos).
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-discount">Por R$<strong>59</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo5" name="opt" value="10">
								<figure><img src="assets/uploads/logo-snowland.png"></figure>
								<div class="offer-combo">
									<a href="#combo5-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Ingresso Snowland<span class="entypo chevron-right"></span>Criança</a>
									<div class="price">R$<strong>44</strong></div>
								</div>
								<div class="more-info"><a href="#combo5-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off off"><!-- <span><strong>75</strong>OFF</span> --></div>
							</label>
							<div id="combo5-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>75</strong>OFF</div>
											<img src="assets/uploads/logo-snowland.png">
											<h4 class="modal-title">Ingresso Snowland<span class="entypo chevron-right"></span>Criança</h4>
										</div>
										<div class="modal-body">
											<p>
												Ingressos criança para o Snowland Parque de Neve, em Gramado. Inclui acesso com tempo ilimitado à montanha de neve (ski, snowboard, airboarding e mais) + aluguel de roupa de neve + patinação no gelo.
											</p>
											<p>
												Ski, Snowboard, Airboard, Snowplay, Tubing, Mecatrônicos, Escola de neve, Pista de Patinação, Hot Café, Área de alimentação e diversas lojas no vilarejo alpino e muito mais!
											</p>
											<p>
												Acesso ao Vilarejo para o dia todo; 01 Aluguel de Roupas de Neve para 1 Pessoa (calça, jaqueta, capacete); 01 Par de Luvas; 01 Aluguel de Bota de Neve; 01 Acesso a montanha de neve, sem limite de tempo, incluindo as atrações: Snowplay; Tubing (acima de 7 anos); Airboarding (acima dos 10 anos); Glacial; SnowArena; 01 Bônus do Snowland e do INNBatível: 30 minutos de Patinação no gelo (para maiores de 6 anos).
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$174</span></div>
													<div class="price price-discount">Por R$<strong>44</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo6" name="opt" value="35">
								<figure><img src="assets/uploads/arvorismo.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo6-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Arvorismo em Santo Amaro<span class="entypo chevron-right"></span>Adulto</a>
									<div class="price">R$<strong>35</strong></div>
								</div>
								<div class="more-info"><a href="#combo6-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>50</strong>OFF</span></div>
							</label>
							<div id="combo6-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>50</strong>OFF</div>
											<img src="assets/uploads/arvorismo.jpg">
											<h4 class="modal-title">Arvorismo em Santo Amaro<span class="entypo chevron-right"></span>Adulto</h4>
										</div>
										<div class="modal-body">
											<p>
												Em Santo Amaro, adultos e crianças podem aproveitar o arvorismo. O percurso para adultos tem 550m de extensão (4 tirolesas), 25 atividades. A seção de treinamento tem aproximadamente 2h.
											</p>
											<p>
												Inclui equipamentos de segurança e condutores especializados.
											</p>
											<p>
												Idade mínina para a prática é 12 anos. Menores de idade deverão estar acompanhados pelo responsável ou com autorização dos mesmos. Não se esqueça do protetor solar e repelente, use roupa leve e tênis para a caminhada.
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$60</span></div>
													<div class="price price-discount">Por R$<strong>35</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo7" name="opt" value="30">
								<figure><img src="assets/uploads/arvorismo.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo7-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Arvorismo em Santo Amaro<span class="entypo chevron-right"></span>Criança (3 a 6 anos)</a>
									<div class="price">R$<strong>30</strong></div>
								</div>
								<div class="more-info"><a href="#combo7-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>50</strong>OFF</span></div>
							</label>
							<div id="combo7-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>50</strong>OFF</div>
											<img src="assets/uploads/arvorismo.jpg">
											<h4 class="modal-title">Arvorismo em Santo Amaro<span class="entypo chevron-right"></span>Criança (3 a 6 anos)</h4>
										</div>
										<div class="modal-body">
											<p>
												O Arvorismo Kids é ideal para crianças de 3 a 6 anos. O percurso conta com 180m de extensão (1 tirolesa), 8 obstáculos e carga máxima para 14 pessoas. A atividade tem duração de aproximadamente 1h.
											</p>
											<p>
												Inclui equipamentos de segurança e condutores especializados.
											</p>
											<p>
												Idade mínina para a prática é 12 anos. Menores de idade deverão estar acompanhados pelo responsável ou com autorização dos mesmos. Não se esqueça do protetor solar e repelente, use roupa leve e tênis para a caminhada.
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$60</span></div>
													<div class="price price-discount">Por R$<strong>30</strong></div>
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
						</li>
						<li>
							<label>
								<input type="checkbox" id="combo8" name="opt" value="59">
								<figure><img src="assets/uploads/rapel.jpg"></figure>
								<div class="offer-combo">
									<a href="#combo8-info" class="tooltip" data-tip="Veja mais informações" data-toggle="modal">Rapel de Cachoeira em Santo Amaro</a>
									<div class="price">R$<strong>59</strong></div>
								</div>
								<div class="more-info"><a href="#combo8-info" class="tooltip" data-tip="Veja mais informações"  data-toggle="modal">veja<strong>&plus;</strong></a></div>
								<div class="percent-off"><span><strong>69</strong>OFF</span></div>
							</label>
							<div id="combo8-info" class="modal fade" tabindex="-1">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
											<div class="percent-off tooltip" data-tip="Economize 50%"><strong>69</strong>OFF</div>
											<img src="assets/uploads/rapel.jpg">
											<h4 class="modal-title">Rapel de Cachoeira em Santo Amaro</h4>
										</div>
										<div class="modal-body">
											<p>
												O Rapel de Cachoeira do Rio Forquilhas, localizado no município de Águas Mornas, é ideal para iniciantes. São 15km de base e 35m de altura. A atividade tem duração de aproximadamente 2h, dependendo do tamanho do grupo.
											</p>
											<p>
												Idade mínina para a prática é 12 anos. Menores de idade deverão estar acompanhados pelo responsável ou com autorização dos mesmos.
											</p>
											<p>
												Inclui equipamentos de segurança e condutores especializados.
											</p>
											<p>Escolha a quantidade na página de pagamento.</p>
											<div class="prices-info">
												<div class="prices clearfix">
													<div class="price price-original">De <span>R$129</span></div>
													<div class="price price-discount">Por R$<strong>59</strong></div>
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
						</li>
					</ul>

				</div>
		
				<div class="col-4 col-sm-4 col-lg-4 buy-box-container">
					<div id="buy-box">
						<div id="total-price" class="hidden">Total R$ <strong></strong></div>
						<div id="buy-alert" class="hidden"><span class="entypo chevron-left"></span>Escolha suas opções</div>
						<div class="tooltip" data-tip="Escolha suas opções antes de comprar">
							<button id="buy-btn" class="btn disabled">Comprar</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}"/>
							<!-- <input id="buy-btn" class="btn disabled" type="submit" value="Comprar"> -->
						</div>
						<div class="offer-time">
							Oferta por tempo limitado!
							<div>
								<span class="entypo clock"></span>
								 <ul id="contador">
									<li>00h</li>
									<li>00m</li>
									<li>00s</li>
								</ul>
							</div>
						</div>
						<div class="offer-remain">12 cupons vendidos</div>
						<!-- <div class="offer-remain">Restam 12</div> -->
					</div>
				</div>
			</form>
		</div>

		<div class="row">
			<div class="col-8 col-sm-8 col-lg-8">
				
				<h3>Comentários</h3>
				<div class="fb-comments" data-href="http://innbativel.com.br" data-numposts="5" data-colorscheme="light"></div>

			</div>

			<a href="#contact" id="help" data-toggle="modal">
				<span>Tem alguma dúvida?</span>
				<span class="entypo chat"></span> <strong>Fale agora conosco</strong><br/>
				estamos aqui para ajudá-lo
			</a>

		</div>
	</div>

	<div id="map" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3 class="modal-title"><span class="entypo location"></span>Localização</h3>
				</div>
				<div class="modal-body">
					<img src="http://maps.googleapis.com/maps/api/staticmap?center=-27.602602,+-48.435569&zoom=16&scale=1&size=480x250&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C-27.602602,+-48.435569" title="Praia Mole Eco Village Jornalista Manoel de Menezes, 2001, Praia Mole Florianópolis - SC 88061-700">
					<div class="logo-partner text-center">
						<img src="assets/uploads/logo-hotel.jpg" alt="Logo da Praia Mole Eco Village em parceiria com a INNBatível">
						<span>
							<a href="http://www.praiamole.com.br" target="_blank">www.praiamole.com.br</a>
						</span>
					</div>
					<address>
						<span class="entypo location"></span>Rodovia Jornalista Manoel de Menezes, 2001, Praia Mole, Florianópolis - SC<br /><span class="entypo phone icon-flipped"></span> (48) 3239 7500
					</address>
				</div>
				<!-- <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Não concordo</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">Concordo</button>
				</div> -->
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
					<!-- <button type="button" class="btn btn-primary" data-dismiss="modal"><span class="entypo check"></span>Concordo</button> -->
				</div>
			</div>
		</div>
	</div>

	<div id="emailShare" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo mail"></span>Compartilhe com seus amigos</h4>
				</div>
				<form id="emailShareForm" class="form-horizontal" name="emailShareForm" method="post" action="send_form_emailShare.php">
					<div class="modal-body">
						<p>
							Preencha os campos abaixo para compartilhar esta oferta.
						</p>
						<div class="form-group">
							<label class="control-label col-md-4" for="senderName">Seu nome</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="senderName" name="senderName" placeholder="Seu nome"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="senderEmail">Seu email</label>
							<div class="col-md-6 input-group">
								<input type="email" class="form-control" id="senderEmail" name="senderEmail" placeholder="Seu email"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="receiverName">Nome d@ amig@</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="receiverName" name="receiverName" placeholder="Nome do(a) amigo(a)"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-4" for="receiverEmail">Email d@ amig@</label>
							<div class="col-md-6 input-group">
								<input type="email" class="form-control" id="receiverEmail" name="receiverEmail" placeholder="Email do(a) amigo(a)"/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Compartilhar</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="emailShareResponse" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-sm modal-stylized">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><span class="entypo check"></span>Oferta compartilhada</h4>
				</div>
				<div class="modal-body">
					<p>
						<strong>Obrigado por compartilhar!</strong>
					</p>
					<p>
						Agora seus amigos também poderão aproveitar esta oferta.
					</p>
				</div>
			</div>
		</div>
	</div>
@stop
