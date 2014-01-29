<?php


Route::get('ajax/search/recomendations', ['uses' => 'AjaxController@getSearchRecomendations', 'after' => 'cache.public']);
