<?php

// Route::group(array('before' => 'auth|perm'), function(){
// 	Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome', 'after' => 'cache.public']);
// });

// Grupo de Routes que usam SSL

Route::group(array('https', 'after' => 'cache.public'), function()
{
    Route::any('/', ['as' => 'home', 'uses' => 'PageController@anyHome']);
    Route::any('/oferta/{slug}', ['as' => 'oferta', 'uses' => 'PageController@anyOferta']);
    Route::any('/comprar', ['as' => 'comprar', 'uses' => 'PageController@anyComprar']);
    Route::post('/cupom', ['as' => 'valida-cupom', 'uses' => 'PageController@postValidateCoupon']);
    Route::any('/sucesso/{status}/{boletus_url?}', ['as' => 'sucesso', 'uses' => 'PageController@anySucesso']);
    Route::any('/busca', ['as' => 'busca', 'uses' => 'PageController@anyBusca']);
    Route::any('/termos-de-uso', ['as' => 'termos-de-uso', 'uses' => 'PageController@anyTermosDeUso']);
    Route::any('/politica-de-privacidade', ['as' => 'politica-de-privacidade', 'uses' => 'PageController@anyPoliticaDePrivacidade']);
    Route::any('/quem-somos', ['as' => 'quem-somos', 'uses' => 'PageController@anyQuemSomos']);
    Route::any('/acao-social', ['as' => 'acao-social', 'uses' => 'PageController@anyAcaoSocial']);
    Route::any('/imprensa', ['as' => 'imprensa', 'uses' => 'PageController@anyImprensa']);
    Route::any('webservice/valida-cupom.php', ['as' => 'snowland-valida-cupom', 'uses' => 'XmlServerController@postSnowlandValida']);
    Route::any('webservice/utiliza-cupom.php', ['as' => 'snowland-utiliza-cupom', 'uses' => 'XmlServerController@postSnowlandUtiliza']);
    Route::any('criteo.php', ['as' => 'criteo', 'uses' => 'XmlServerController@getCriteo']);
    Route::any('/go/{ban}', ['as' => 'banner', 'uses' => 'PageController@getBanner']);
});

Route::any('/status', ['as' => 'status', 'uses' => 'PageController@anyStatus', 'after' => 'cache.public']);
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

