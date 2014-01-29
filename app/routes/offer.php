<?php

Route::group(array('before' => 'auth|perm'), function(){
	Route::any('oferta/{slug}', ['as' => 'offer', 'uses' => 'OfferController@anyOffer', 'after' => 'cache.public']);
});
