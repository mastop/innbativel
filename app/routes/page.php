<?php

Route::group(array('before' => 'auth|perm'), function(){
	Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
});

