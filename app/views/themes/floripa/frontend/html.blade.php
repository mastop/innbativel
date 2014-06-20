<!DOCTYPE html>
<html class="{{ $html_classes }}" lang="{{ Config::get('app.locale') }}" dir="ltr">
<head>

	<meta charset="utf-8" />
	<title>{{ $title }}</title>

    @if (App::environment() == 'elastic')
            {{-- Impede que o site seja indexado pelos bots de busca, apenas no ambiente "elastic" --}}
        <meta name="robots" content="noindex">
    @endif

    <meta name="title" content="{{ isset($title) ? $title : $seo['metatag']['title'] }}" />
    <meta name="description" content="{{ isset($description) ? $description : $seo['metatag']['description'] }}" />
	<meta name="author" content="{{ $seo['metatag']['author'] }}" />
	<meta name="keywords" content="{{ $seo['metatag']['keywords'] }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta property="og:title" content="{{ isset($title) ? $title : $seo['metatag']['title'] }}" />
    <meta property="og:description" content="{{ isset($description) ? $description : $seo['metatag']['description'] }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ isset($image) ? $image : $seo['metatag']['image'] }}" />
	
    <link rel="alternate" hreflang="{{ Config::get('app.locale') }}" href="{{ URL::current() }}" />
	<link rel="canonical" href="{{ URL::current() }}" />
	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/themes/floripa/frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fotorama/fotorama.css') }}" />
    @yield('css')
	
    <script src="{{ asset('assets/vendor/jquery/jquery.latest.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/jquery.migrate/jquery.migrate.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/3/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.validation/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('assets/themes/floripa/frontend/js/main.js') }}"></script>
    <script src="{{ asset('assets/themes/floripa/frontend/js/form-validation.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.bullseye/jquery.bullseye-1.0-min.js') }}"></script>
    <script src="{{ asset('assets/vendor/contador/contador.js') }}"></script>
    <script src="{{ asset('assets/vendor/fotorama/fotorama.js') }}"></script>
    @yield('javascript')
</head>

<body class="{{ $body_classes }}">

    @include('partials.messages')

    <div id="header" class="navbar navbar-default navbar-fixed-top {{ (isset($comprar)) ? ' border-bottom' : '' }}">
        <div class="topbar">
            <div class="container">
                <a href="#contact" data-toggle="modal" title="Entre em contato e tire suas dúvidas">Fale conosco <span class="entypo chat"></span></a>
                @if(Auth::check())
                <a class="btn-login" href="{{ route('minha-conta') }}" title="Acesse sua conta INNBatível">Minha conta <span class="entypo user"></span></a>
                <a class="btn-login" href="{{ route('logout') }}" data-toggle="modal" title="Sair de sua conta INNBatível">Sair <span class="entypo logout"></span></a>
                @else
                <a class="btn-login" href="#login" data-toggle="modal" title="Entre com sua conta INNBatível">Entrar <span class="entypo login"></span></a>
                <a href="https://www.facebook.com/dialog/oauth?client_id=145684162279488&amp;redirect_uri=https%3A%2F%2Finnbativel.com.br%2Flogin-facebook-valida.php&amp;state=8bbb0e68cf6d535aac3a58cf2c254be8&amp;scope=email%2C+user_birthday%2C+user_hometown" title="Entre com sua conta do Facebook" class="btn-login login"><span class="entypo facebook"></span></a>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo" alt="INNbatível" src="{{ asset('assets/images/logo.png') }}">
                </a>
                @if(!isset($comprar))
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navMenuCollapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="btn-newsletter">
                    <a href="#newsletter" data-toggle="modal">Receba ofertas por <strong>Email</strong> <span class="entypo mail"></span></a>
                </div>
                <div class="clearfix super-search">
                    <form accept-charset="utf-8" class="form-inline" method="GET" action="{{ route('busca') }}">
                        <div class="control-group required">
                            <div class="search-controls"><input required="" type="text" name="search" placeholder="Para onde você quer ir?"><button class="btn"><span class="entypo search"></span></button></div>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    @if(!isset($comprar))
    <div id="header-scroll" class="navbar navbar-default navbar-fixed-top out">
        <div class="topbar">
            <div class="container">
                <a href="#contact" data-toggle="modal" title="Entre em contato e tire suas dúvidas">Fale conosco <span class="entypo chat"></span></a>
                @if(Auth::check())
                    <a class="btn-login" href="{{ route('logout') }}" data-toggle="modal" title="Sair de sua conta INNBatível">Sair <span class="entypo logout"></span></a>
                    <a class="btn-login" href="{{ route('minha-conta') }}" title="Acesse sua conta INNBatível">Minha conta <span class="entypo user"></span></a>
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
                    <form accept-charset="utf-8" class="form-inline" method="GET" action="{{ route('busca') }}">
                        <div class="control-group required">
                            <div class="search-controls"><input required="" type="text" name="search" placeholder="Para onde você quer ir?"><button class="btn"><span class="entypo search"></span></button></div>
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

	<nav id="nav">
		<div class="container">
			<nav class="collapse navbar-collapse navMenuCollapse" role="navigation">
                @include('menu.main')
			</nav>
		</div>
	</nav>
    @endif

	@yield('content')

	<div id="pre-footer" class="clearfix">
		<div class="container">
            @if(!isset($comprar))
                @include('partials.widget.selos')
                @include('partials.widget.facebook')
                @include('partials.widget.twitter')
            @else
                @include('partials.widget.selos-comprar')
            @endif
		</div>
	</div>

    @include('partials.modal.press')
    @include('partials.modal.faq')
    @include('partials.modal.parceiro')
    @include('partials.modal.conte-pra-gente')
    @include('partials.modal.trabalhe-conosco')
    @include('partials.modal.quem-somos')
    @include('partials.modal.acao-social')
    @include('partials.modal.termos')
    @include('partials.modal.politica')
    @include('partials.modal.sugira')
    @include('partials.modal.contato')
    @include('partials.modal.login')
    @include('partials.modal.pass-recover')
    @include('partials.modal.register')
    @include('partials.modal.newsletter')

    <footer id="footer" class="clearfix">
        <div class="container">
            @if(!isset($comprar))
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
                    <li><a href="#faq" data-toggle="modal">Perguntas Frequentes</a></li>
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
                    <li><a href="#press" data-toggle="modal">Imprensa</a></li>
                    <li><a href="#termos" data-toggle="modal">Termos e Condições de Uso</a></li>
                    <li><a href="#politica" data-toggle="modal">Política de Privacidade</a></li>
                </ul>
            </div>
            @endif
            <div id="copyright-and-legal">
                <p>ASN Serviços de Informações Digitais na Web LTDA., CNPJ n° 12.784.420/0001-95, Rod. Armando Calil Bulos, nº 5405, Florianópolis – SC</p>
            </div>
        </div>
    </footer>
</body>
</html>