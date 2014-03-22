<?php

// Route::group(array('before' => 'auth|perm'), function(){
// 	Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
// });

Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
Route::any('/termos-de-uso', ['as' => 'termos-de-uso', 'uses' => 'PageController@anyTermosDeUso', 'after' => 'cache.public']);
Route::any('/politica-de-privacidade', ['as' => 'politica-de-privacidade', 'uses' => 'PageController@anyPoliticaDePrivacidade', 'after' => 'cache.public']);
Route::any('/quem-somos', ['as' => 'quem-somos', 'uses' => 'PageController@anyQuemSomos', 'after' => 'cache.public']);
Route::any('/acao-social', ['as' => 'acao-social', 'uses' => 'PageController@anyAcaoSocial', 'after' => 'cache.public']);
