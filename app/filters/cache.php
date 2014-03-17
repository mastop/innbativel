<?php

/*
|--------------------------------------------------------------------------
| Cache Filters
|--------------------------------------------------------------------------
|
*/

Route::filter('cache.public', function($route, $request, $response)
{
  // if (Request::getMethod() == 'GET')
  // {
  //   $date = new DateTime();
  //   $response->setPublic();
  //   $response->setMaxAge(0);
  //   $response->setSharedMaxAge(0);
  //   $response->setExpires($date);
  //   $response->headers->addCacheControlDirective('must-revalidate', true);
  //   $response->headers->addCacheControlDirective('no-store', true);
  //   $response->headers->set('X-INNbativel', 'true');
  // }
});

Route::filter('cache.rebuild', function($route, $request, $response)
{

  /*
   * Set default Headers to GET Request
   */
  // if (Request::getMethod() == 'GET')
  // {
  //   $date = new DateTime();
  //   $response->setPrivate();
  //   $response->setMaxAge(0);
  //   $response->setSharedMaxAge(0);
  //   $response->setExpires($date);
  //   $response->headers->addCacheControlDirective('must-revalidate', false);
  //   $response->headers->addCacheControlDirective('no-store', true);
  // }

});
