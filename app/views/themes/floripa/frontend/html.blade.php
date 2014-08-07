<!DOCTYPE html>
<html class="{{ isset($html_classes) ? $html_classes : '' }}" lang="{{ Config::get('app.locale') }}" dir="ltr">
<head>

	<meta charset="utf-8" />
	<title>{{ isset($title) ? $title : $seo['metatag']['title'] }}</title>

    <meta name="title" content="{{ isset($title) ? $title : $seo['metatag']['title'] }}" />
    <meta name="description" content="{{ isset($description) ? $description : $seo['metatag']['description'] }}" />
	<meta name="author" content="{{ $seo['metatag']['author'] }}" />
	<meta name="keywords" content="{{ $seo['metatag']['keywords'] }}" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta property="og:title" content="{{ isset($title) ? $title: $seo['metatag']['title'] }}" />
    <meta property="og:description" content="{{ isset($description) ? $description : $seo['metatag']['description'] }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ isset($image) ? $image : $seo['metatag']['image'] }}" />
    <meta property="fb:app_id" content="{{ Configuration::get('fb_app') }}" />
    @foreach(explode(',', Configuration::get('fb_admins')) as $adm)
        <meta property="fb:admins" content="{{ $adm }}"/>
    @endforeach
    <meta property="og:type" content="{{ isset($og_type) ? $og_type : 'website' }}" />
    <meta property="og:locale" content="pt_BR" />

	
    <link rel="alternate" hreflang="{{ Config::get('app.locale') }}" href="{{ URL::current() }}" />
	<link rel="canonical" href="{{ URL::current() }}" />
	<link rel="icon" type="image/png" href="{{ asset_timed('favicon.png') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset_timed('assets/themes/floripa/frontend/css/bootstrap.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset_timed('assets/vendor/fotorama/fotorama.css') }}" />
    @yield('css')
	
    <script src="{{ asset_timed('assets/vendor/jquery/jquery.latest.min.js') }}"></script>
	<script src="{{ asset_timed('assets/vendor/jquery.migrate/jquery.migrate.min.js') }}"></script>
	<script src="{{ asset_timed('assets/vendor/bootstrap/3/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset_timed('assets/vendor/jquery.validation/jquery.validate.min.js') }}"></script>
	<script src="{{ asset_timed('assets/themes/floripa/frontend/js/main.js') }}"></script>
    <script src="{{ asset_timed('assets/themes/floripa/frontend/js/form-validation.js') }}"></script>
    <script src="{{ asset_timed('assets/vendor/jquery.bullseye/jquery.bullseye-1.0-min.js') }}"></script>
    <script src="{{ asset_timed('assets/vendor/contador/contador.js') }}"></script>
    <script src="{{ asset_timed('assets/vendor/fotorama/fotorama.js') }}"></script>
    @yield('javascript')
    {{ Configuration::get('script_head') }}
</head>

