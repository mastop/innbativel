<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    // Get default PHP locale
    $phpLocale = Config::get('app.phplocale');

    // Set Locale
    setlocale(LC_ALL, $phpLocale);

    // Set TimeZone
	date_default_timezone_set('America/Sao_Paulo');
    // Para funcionar na Amazon
    $request->setTrustedProxies(array($request->server->get('REMOTE_ADDR')));
    $request->setTrustedHeaderName(\Symfony\Component\HttpFoundation\Request::HEADER_CLIENT_IP, 'X-Forwarded-For');
    $request->setTrustedHeaderName(\Symfony\Component\HttpFoundation\Request::HEADER_CLIENT_PROTO, 'X-Forwarded-Proto');
});

// App::after(function($request, $response){});
