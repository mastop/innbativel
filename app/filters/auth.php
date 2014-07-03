<?php

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
  if (Auth::guest())
  {
    $destination = Input::get('destination', Request::getPathInfo());

	  Session::flash('warning', 'Você precisa logar no site para acessar esta página.');

    if ($destination !== '/')
    {
      Session::put('destination', $destination);
      return Redirect::route('home', array('destination' => $destination));
    }

    Session::forget('destination');
    return Redirect::route('home', array('destination' => '/'));
  }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
  if (Auth::check())
  {
    $destination = Session::get($destination);

    if (is_null($destination)) {
    	$destination = route('home');
    }

    return $destination;
  }
});

/*
|--------------------------------------------------------------------------
| Permission Filter
|--------------------------------------------------------------------------
*/

Route::filter('perm', function()
{
	$perm = Route::currentRouteName();

	if (Auth::check() && !Auth::user()->can($perm))
	{
        return Response::view('error.403', [], 403);
	}
});
