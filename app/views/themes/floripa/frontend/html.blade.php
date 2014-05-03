<!DOCTYPE html>
<html class="{{ $html_classes }}" lang="{{ Config::get('app.locale') }}" dir="ltr">
<head>
	<meta charset="utf-8" />
	<title>{{ $seo['title'] }}</title>

    @if (App::environment() == 'elastic')
            {{-- Impede que o site seja indexado pelos bots de busca, apenas no ambiente "elastic" --}}
        <meta name="robots" content="noindex">
    @endif

	<meta name="author" content="{{ $seo['metatag']['author'] }}" />
	<meta name="keywords" content="{{ $seo['metatag']['keywords'] }}" />
	<meta name="description" content="{{ $seo['metatag']['description'] }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="alternate" hreflang="{{ Config::get('app.locale') }}" href="{{ URL::current() }}" />
	<link rel="canonical" href="{{ URL::current() }}" />
	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/floripa/frontend/css/bootstrap.css') }}" />
	<script src="{{ asset('assets/vendor/jquery/jquery.latest.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery.migrate/jquery.migrate.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/3/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/themes/floripa/frontend/js/main.js') }}"></script>
    <script src="{{ asset('assets/themes/floripa/frontend/js/form-validation.js') }}"></script>
</head>

<body class="{{ $body_classes }}">

    @include('partials.messages')

    <div id="header-scroll" class="navbar navbar-default navbar-fixed-top out">
        <div class="topbar">
            <div class="container">
                <a href="#contact" data-toggle="modal" title="Entre em contato e tire suas dúvidas">Fale conosco <span class="entypo chat"></span></a>
                @if(Auth::check())
                    <a class="btn-login" href="{{ route('logout') }}" data-toggle="modal" title="Sair de sua conta INNBatível">Sair <span class="entypo logout"></span></a>
                    <a class="btn-login" href="{{ route('painel') }}" title="Acesse sua conta INNBatível">Minha conta <span class="entypo user"></span></a>
                @else
                    <a class="btn-login" href="{{ route('login') }}" data-toggle="modal" title="Entre com sua conta INNBatível">Entrar <span class="entypo login"></span></a>
                    <a href="https://www.facebook.com/dialog/oauth?client_id=145684162279488&amp;redirect_uri=https%3A%2F%2Finnbativel.com.br%2Flogin-facebook-valida.php&amp;state=8bbb0e68cf6d535aac3a58cf2c254be8&amp;scope=email%2C+user_birthday%2C+user_hometown" title="Entre com sua conta do Facebook"><span class="entypo facebook"></span></a>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo" alt="INNbatível" src="{{ asset('assets/images/logo.png') }}">
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navMenuCollapse2">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="clearfix super-search">
                    <form accept-charset="utf-8" class="form-inline" method="GET">
                        <div class="control-group required">
                            <div class="search-controls"><input required="" type="text" name="search" placeholder="Para onde você quer ir?"><a href="#busca" class="btn"><span class="entypo search"></span></a></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="collapse navbar-collapse navMenuCollapse2">
                <ul class="navbar-nav nav">
                    <li>
                        <div class="clearfix super-search">
                            <form accept-charset="utf-8" class="form-inline" method="GET">
                                <div class="control-group required">
                                    <div class="search-controls"><input required="" type="text" name="search" placeholder="Para onde você quer ir?"><a href="busca.html" class="btn"><span class="entypo search"></span></a></div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li><a href="#newsletter" data-toggle="modal">Receba ofertas por <strong>email</strong> <span class="entypo mail"></span></a></li>
                    <li><a href="hoteis-e-pousadas">Hot&eacute;is &amp; Pousadas</a></li>
                    <li><a href="pacotes-nacionais">Pacotes Nacionais</a></li>
                    <li><a href="pacotes-internacionais">Pacotes Internacionais</a></li>
                    <li><a href="feriados" class="single-line"><span>Feriados</span></a></li>
                    <li><a href="passeios-gastronomia">Passeios &amp; Gatronomia</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div id="header" class="navbar navbar-default navbar-fixed-top">
        <div class="topbar">
            <div class="container">
                <a href="#contact" data-toggle="modal" title="Entre em contato e tire suas dúvidas">Fale conosco <span class="entypo chat"></span></a>
                @if(Auth::check())
                <a class="btn-login" href="{{ route('logout') }}" data-toggle="modal" title="Sair de sua conta INNBatível">Sair <span class="entypo logout"></span></a>
                <a class="btn-login" href="{{ route('painel') }}" title="Acesse sua conta INNBatível">Minha conta <span class="entypo user"></span></a>
                @else
                <a class="btn-login" href="{{ route('login') }}" data-toggle="modal" title="Entre com sua conta INNBatível">Entrar <span class="entypo login"></span></a>
                <a href="https://www.facebook.com/dialog/oauth?client_id=145684162279488&amp;redirect_uri=https%3A%2F%2Finnbativel.com.br%2Flogin-facebook-valida.php&amp;state=8bbb0e68cf6d535aac3a58cf2c254be8&amp;scope=email%2C+user_birthday%2C+user_hometown" title="Entre com sua conta do Facebook"><span class="entypo facebook"></span></a>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo" alt="INNbatível" src="{{ asset('assets/images/logo.png') }}">
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navMenuCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="btn-newsletter">
                    <a href="#newsletter" data-toggle="modal">Receba ofertas por <strong>Email</strong> <span class="entypo mail"></span></a>
                </div>
                <div class="clearfix super-search">
                    <form accept-charset="utf-8" class="form-inline" method="GET">
                        <div class="control-group required">
                            <div class="search-controls"><input required="" type="text" name="search" placeholder="Para onde você quer ir?"><a href="busca.html" class="btn"><span class="entypo search"></span></a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

	<nav id="nav">
		<div class="container">
			<nav class="navbar-default navbar" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navMenuCollapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse navMenuCollapse">
                        @include('menu.main')
					</div>
				</div>
			</nav>
		</div>
	</nav>

	<div id="main" class="container">
		@yield('content')
	</div>

	<div id="pre-footer" class="clearfix">
		<div class="container">
			<div id="widget-selos">
				<h4><span class="entypo lock"></span>Compre com Segurança</h4>
				<div id="selo-bandeiras">
					<figure><img src="{{ asset('assets/images/bandeiras.png') }}" alt="Bandeiras de Cartão de Crédito" width="212" height="83"></figure>
				</div>
				<div id="selo-ebit">
					<figure>
						<a id="seloEbit" href="http://www.ebit.com.br/#innbativel" target="_blank" onclick="redir(this.href);">Avaliação de Lojas e-bit</a>
						<script type="text/javascript" id="getSelo" src="https://558701205.r.anankecdn.com.br/ebitBR/static/getSelo.js?40747" >
						</script>
					</figure>
				</div>
				<div id="selo-siteblindado">
					<a href="https://selo.siteblindado.com.br/verificar?url=innbativel.com.br" title="Visualizou o selo Site Blindado? Navegue tranquilamente, esse site está BLINDADO CONTRA ATAQUES. Realizamos milhares de testes simulando ataques de hacker, para garantir a segurança do site. Clique no selo e confira o certificado."><img src="https://s3-sa-east-1.amazonaws.com/selo.siteblindado.com/seals_aw/innbativel.com.br/siteblindado_pr.gif" alt="Selo Site Blindado"></a>
					<param id="aw_nav_post" value="1">
					<script type="text/javascript" src="//selo.siteblindado.com/aw.js"></script>
				</div>
				<div id="selo-embratur">
					<figure>
						<img src="{{ asset('assets/images/embratur.png') }}" alt="Embratur" width="140" height="19">
					</figure>
				</div>
				<div id="selo-site-sustentavel">
					<a href="http://www.sitesustentavel.com.br/certificado/list?url=innbativel.com.br" title="Site Sustentável" target="_blank">
						<img src="{{ asset('assets/images/site-sustentavel.png') }}" alt="Site Sustentável" width="142" height="40">
					</a>
				</div>
			</div>

			<div id="widget-facebook">
				<h4>INNBatível no Facebook</h4>
				<div class="fb-like-box" data-href="http://www.facebook.com/innbativel" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false" width="292"></div>

				<div id="fb-root"></div>
				<script>
					(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>

			</div>
			<div id="widget-twitter">
				<h4>Twitter do INNBatível</h4>
				<a class="twitter-timeline" width="300" height="230" href="https://twitter.com/INNBativel" data-widget-id="279588524427190272">Tweets de @INNBativel</a>

				<script>
					try {!function(d,s,id){
						var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
						if(!d.getElementById(id)){js=d.createElement(s);
							js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js,fjs);
						}
					}(document,"script","twitter-wjs");} catch(e){}
				</script>

			</div>
		</div>
	</div>


    @include('partials.parceiro')
    @include('partials.conte-pra-gente')
    @include('partials.trabalhe-conosco')
    @include('partials.quem-somos')
    @include('partials.acao-social')
    @include('partials.termos')
    @include('partials.politica')
    @include('partials.sugira')
    @include('partials.contato')
    @include('partials.login')
    @include('partials.pass-recover')
    @include('partials.newsletter')

    <footer id="footer" class="clearfix">
        <div class="container">
            <div id="menu-footer">
                <ul id="menu-viaje">
                    <li><strong>Viaje</strong></li>
                    <li><a href="hoteis-e-pousadas">Hot&eacute;is &amp; Pousadas</a></li>
                    <li><a href="pacotes-nacionais">Pacotes Nacionais</a></li>
                    <li><a href="pacotes-internacionais">Pacotes Internacionais</a></li>
                    <li><a href="feriados">Feriados</a></li>
                    <li><a href="passeios-gastronomia">Passeios &amp; Gatronomia</a></li>
                </ul>
                <ul id="menu-participe">
                    <li><strong>Participe</strong></li>
                    <li><a href="#parceiro" data-toggle="modal">Seja Nosso Parceiro</a></li>
                    <li><a href="#sugira" data-toggle="modal">Sugira uma Viagem</a></li>
                    <li><a href="#conte-pra-gente" data-toggle="modal">Conte pra Gente</a></li>
                    <!-- <li><a href="#">Indique e Ganhe</a></li> -->
                </ul>
                <ul id="menu-institucional">
                    <li><strong>Institucional</strong></li>
                    <!-- <li><a href="#faq" data-toggle="modal">Ajuda</a></li> -->
                    <li><a href="#contact" data-toggle="modal">Fale Conosco</a></li>
                    <li><a href="#quem-somos" data-toggle="modal">Quem Somos</a></li>
                    <li><a href="#acao-social" data-toggle="modal">Ação Social</a></li>
                    <li><a href="#trabalhe-conosco" data-toggle="modal">Trabalhe Conosco</a></li>
                    <li><a href="#">Imprensa</a></li>
                    <li><a href="#termos" data-toggle="modal">Termos e Condições de Uso</a></li>
                    <li><a href="#politica" data-toggle="modal">Política de Privacidade</a></li>
                </ul>
            </div>
            <div id="copyright-and-legal">
                <p>ASN Serviços de Informações Digitais na Web LTDA., CNPJ n° 12.784.420/0001-95, Rod. Armando Calil Bulos, nº 5405, Florianópolis – SC</p>
            </div>
        </div>
    </footer>
</body>
</html>