<body class="innbativel frontend no-sidebar {{ isset($body_classes) ? $body_classes : '' }}">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-P8KJDZ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P8KJDZ');</script>
<!-- End Google Tag Manager -->

    <div id="header" class="navbar navbar-default navbar-fixed-top {{ (isset($comprar)) ? ' border-bottom' : '' }}">
        <div class="topbar">
            <div class="container">
                <a href="#contact" data-toggle="modal" title="Entre em contato e tire suas dúvidas">Fale conosco <span class="entypo chat"></span></a>
                @if(Auth::check())
                <a class="btn-login" href="{{ route('minha-conta') }}" title="Acesse sua conta INNBatível">Minha conta <span class="entypo user"></span></a>
                <a class="btn-login" href="{{ route('logout') }}" data-toggle="modal" title="Sair de sua conta INNBatível">Sair <span class="entypo logout"></span></a>
                    @if(Auth::user()->is(['administrador', 'comercial', 'programador', 'gerente', 'Marketing', 'atendimento', 'jornalista', 'designer']))
                        <a class="btn-login" href="{{ route('admin') }}" title="Acesse a Administração">Admin <span class="entypo key"></span></a>
                    @elseif(Auth::user()->is('parceiro'))
                        <a class="btn-login" href="{{ route('painel') }}" title="Acesse o Painel do Parceiro">Painel do Parceiro <span class="entypo key"></span></a>
                    @endif
                @else
                <a class="btn-login" href="#login" data-toggle="modal" title="Entre com sua conta INNBatível">Entrar <span class="entypo login"></span></a>
                <a href="{{ route('facebook', array('destination' => e(Input::get('destination', Request::getPathInfo())))) }}" title="Entre com sua conta do Facebook" class="btn-login login"><span class="entypo facebook"></span></a>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo" alt="INNbatível" src="//{{Configuration::get("s3url")}}/logo.png">
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
                            <div class="search-controls"><input required="" type="text" name="q" placeholder="Para onde você quer ir?" value="{{{Input::get('q')}}}"><button class="btn"><span class="entypo search"></span></button></div>
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
                    @if(Auth::user()->is(['administrador', 'comercial', 'programador', 'gerente', 'Marketing', 'atendimento', 'jornalista', 'designer']))
                        <a class="btn-login" href="{{ route('admin') }}" title="Acesse a Administração">Admin <span class="entypo key"></span></a>
                    @elseif(Auth::user()->is('parceiro'))
                        <a class="btn-login" href="{{ route('painel') }}" title="Acesse o Painel do Parceiro">Painel do Parceiro <span class="entypo key"></span></a>
                    @endif
                @else
                    <a class="btn-login" href="#login" data-toggle="modal" title="Entre com sua conta INNBatível">Entrar <span class="entypo login"></span></a>
                    <a href="https://www.facebook.com/dialog/oauth?client_id=145684162279488&amp;redirect_uri=https%3A%2F%2Finnbativel.com.br%2Flogin-facebook-valida.php&amp;state=8bbb0e68cf6d535aac3a58cf2c254be8&amp;scope=email%2C+user_birthday%2C+user_hometown" title="Entre com sua conta do Facebook"><span class="entypo facebook"></span></a>
                @endif
            </div>
        </div>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="logo" alt="INNbatível" src="//{{Configuration::get("s3url")}}/logo.png">
                </a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navMenuCollapse2">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="clearfix super-search">
                    <form accept-charset="utf-8" class="form-inline" method="GET" action="{{ route('busca') }}">
                        <div class="control-group required">
                            <div class="search-controls"><input required="" type="text" name="q" placeholder="Para onde você quer ir?" value="{{{Input::get('q')}}}"><button class="btn"><span class="entypo search"></span></button></div>
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
                                    <div class="search-controls"><input required="" type="text" name="q" placeholder="Para onde você quer ir?" value="{{{Input::get('q')}}}"><a href="busca.html" class="btn"><span class="entypo search"></span></a></div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li><a href="#newsletter" data-toggle="modal">Receba ofertas por <strong>email</strong> <span class="entypo mail"></span></a></li>
                    <li><a href="{{url('hoteis-e-pousadas')}}">Hot&eacute;is &amp; Pousadas</a></li>
                    <li><a href="{{url('pacotes-nacionais')}}">Pacotes Nacionais</a></li>
                    <li><a href="{{url('pacotes-internacionais')}}">Pacotes Internacionais</a></li>
                    <li><a href="{{url('feriados')}}" class="single-line"><span>Feriados</span></a></li>
                    <li><a href="{{-- url('passeios-gastronomia') --}}#">Passeios &amp; Gatronomia <span class="badge" style="background-color: #999;">Breve</span></a></li>
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
    @include('partials.messages')
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
                @include('menu.footer')
            @endif
            <div id="copyright-and-legal">
                <p>ASN Serviços de Informações Digitais na Web LTDA., CNPJ n° 12.784.420/0001-95, Rod. Armando Calil Bulos, nº 5405, Florianópolis – SC</p>
            </div>
        </div>
    </footer>
    {{ Configuration::get('script_body') }}
@if(($message = Session::get('error', Session::get('warning'))) || count($errors) > 0)
<div id="modal-error" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm text-center">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title">Atenção</h4><br/>
                <p>
                    @if($message)
                    {{$message}}
                    @else
                    Existem erros de preenchimento. Verifique o formulário e envie novamente.
                    @endif
                </p><br/>
                <button type="submit" class="btn" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#modal-error').modal('show');
</script>
@endif
@if(Input::get('open', Input::old('modal')))
<script>
    $("#{{{Input::get('open', Input::old('modal'))}}}").modal('show');
</script>
@endif
</body>
</html>