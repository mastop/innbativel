<?php

Route::filter('csrf', function()
{
	$token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

	if(Request::url() != route('snowland-valida-cupom') && Request::url() != route('snowland-utiliza-cupom') && Request::url() != route('braspag_retorno')) {
		if (Session::token() != $token)
		{
            $message = 'Token inválido!';
            Logs::debug($message." -> Token Session: ".Session::token()." -> Token User: ".e($token));
            return Redirect::route('home')->with('error', $message);
		}
	}
});

Route::filter('ajax',  function($route, $request)
{
  if (!$request->ajax()) {
    return App::abort(404);
  }
});
