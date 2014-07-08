<?php

Route::filter('csrf', function()
{
	$token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');

	if(Request::url() != route('snowland-valida-cupom') && Request::url() != route('snowland-utiliza-cupom') && Request::url() != route('braspag_retorno.php')) {
		if (Session::token() != $token)
		{
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
});

Route::filter('ajax',  function($route, $request)
{
  if (!$request->ajax()) {
    return App::abort(404);
  }
});
