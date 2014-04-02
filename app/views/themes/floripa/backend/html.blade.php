<!DOCTYPE html>
<html class="{{ $html_classes }}" lang="{{ Config::get('app.locale') }}" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>{{ $page_title }}</title>
	<meta name="author" content="{{ $seo['metatag']['author'] }}">
	<meta name="keywords" content="{{ $seo['metatag']['keywords'] }}">
	<meta name="description" content="{{ $seo['metatag']['description'] }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="alternate" hreflang="{{ Config::get('app.locale') }}" href="{{ URL::current() }}">
	<link rel="canonical" href="{{ URL::current() }}">
	<link rel="icon" type="image/png" href="{{ asset('favicon-32x32.png') }}">
	@stylesheets($type)

	<script>{{ Config::get('app.name') }} = window.{{ Config::get('app.name') }} || {}; {{ Config::get('app.name') }}.basePath = '{{ url() }}';</script>
	@javascripts($type)

</head>
<body class="{{ $body_classes }}">

	<header id="top">
		<div class="fixed">
			<a href="{{ route('home') }}" title="" class="logo"><img src="{{ asset('assets/themes/floripa/backend/img/logo.png') }}" alt="" /></a>
			@include('menu.top')
		</div>
	</header>

	<div id="container">

		@if(Auth::check() && $sidebar)
		<div id="sidebar">
			<div class="sidebar-tabs">
				<ul class="tabs-nav two-items">
					<li><a href="#general" title=""><i class="icon-reorder"></i></a></li>
					<li><a href="#stuff" title=""><i class="icon-cogs"></i></a></li>
				</ul>
				<div id="general">
					@include('menu.admin')
				</div>
				<div id="stuff">
					@include('menu.god')
				</div>
			</div>
		</div>
		@endif

		<main id="content">
			<div class="wrapper">
				<div class="crumbs">
					@include('menu.breadcrumb')
				</div>
				@include('partials.messages')
				<div class="page-header">
					<div class="page-title">
						<h5>{{ $page_title }}</h5>
						<span>{{ $page_description }}</span>
					</div>
				</div>

				@yield('content')

			</div>
		</main>
	</div>
	<footer id="footer">
		<div class="copyrights">© Innbatível.</div>
		<ul class="footer-links">
			<li><a href="" title=""><i class="icon-cogs"></i>Contato</a></li>
		</ul>
	</footer>
</body>
</html>
