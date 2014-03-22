<?php

// Route::group(array('before' => 'auth|perm'), function(){
// 	Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
// });

Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
Route::any('/termos-de-uso', ['as' => 'termos-de-uso', 'uses' => 'PageController@anyTermosDeUso', 'after' => 'cache.public']);
