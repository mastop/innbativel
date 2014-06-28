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
    Route::post('/cupom-de-desconto', ['as' => 'valida-cupom', 'uses' => 'PageController@postValidateCoupon']);
    Route::any('/cupom/{id}', ['as' => 'cupom', 'uses' => 'PageController@getViewVoucher']);
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

Route::group(array('https', 'prefix' => 'painel', 'before' => 'auth|perm'), function(){
    /*
     * Painel dashboard
     */
    Route::any('/', ['as' => 'painel', 'uses' => 'PainelController@getDashboard', 'after' => 'cache.public']);

    /*
     * Painel
     */
    Route::any('ofertas', ['as' => 'painel.order.offers', 'uses' => 'PainelOrderController@anyListByOffer']);

    Route::any('ofertas/exportar', function(){ return Redirect::route('painel.order.offers'); });
    Route::get('ofertas/exportar/{offer_id?}/{starts_on?}/{ends_on?}', ['as' => 'painel.order.list_offers_export', 'uses' => 'PainelOrderController@getListOffersExport']);

    Route::any('ofertas/voucher/{offer_option_id?}', ['as' => 'painel.order.voucher', 'uses' => 'PainelOrderController@anyVouchers']);

    Route::any('ofertas/voucher/update_tracking_code', function(){ return Redirect::route('painel.order.voucher'); });
    Route::post('ofertas/voucher/update_tracking_code/{id}', ['as' => 'painel.order.update_tracking_code', 'uses' => 'PainelOrderController@postUpdateTrackingCode']);

    Route::any('ofertas/voucher/agendar', function(){ return Redirect::route('painel.order.offers'); });
    Route::get('ofertas/voucher/agendar/{id}/{used}', ['as' => 'painel.order.schedule', 'uses' => 'PainelOrderController@getSchedule']);

    Route::any('ofertas/voucher/exportar', function(){ return Redirect::route('painel.order.offers'); });
    Route::get('ofertas/voucher/exportar/{offer_option_id?}/{id?}', ['as' => 'painel.order.voucher_export', 'uses' => 'PainelOrderController@getVoucherExport']);

    Route::any('contract', ['as' => 'painel.contract', 'uses' => 'PainelContractController@anyIndex']);

    Route::get('contract/view/{id}', ['as' => 'painel.contract.view', 'uses' => 'PainelContractController@getView']);

    Route::get('contract/print/{id}', ['as' => 'painel.contract.print', 'uses' => 'PainelContractController@getPrint']);

    Route::any('contract/sign', function(){ return Redirect::route('painel.contract'); });
    Route::get('contract/sign/{id}', ['as' => 'painel.contract.get_sign', 'uses' => 'PainelContractController@getSign']);
    Route::post('contract/sign/{id}', ['as' => 'painel.contract.post_sign', 'uses' => 'PainelContractController@postSign']);

    Route::any('pagamentos', ['as' => 'painel.payment', 'uses' => 'PainelPaymentController@anyIndex']);

    Route::any('pagamentos/vouchers', ['as' => 'painel.payment.voucher', 'uses' => 'PainelPaymentController@anyVoucher']);

    Route::any('pagamentos/vouchers_export', function(){ return Redirect::route('painel.payment.voucher'); });
    Route::get('pagamentos/vouchers_export/{payment_id?}', ['as' => 'painel.payment.voucher_export', 'uses' => 'PainelPaymentController@getVoucherExport']);

    Route::any('pagamentos/export', function(){ return Redirect::route('painel.payment.voucher'); });
    Route::get('pagamentos/export/{id?}/{payment_id?}', ['as' => 'painel.payment.export', 'uses' => 'PainelPaymentController@getExport']);
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

Route::group(array('https', 'prefix' => 'minha-conta', 'before' => 'auth'), function(){
    
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

