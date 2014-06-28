<?php

// Grupo de Routes que usam SSL

Route::group(array('https'), function()
{
Route::get('ajax/search/recomendations', ['uses' => 'AjaxController@getSearchRecomendations', 'after' => 'cache.public']);
Route::get('ajax/myaccount', ['as' => 'ajax-myaccount', 'uses' => 'AjaxController@postMyAccount', 'after' => 'cache.public']);
Route::get('ajax/search/offers.json', ['as' => 'ajax-offers', 'uses' => 'AjaxController@getSearchOffers', 'after' => 'cache.public']);
Route::get('ajax/search/offer.json', ['as' => 'ajax-offer', 'uses' => 'AjaxController@getSearchOffer', 'after' => 'cache.public']);
Route::get('ajax/search/offers-groups.json', ['as' => 'ajax-offers-groups', 'uses' => 'AjaxController@getSearchOffersGroups', 'after' => 'cache.public']);
Route::get('ajax/search/offer-groups.json', ['as' => 'ajax-offer-groups', 'uses' => 'AjaxController@getSearchOfferGroups', 'after' => 'cache.public']);
});