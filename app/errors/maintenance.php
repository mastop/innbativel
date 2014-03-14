<?php

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

// App::error(function(\Illuminate\Session\TokenMismatchException $exception)
// {
//     return Redirect::route('login')->with('message','Your session has expired. Please try logging in again.');
// });

App::error(function(Exception $exception, $code)
{

  Log::error($exception);

  if (Config::getEnvironment() == 'production' ||
	  Config::getEnvironment() == 'staging' ||
	  Config::getEnvironment() == 'local')
  {
	  $data = [
		'exception' => $exception
	  ];

	  // Mail::send('emails.error.log', $data, function($message)
	  // {
		 //  $message
			// ->to(['programacao@innbativel.com.br'])
			// // ->replyTo('faleconosco@innbativel.com.br', 'INNBatível')
			// ->subject('Erro no Site Innbatível');
	  // });

	  // print('<pre>');
	  // print_r($exception);
	  // print('</pre>'); die();
  }

  switch ($code) {
	case 403:
	case 404:
	case 405:
	case 500:
	case 503:
	  return Response::view('error.'.$code, [], $code);
	  break;
	break;
	default:
	  return Response::view('error.500', [], $code);
	break;
  }

});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Not Found
|--------------------------------------------------------------------------
*/

App::missing(function($exception)
{
  return Response::view('error.404', [], 404);
});
