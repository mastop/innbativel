<!DOCTYPE html>
<html class="{{ $html_classes }}" lang="{{ Config::get('app.locale') }}" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>{{ $seo['title'] }}</title>
	<meta name="author" content="{{ $seo['metatag']['author'] }}">
	<meta name="keywords" content="{{ $seo['metatag']['keywords'] }}">
	<meta name="description" content="{{ $seo['metatag']['description'] }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="alternate" hreflang="{{ Config::get('app.locale') }}" href="{{ URL::current() }}">
	<link rel="canonical" href="{{ URL::current() }}">
	<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
	@stylesheets($type)

	<script>{{ Config::get('app.sysname') }} = window.{{ Config::get('app.sysname') }} || {}; {{ Config::get('app.sysname') }}.basePath = '{{ url() }}'; {{ Config::get('app.sysname') }}.userAuth = @if(Auth::check()) 'true' @else 'false' @endif;</script>
	@javascripts($type)

</head>
<body class="{{ $body_classes }}">
	<div id="header" class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="home" class="navbar-brand" href="{{ route('home') }}">
					<img id="logo" alt="INNbatível" src="{{ asset('assets/images/logo.png') }}">
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					@if(Auth::check())
					<li><a href="{{ route('home') }}">Minha Conta</a></li>
					<li><a href="{{ route('logout') }}">Sair</a></li>
					@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Acessar <b class="caret"></b></a>
						<div id="login-dropdown" class="dropdown-menu">
							@include('forms.login')
						</div>
					</li>
					<li><a href="{{ route('account.get') }}">Cadastre-se</a></li>
					@endif
					<li><a href="#">Cadastre-se em nossa Newsletter</a></li>
				</ul>
			</div>
		</div>
	</div>
	<nav id="nav">
	    <div class="container">
	    	@include('menu.main')
	    </div>
	</nav>
	<div id="main" class="container">
		@include('forms.super-search')
		@yield('content')
	</div>
	<footer id="footer" class="clearfix">
		<div class="container">
			<ul id="menu-institucional">
				<li><strong>Institucional</strong></li>
				<li><a href="">Fale Conosco</a></li>
				<li><a href="">Quem Somos</a></li>
				<li><a href="">Ação Social</a></li>
				<li><a href="">Trabalhe Conosco</a></li>
				<li><a href="">Imprensa</a></li>
				<li><a href="">Termos e Condições de Uso</a></li>
				<li><a href="">Política de Privacidade</a></li>
			</ul>
			<ul id="menu-participe">
				<li><strong>Participe</strong></li>
				<li><a href="">Seja Nosso Parceiro</a></li>
				<li><a href="">Sugira uma Viagem</a></li>
				<li><a href="">Conte pra Gente</a></li>
				<li><a href="">Indique e Ganhe</a></li>
			</ul>
			<ul id="menu-viaje">
				<li><strong>Viaje</strong></li>
				<li><a href="">Hoteis</a></li>
				<li><a href="">Pacotes Internacionais</a></li>
				<li><a href="">Pacotes Nacionais</a></li>
				<li><a href="">Passeios e Gastronomia</a></li>
			</ul>
			<div id="widget-facebook">
				<div class="fb-follow" data-href="https://www.facebook.com/innbativel" data-width="285" data-colorscheme="light" data-layout="standard" data-show-faces="true"></div>
			</div>
			<div id="widget-twitter">
              <a class="twitter-timeline" width="285" height="270" href="https://twitter.com/INNBativel" data-widget-id="332136990269120512">Tweets by @INNBativel</a>
			</div>
			<div id="widget-selos">
				<ul id="menu-selos">
		            <li id="selo-embratur">
		            	<figure>
		            		<img src="{{ asset('assets/images/embratur.png') }}" alt="Logomarca da Embratur" width="170" height="68">
		            	</figure></li>
		            <li id="selo-bandeiras">
		            	<figure><img src="{{ asset('assets/images/bandeiras.jpg') }}" alt="Logomarca da Embratur" width="402" height="46"></figure>
		            </li>
		        	<li id="selo-ebit">
		        		<figure>
		        			<a id="seloEbit" href="http://www.ebit.com.br/innbativel/selo" target="_blank" title="Avaliado pelos consumidores">
		        				<img src="https://a248.e.akamai.net/f/248/52872/0s/img.ebit.com.br/ebitBR/selo/img_40747.png">
		        			</a>
		        			<script type="text/javascript" id="getSelo" src="https://558701205.r.anankecdn.com.br/ebitBR/static/getSelo.js?40747"></script>
		        		</figure>
		        	</li>
		            <li id="selo-siteblindado">
		            	<figure>
		                    <a rel="canonical" href="https://selo.siteblindado.com.br/verificar?url=innbativel.com.br" title="Visualizou o selo Site Blindado? Navegue tranquilamente, esse site esta BLINDADO CONTRA ATAQUES. Realizamos milhares de testes simulando ataques de hacker, para garantir a segurança do site. Clique no selo e confira o certificado."><img src="https://s3-sa-east-1.amazonaws.com/selo.siteblindado.com/seals_aw/innbativel.com.br/siteblindado_pr.gif"></a>
		                    <param id="aw_nav_post" value="1">
		                    <script type="text/javascript" src="//selo.siteblindado.com/aw.js"></script>
		                </figure>
		            </li>

		        </ul>
			</div>
			<div id="copyright-and-legal">
				<p>ASN Serviços de Informações Digitais na Web LTDA., CNPJ n° 12.784.420/0001-95, Rod. Armando Calil Bulos, nº 5405, Florianópolis – SC</p>
			</div>
		</div>
	</footer>
	<!--div id="fb-root"></div>
	<script>
	  window.fbAsyncInit = function() {
	    FB.init({
	      appId: '{{ Config::get('facebook.appId') }}',
	      status: true,
	      xfbml: true
	    });
	  };
	  (function(){
	     if (document.getElementById('facebook-jssdk')) {return;}
	     var firstScriptElement = document.getElementsByTagName('script')[0];
	     var facebookJS = document.createElement('script');
	     facebookJS.id = 'facebook-jssdk';
	     facebookJS.src = '//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=145684162279488';
	     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
	   }());
	</script>
	<script>
		try {!function(d,s,id){
			var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
			if(!d.getElementById(id)){js=d.createElement(s);
				js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js,fjs);
			}
		}(document,"script","twitter-wjs");} catch(e){}
	</script-->
</body>
</html>
