<?php

// Route::group(array('before' => 'auth|perm'), function(){
// 	Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
// });

Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
Route::any('/oferta/{slug}', ['as' => 'oferta', 'uses' => 'PageController@anyOferta', 'after' => 'cache.public']);
Route::any('/comprar', ['as' => 'comprar', 'uses' => 'PageController@anyComprar', 'after' => 'cache.public', 'https']);
Route::post('/cupom', ['as' => 'valida-cupom', 'uses' => 'PageController@postValidateCoupon', 'after' => 'cache.public']);
Route::any('/sucesso/{status}/{boletus_url?}', ['as' => 'sucesso', 'uses' => 'PageController@anySucesso', 'after' => 'cache.public']);
Route::any('/busca', ['as' => 'busca', 'uses' => 'PageController@anyBusca', 'after' => 'cache.public']);
Route::any('/termos-de-uso', ['as' => 'termos-de-uso', 'uses' => 'PageController@anyTermosDeUso', 'after' => 'cache.public']);
Route::any('/politica-de-privacidade', ['as' => 'politica-de-privacidade', 'uses' => 'PageController@anyPoliticaDePrivacidade', 'after' => 'cache.public']);
Route::any('/quem-somos', ['as' => 'quem-somos', 'uses' => 'PageController@anyQuemSomos', 'after' => 'cache.public']);
Route::any('/acao-social', ['as' => 'acao-social', 'uses' => 'PageController@anyAcaoSocial', 'after' => 'cache.public']);
Route::any('/imprensa', ['as' => 'imprensa', 'uses' => 'PageController@anyImprensa', 'after' => 'cache.public']);
Route::any('webservice/valida-cupom.php', ['as' => 'snowland-valida-cupom', 'uses' => 'XmlServerController@postSnowlandValida']);
Route::any('webservice/utiliza-cupom.php', ['as' => 'snowland-utiliza-cupom', 'uses' => 'XmlServerController@postSnowlandUtiliza']);
Route::any('criteo.php', ['as' => 'criteo', 'uses' => 'XmlServerController@getCriteo']);

/*
 * Newsletter
 */
Route::post('newsletter/gravar', ['as' => 'newsletter.save', 'uses' => 'NewsletterController@postNewsletter']);

/*
 * Suggest a trip
 */

Route::any('suggest', ['as' => 'suggest', 'uses' => 'SuggestATripController@anyIndex']);


Route::get('suggest/create', ['as' => 'suggest.create', 'uses' => 'SuggestATripController@getCreate']);
Route::post('suggest/create', ['as' => 'suggest.save', 'uses' => 'SuggestATripController@postCreate']);

Route::group(array('prefix' => 'minha-conta', 'before' => 'auth'), function(){
    
    /*
	 * Minha conta
	 */
    Route::any('/', ['as' => 'minha-conta', 'uses' => 'PageController@anyMinhaConta', 'after' => 'cache.public']);

});

/*
 * Tell Us
 */

Route::any('tellus', ['as' => 'tellus', 'uses' => 'TellUsController@anyIndex']);

Route::get('tellus/create', ['as' => 'tellus.create', 'uses' => 'TellUsController@getCreate']);
Route::post('tellus/create', ['as' => 'tellus.save', 'uses' => 'TellUsController@postCreate']);

Route::get('{slug}', ['as' => 'category.offer', 'uses' => 'CategoryController@anyCategory', 'after' => 'cache.public']);//->where('slug', '[A-Za-z]+');

