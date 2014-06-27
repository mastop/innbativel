<?php

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

