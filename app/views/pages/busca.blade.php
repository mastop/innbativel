@section('javascript')
	<script src="{{ asset('assets/vendor/modernizr/modernizr.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery.shuffle/jquery.shuffle.min.js') }}"></script>
	<script src="{{ asset('assets/themes/floripa/frontend/js/busca.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container search-page">
		
		<div class="row">

			<div class="col-12 col-sm-12 col-lg-12">
				<!-- <h2>Resultados de busca por Florianópolis</h2> -->
				<h2>Busca de ofertas</h2>
				<p class="subsubtitle">Utilize os filtros abaixo e encontre a melhor oferta para você</p>
			</div>

		</div>
		
		
		<div class="row">
			<form class="buy-form">

				<div itemscope class="col-4 col-sm-4 col-lg-4 clearfix">
					
					<h3>Filtrar por</h3>

					<ul class="search-filters links">
						<h4>Tipo</h4>
						<li>
							<a href="hoteis-pousadas.html">Hotéis &amp; Pousadas</a>
						</li>
						<li>
							<a href="pacotes-nacionais.html">Pacotes Nacionais</a>
						</li>
						<li>
							<a href="pacotes-internacionais.html">Pacotes Internacionais</a>
						</li>
						<li>
							<a href="passeios-gastronomia.html">Passeios &amp; Gastronomia</a>
						</li>
					</ul>

					<div class="form-group price-range">
						<h4>Preço</h4>
						<div>
							<label>De <input type="number" class="form-control" id="min-price" name="min-price" min="1" max="4999" step="9" placeholder="R$" /></label>
							<label>até <input type="number" class="form-control" id="max-price" name="max-price" min="2" max="5000" step="9" placeholder="R$" /></label>
						</div>
					</div>
					
					<ul id="destinies" class="search-filters">
						<h4>Destinos</h4>
						<li>
							<label>
								<input type="checkbox" id="destinies-all" name="destinies-all" value="all">
								<div>Todos</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-01" name="destinies-01" value="santiago-ch">
								<div>Santiago - CH</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-02" name="destinies-02" value="buenosaires-ar">
								<div>Buenos Aires - AR</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-03" name="destinies-03" value="urubici-sc">
								<div>Urubici - SC</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-04" name="destinies-04" value="rosa-sc">
								<div>Praia do Rosa - SC</div>
							</label>
						</li>
					</ul>

					<ul id="holidays" class="search-filters">
						<h4>Feriados</h4>
						<!-- <li>
							<label>
								<input type="checkbox" id="feriados-all" name="feriados-all" value="all">
								<div>Todos</div>
							</label>
						</li> -->
						<li>
							<label>
								<input type="checkbox" id="holidays-opt1" name="holidays-opt1" value="pascoa">
								<div>Páscoa</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="holidays-opt2" name="holidays-opt2" value="1maio">
								<div>1º de Maio</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="holidays-opt3" name="holidays-opt3" value="maes">
								<div>Dia das Mães</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="holidays-opt4" name="holidays-opt4" value="natal">
								<div>Natal</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="holidays-opt5" name="holidays-opt5" value="reveillon">
								<div>Réveillon</div>
							</label>
						</li>
					</ul>

					<!-- <ul class="search-filters">
						<h4>Tipos de destino</h4>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-all" name="destinies-type-all" value="all">
								<div>Todos</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-1" name="destinies-type-1" value="litoral">
								<div>Litoral</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-2" name="destinies-type-2" value="serra">
								<div>Serra</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-3" name="destinies-type-3" value="termas">
								<div>Termas</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-4" name="destinies-type-4" value="eco">
								<div>Ecológico</div>
							</label>
						</li>
					</ul> -->

					<ul id="dates" class="search-filters">
						<h4>Datas</h4>
						<li>
							<label>
								<input type="checkbox" id="dates-all" name="dates-all" value="all">
								<div>Qualquer data</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-1" name="dates-1" value="042014">
								<div>Abr / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-2" name="dates-2" value="052014">
								<div>Mai / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-3" name="dates-3" value="062014">
								<div>Jun / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-4" name="dates-4" value="072014">
								<div>Jul / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-5" name="dates-5" value="082014">
								<div>Ago / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-6" name="dates-6" value="092014">
								<div>Set / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-7" name="dates-7" value="102014">
								<div>Out / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-8" name="dates-8" value="112014">
								<div>Nov / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-9" name="dates-9" value="122014">
								<div>Dez / 2014</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-10" name="dates-10" value="012015">
								<div>Jan / 2015</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="dates-11" name="dates-11" value="022015">
								<div>Fev / 2015</div>
							</label>
						</li>
					</ul>

				</div>
		
				<div class="col-8 col-sm-8 col-lg-8">
					<h3>Resultados</h3>
					<label class="sorter">
						Ordenar por: 
						<select id="sort" name="sort">
							<option value="spotlight">Maior Destaque</option>
							<option value="price">Menor Preço</option>
							<option value="discount">Maior Desconto</option>
						</select>
					</label>

					<div id="sortable">

						<div itemscope class="offer-grid-item clearfix" data-spotlight="1" data-price="399" data-discount="50" data-destinies="urubici-sc" data-holidays='["natal","maes"]' data-dates='["042014"]'>
							<a href="oferta.html" class="offer-grid-inner clearfix">
								<div class="offer-label"><span class="entypo new"></span>Novidade</div>
								<!-- <div class="offer-label"><span class="entypo clock"></span>Oferta Relâmpago</div> -->
								<figure>
									<img src="assets/uploads/oferta-home-hp-02.jpg" alt="descrição curta da oferta (mesmo texto do data-tip do header)">
								</figure>
								<header class="tooltip" data-tip="Garanta já dias apaixonados na Serra Catarinense! Urubici lhe aguarda com paisagens de tirar o fôlego, e muitos vinhos para degustar! Válido também em Julho!">
									<h2 itemprop="name">Urubici - SC</h2>
								</header>
								<div class="content clearfix">
									<div class="info row" itemscope itemprop="offers">
										<div class="col-lg-2 tooltip" data-tip="Pacote para duas pessoas"><span class="entypo users"></span>2 Pessoas</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui hospedagem"><span class="entypo adjust"></span>2 Diárias</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui café da manhã"><span class="glyphicon glyphicon-cutlery"></span>Café da manhã</div>
									</div>
									<div class="options clearfix">
										<div class="prices clearfix">
											<div class="price price-original">De <span>R$700</span></div>
											<div class="price price-discount">Por R$<strong>399</strong></div>
										</div>
										<div class="percent-off tooltip" data-tip="Economize 50%"><strong>50</strong>OFF</div>
										<div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
										<div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
									</div>
								</div>
							</a>
						</div>

						<div itemscope class="offer-grid-item clearfix" data-spotlight="1" data-price="299" data-discount="0" data-destinies="rosa-sc" data-holidays='["maes","pascoa"]'>
							<a href="oferta.html" class="offer-grid-inner clearfix">
								<div class="offer-label"><span class="entypo thumbs-up"></span>Recomendado</div>
								<figure>
									<img src="assets/uploads/oferta-home-hp-01.jpg" alt="descrição curta da oferta (mesmo texto do data-tip do header)">
								</figure>
								<header class="tooltip" data-tip="Dias de sossego na maravilhosa Praia do Rosa!">
									<h2 itemprop="name">Praia do Rosa - SC</h2>
								</header>
								<div class="content clearfix">
									<div class="info row" itemscope itemprop="offers">
										<div class="col-lg-2 tooltip" data-tip="Pacote para duas pessoas"><span class="entypo users"></span>2 Pessoas</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui hospedagem"><span class="entypo adjust"></span>3 Diárias</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui café da manhã"><span class="glyphicon glyphicon-cutlery"></span>Café da manhã</div>
									</div>
									<div class="options clearfix">
										<div class="prices clearfix">
											<div class="price price-original">A partir de</div>
											<div class="price price-discount">R$<strong>299</strong></div>
										</div>
										<!-- <div class="percent-off tooltip" data-tip="Economize 53%"><strong>53</strong>OFF</div> -->
										<div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
										<div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
									</div>
								</div>
							</a>
						</div>

						<div itemscope class="offer-grid-item clearfix" data-spotlight="3" data-price="1099" data-discount="60" data-destinies="santiago-ch" data-holidays='["pascoa","maes"]'>
							<a href="oferta.html" class="offer-grid-inner clearfix">
								<div class="offer-label"><span class="entypo calendar"></span>Viaje na Páscoa</div>
								<div class="offer-label"><span class="entypo calendar"></span>Destaque 1</div>
								<figure>
									<img src="assets/uploads/oferta-home-pi-01.jpg" alt="descrição curta da oferta (mesmo texto do data-tip do header)">
								</figure>
								<header class="tooltip" data-tip="Compre sua viagem de férias e garanta momentos inesquecíveis em Santiago. Aproveite!">
									<h2 itemprop="name">Santiago do Chile</h2>
								</header>
								<div class="content clearfix">
									<div class="info row" itemscope itemprop="offers">
										<div class="col-lg-2 tooltip" data-tip="Inclui passagens aéreas"><span class="entypo airplane"></span>Aéreo</div>
										<div class="col-lg-2 tooltip" data-tip="Pacote individual para uma pessoa"><span class="entypo user"></span>1 Pessoa</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui hospedagem"><span class="entypo adjust"></span>3 Diárias</div>
									</div>
									<div class="options clearfix">
										<div class="prices clearfix">
											<div class="price price-original">De <span>R$2498</span></div>
											<div class="price price-discount">Por R$<strong>1099</strong></div>
										</div>
										<div class="percent-off tooltip" data-tip="Economize 60%"><strong>60</strong>OFF</div>
										<div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
										<div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
									</div>
								</div>
							</a>
						</div>

						<div itemscope class="offer-grid-item clearfix" data-spotlight="3" data-price="999" data-discount="60" data-destinies="santiago-ch" data-holidays="natal">
							<a href="oferta.html" class="offer-grid-inner clearfix">
								<div class="offer-label"><span class="entypo calendar"></span>Viaje no Natal</div>
								<div class="offer-label"><span class="entypo calendar"></span>Destaque 1</div>
								<figure>
									<img src="assets/uploads/oferta-home-pi-01.jpg" alt="descrição curta da oferta (mesmo texto do data-tip do header)">
								</figure>
								<header class="tooltip" data-tip="Compre sua viagem de férias e garanta momentos inesquecíveis em Santiago. Aproveite!">
									<h2 itemprop="name">Santiago do Chile</h2>
								</header>
								<div class="content clearfix">
									<div class="info row" itemscope itemprop="offers">
										<div class="col-lg-2 tooltip" data-tip="Inclui passagens aéreas"><span class="entypo airplane"></span>Aéreo</div>
										<div class="col-lg-2 tooltip" data-tip="Pacote individual para uma pessoa"><span class="entypo user"></span>1 Pessoa</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui hospedagem"><span class="entypo adjust"></span>3 Diárias</div>
									</div>
									<div class="options clearfix">
										<div class="prices clearfix">
											<div class="price price-original">De <span>R$2498</span></div>
											<div class="price price-discount">Por R$<strong>999</strong></div>
										</div>
										<div class="percent-off tooltip" data-tip="Economize 60%"><strong>60</strong>OFF</div>
										<div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
										<div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
									</div>
								</div>
							</a>
						</div>

						<div itemscope class="offer-grid-item clearfix" data-spotlight="2" data-price="1099" data-discount="61" data-destinies="buenosaires-ar" data-holidays="pascoa">
							<a href="oferta.html" class="offer-grid-inner clearfix">
								<div class="offer-label"><span class="entypo calendar"></span>Viaje na Páscoa</div>
								<div class="offer-label"><span class="entypo calendar"></span>Destaque 2</div>
								<figure>
									<img src="assets/uploads/oferta-home-pi-02.jpg" alt="descrição curta da oferta (mesmo texto do data-tip do header)">
								</figure>
								<header class="tooltip" data-tip="Aproveite o feriadão de Páscoa e Tiradentes para curtir o melhor da Argentina!">
									<h2 itemprop="name">Buenos Aires - Argentina</h2>
								</header>
								<div class="content clearfix">
									<div class="info row" itemscope itemprop="offers">
										<div class="col-lg-2 tooltip" data-tip="Inclui passagens aéreas"><span class="entypo airplane"></span>Aéreo</div>
										<div class="col-lg-2 tooltip" data-tip="Pacote individual para uma pessoa"><span class="entypo user"></span>1 Pessoa</div>
										<div class="col-lg-2 tooltip" data-tip="Inclui hospedagem"><span class="entypo adjust"></span>5 Diárias</div>
									</div>
									<div class="options clearfix">
										<div class="prices clearfix">
											<div class="price price-original">De <span>R$2798</span></div>
											<div class="price price-discount">Por R$<strong>1099</strong></div>
										</div>
										<div class="percent-off tooltip" data-tip="Economize 61%"><strong>61</strong>OFF</div>
										<div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
										<div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
									</div>
								</div>
							</a>
						</div>

					</div>

				</div>
			</form>
		</div>
	</div>
@stop
