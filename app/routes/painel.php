<?php

Route::group(array('prefix' => 'painel', 'before' => 'auth'), function(){
    /*
	 * Painel/Dashboard
	 */
    Route::any('/', ['as' => 'painel', 'uses' => 'PainelController@getDashboard', 'after' => 'cache.public']);

    /*
     * Painel/User
     */
    Route::get('editar-conta', ['as' => 'painel.user.edit', 'uses' => 'PainelUserController@getEdit']);
    Route::post('editar-conta', ['as' => 'painel.user.update', 'uses' => 'PainelUserController@postEdit']);

    /*
     * Painel/Orders
     */
	Route::any('ofertas', ['as' => 'painel.order.offers', 'uses' => 'PainelOrderController@anyListByOffer']);

	Route::any('ofertas/exportar', function(){ return Redirect::route('painel.order.offers'); });
	Route::get('ofertas/exportar/{offer_id?}/{starts_on?}/{ends_on?}', ['as' => 'painel.order.list_offers_export', 'uses' => 'PainelOrderController@getListOffersExport']);

	Route::any('ofertas/voucher/{offer_option_id?}', ['as' => 'painel.order.voucher', 'uses' => 'PainelOrderController@anyVouchers']);

	Route::any('ofertas/voucher/agendar', function(){ return Redirect::route('painel.order.offers'); });
	Route::get('ofertas/voucher/agendar/{id}/{used}/{offer_option_id?}', ['as' => 'painel.order.schedule', 'uses' => 'PainelOrderController@getSchedule']);

	Route::any('ofertas/voucher/exportar', function(){ return Redirect::route('painel.order.offers'); });
	Route::get('ofertas/voucher/exportar/{offer_option_id?}/{id?}', ['as' => 'painel.order.voucher_export', 'uses' => 'PainelOrderController@getVoucherExport']);
});


