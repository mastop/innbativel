<?php


Route::get('ajax/search/recomendations', ['uses' => 'AjaxController@getSearchRecomendations', 'after' => 'cache.public']);
Route::get('ajax/search/offers.json', ['as' => 'ajax-offers', 'uses' => 'AjaxController@getSearchOffers', 'after' => 'cache.public']);
Route::get('ajax/search/offer.json', ['as' => 'ajax-offer', 'uses' => 'AjaxController@getSearchOffer', 'after' => 'cache.public']);
