<?php

/*
|
| Auth
|
*/

Route::get  ('entrar',  ['as' => 'login',      'uses' => 'AuthController@getLogin',  'after' => 'cache.public']);
Route::post ('entrar',  ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
Route::get  ('sair', 	  ['as' => 'logout',     'uses' => 'AuthController@getLogout']);

Route::get  ('criar/conta',             ['as' => 'account.get',       'uses' => 'AuthController@getCreate',         'after' => 'cache.public']);
Route::post ('criar/conta',             ['as' => 'account.create',    'uses' => 'AuthController@postCreate']);

Route::get  ('recuperar/senha', 		    ['as' => 'password.remind',  	'uses' => 'AuthController@getRemind',         'after' => 'cache.public']);
Route::post ('recuperar/senha', 		    ['as' => 'password.request', 	'uses' => 'AuthController@postRequest']);
Route::get  ('recuperar/senha/{token}', ['as' => 'password.reset',   	'uses' => 'AuthController@getReset',          'after' => 'cache.public']);
Route::post ('recuperar/senha/{token}', ['as' => 'password.update',  	'uses' => 'AuthController@postUpdate']);

Route::get  ('entrar/facebook', 		    ['as' => 'login.facebook',      'uses' => 'AuthController@getFacebook',     'after' => 'cache.rebuild']);
Route::get  ('entrar/facebook/ajax',    ['as' => 'login.facebook.ajax', 'uses' => 'AuthController@getFacebookAjax', 'after' => 'cache.rebuild']);
