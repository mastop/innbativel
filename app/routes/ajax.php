<?php


Route::get('ajax/search/recomendations', ['uses' => 'AjaxController@getSearchRecomendations', 'after' => 'cache.public']);
Route::get('ajax/search/offers.json', ['as' => 'ajax-offers', 'uses' => 'AjaxController@getSearchOffers', 'after' => 'cache.public']);
