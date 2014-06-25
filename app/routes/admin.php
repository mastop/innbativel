<?php

Route::group(array('https', 'prefix' => 'admin', 'before' => 'auth|perm'), function(){
	/*
	 * Dashboard
	 */
	Route::get('/', ['as' => 'admin', 'uses' => 'AdminController@getDashboard', 'after' => 'cache.public']);

	/*
	 * Users
	 */
	Route::any('user', ['as' => 'admin.user', 'uses' => 'AdminUserController@anyIndex']);

	Route::get('user/view/{id}', ['as' => 'admin.user.view', 'uses' => 'AdminUserController@getView']);

	Route::get('user/create', ['as' => 'admin.user.create', 'uses' => 'AdminUserController@getCreate']);
	Route::post('user/create', ['as' => 'admin.user.save', 'uses' => 'AdminUserController@postCreate']);

	Route::get('user/edit/{id}', ['as' => 'admin.user.edit', 'uses' => 'AdminUserController@getEdit']);
	Route::post('user/edit/{id}', ['as' => 'admin.user.update', 'uses' => 'AdminUserController@postEdit']);

	Route::any('user/delete', function(){ return Redirect::route('admin.user'); });
	Route::get('user/delete/{id}', ['as' => 'admin.user.delete', 'uses' => 'AdminUserController@getDelete']);
	Route::post('user/delete/{id}', ['as' => 'admin.user.destroy', 'uses' => 'AdminUserController@postDelete']);

	Route::any('user/deleted', ['as' => 'admin.user.deleted', 'uses' => 'AdminUserController@anyDeleted']);

	Route::any('user/deleted/view', function(){ return Redirect::route('admin.user.deleted'); });
	Route::get('user/deleted/view/{id}', ['as' => 'admin.user.deleted.view', 'uses' => 'AdminUserController@getDeletedView']);

	Route::any('user/deleted/edit', function(){ return Redirect::route('admin.user.deleted'); });
	Route::get('user/deleted/edit/{id}', ['as' => 'admin.user.deleted.edit', 'uses' => 'AdminUserController@getDeletedEdit']);
	Route::post('user/deleted/edit/{id}', ['as' => 'admin.user.deleted.update', 'uses' => 'AdminUserController@postDeletedEdit']);

	Route::any('user/deleted/forcedelete', function(){ return Redirect::route('admin.user.deleted'); });
	Route::get('user/deleted/forcedelete/{id}', ['as' => 'admin.user.deleted.delete', 'uses' => 'AdminUserController@getDeletedDelete']);
	Route::post('user/deleted/forcedelete/{id}', ['as' => 'admin.user.deleted.destroy', 'uses' => 'AdminUserController@postDeletedDelete']);

	Route::any('user/deleted/restore', function(){ return Redirect::route('admin.user.deleted'); });
	Route::get('user/deleted/restore/{id}', ['as' => 'admin.user.deleted.restore', 'uses' => 'AdminUserController@getDeletedRestore']);
	Route::post('user/deleted/restore/{id}', ['as' => 'admin.user.deleted.reactivate', 'uses' => 'AdminUserController@postDeletedRestore']);

	/*
	 * Partners (users whose role is 'partner')
	 */

	Route::any('partner', ['as' => 'admin.partner', 'uses' => 'AdminPartnerController@anyIndex']);

	Route::get('partner/view/{id}', ['as' => 'admin.partner.view', 'uses' => 'AdminPartnerController@getView']);

	Route::get('partner/create', ['as' => 'admin.partner.create', 'uses' => 'AdminPartnerController@getCreate']);
	Route::post('partner/create', ['as' => 'admin.partner.save', 'uses' => 'AdminPartnerController@postCreate']);

	Route::get('partner/edit/{id}', ['as' => 'admin.partner.edit', 'uses' => 'AdminPartnerController@getEdit']);
	Route::post('partner/edit/{id}', ['as' => 'admin.partner.update', 'uses' => 'AdminPartnerController@postEdit']);

	Route::any('partner/delete', function(){ return Redirect::route('admin.partner'); });
	Route::get('partner/delete/{id}', ['as' => 'admin.partner.delete', 'uses' => 'AdminPartnerController@getDelete']);
	Route::post('partner/delete/{id}', ['as' => 'admin.partner.destroy', 'uses' => 'AdminPartnerController@postDelete']);

	Route::any('partner/deleted', ['as' => 'admin.partner.deleted', 'uses' => 'AdminPartnerController@anyDeleted']);

	Route::any('partner/deleted/view', function(){ return Redirect::route('admin.partner.deleted'); });
	Route::get('partner/deleted/view/{id}', ['as' => 'admin.partner.deleted.view', 'uses' => 'AdminPartnerController@getDeletedView']);

	Route::any('partner/deleted/edit', function(){ return Redirect::route('admin.partner.deleted'); });
	Route::get('partner/deleted/edit/{id}', ['as' => 'admin.partner.deleted.edit', 'uses' => 'AdminPartnerController@getDeletedEdit']);
	Route::post('partner/deleted/edit/{id}', ['as' => 'admin.partner.deleted.update', 'uses' => 'AdminPartnerController@postDeletedEdit']);

	Route::any('partner/deleted/forcedelete', function(){ return Redirect::route('admin.partner.deleted'); });
	Route::get('partner/deleted/forcedelete/{id}', ['as' => 'admin.partner.deleted.delete', 'uses' => 'AdminPartnerController@getDeletedDelete']);
	Route::post('partner/deleted/forcedelete/{id}', ['as' => 'admin.partner.deleted.destroy', 'uses' => 'AdminPartnerController@postDeletedDelete']);

	Route::any('partner/deleted/restore', function(){ return Redirect::route('admin.partner.deleted'); });
	Route::get('partner/deleted/restore/{id}', ['as' => 'admin.partner.deleted.restore', 'uses' => 'AdminPartnerController@getDeletedRestore']);
	Route::post('partner/deleted/restore/{id}', ['as' => 'admin.partner.deleted.reactivate', 'uses' => 'AdminPartnerController@postDeletedRestore']);

	/*
	 * Roles
	 */

	Route::any('role', ['as' => 'admin.role', 'uses' => 'AdminRoleController@anyIndex']);

	Route::get('role/create', ['as' => 'admin.role.create', 'uses' => 'AdminRoleController@getCreate']);
	Route::post('role/create', ['as' => 'admin.role.save', 'uses' => 'AdminRoleController@postCreate']);

	Route::any('role/edit', function(){ return Redirect::route('admin.role'); });
	Route::get('role/edit/{id}', ['as' => 'admin.role.edit', 'uses' => 'AdminRoleController@getEdit']);
	Route::post('role/edit/{id}', ['as' => 'admin.role.update', 'uses' => 'AdminRoleController@postEdit']);

	Route::any('role/delete', function(){ return Redirect::route('admin.role'); });
	Route::get('role/delete/{id}', ['as' => 'admin.role.delete', 'uses' => 'AdminRoleController@getDelete']);
	Route::post('role/delete/{id}', ['as' => 'admin.role.destroy', 'uses' => 'AdminRoleController@postDelete']);

	/*
	 * Permissions
	 */

	Route::any('perm', ['as' => 'admin.perm', 'uses' => 'AdminPermController@anyIndex']);

	Route::get('perm/create', ['as' => 'admin.perm.create', 'uses' => 'AdminPermController@getCreate']);
	Route::post('perm/create', ['as' => 'admin.perm.save', 'uses' => 'AdminPermController@postCreate']);

	Route::any('perm/edit', function(){ return Redirect::route('admin.perm'); });
	Route::get('perm/edit/{id}', ['as' => 'admin.perm.edit', 'uses' => 'AdminPermController@getEdit']);
	Route::post('perm/edit/{id}', ['as' => 'admin.perm.update', 'uses' => 'AdminPermController@postEdit']);

	Route::any('perm/delete', function(){ return Redirect::route('admin.perm'); });
	Route::get('perm/delete/{id}', ['as' => 'admin.perm.delete', 'uses' => 'AdminPermController@getDelete']);
	Route::post('perm/delete/{id}', ['as' => 'admin.perm.destroy', 'uses' => 'AdminPermController@postDelete']);

	/*
	 * Offers
	 */

	Route::any('offer', ['as' => 'admin.offer', 'uses' => 'AdminOfferController@anyIndex']);

	Route::get('offer/create', ['as' => 'admin.offer.create', 'uses' => 'AdminOfferController@getCreate']);
	Route::post('offer/create', ['as' => 'admin.offer.save', 'uses' => 'AdminOfferController@postCreate']);

	Route::any('offer/edit', function(){ return Redirect::route('admin.offer'); });
	Route::get('offer/edit/{id}', ['as' => 'admin.offer.edit', 'uses' => 'AdminOfferController@getEdit']);
	Route::post('offer/edit/{id}', ['as' => 'admin.offer.update', 'uses' => 'AdminOfferController@postEdit']);

	// Route::any('offer/delete', function(){ return Redirect::route('admin.offer'); });
	// Route::get('offer/delete/{id}', ['as' => 'admin.offer.delete', 'uses' => 'AdminOfferController@getDelete']);
	// Route::post('offer/delete/{id}', ['as' => 'admin.offer.destroy', 'uses' => 'AdminOfferController@postDelete']);

	Route::get('offer/clearfield/{id}/{field}', ['as' => 'admin.offer.clearfield', 'uses' => 'AdminOfferController@getClearfield']);

	Route::get('offer/sort', ['as' => 'admin.offer.sort', 'uses' => 'AdminOfferController@getSort']);
	Route::post('offer/sort', ['as' => 'admin.offer.save_sort', 'uses' => 'AdminOfferController@postSort']);

	Route::get('offer/sort_comment/{id}', ['as' => 'admin.offer.sort_comment', 'uses' => 'AdminOfferController@getSortComment']);
	Route::post('offer/sort_comment/{offer_id}', ['as' => 'admin.offer.save_sort_comment', 'uses' => 'AdminOfferController@postSortComment']);

	Route::get('offer/newsletter', ['as' => 'admin.offer.newsletter', 'uses' => 'AdminOfferController@getNewsletter']);
	Route::post('offer/newsletter', ['as' => 'admin.offer.generate_newsletter', 'uses' => 'AdminOfferController@postNewsletter']);

	/*
	 * Configs
	 */

	Route::any('config', ['as' => 'admin.config', 'uses' => 'AdminConfigController@anyIndex']);

	Route::get('config/create', ['as' => 'admin.config.create', 'uses' => 'AdminConfigController@getCreate']);
	Route::post('config/create', ['as' => 'admin.config.save', 'uses' => 'AdminConfigController@postCreate']);

	Route::any('config/edit', function(){ return Redirect::route('admin.config'); });
	Route::get('config/edit/{id}', ['as' => 'admin.config.edit', 'uses' => 'AdminConfigController@getEdit']);
	Route::post('config/edit/{id}', ['as' => 'admin.config.update', 'uses' => 'AdminConfigController@postEdit']);

	Route::any('config/delete', function(){ return Redirect::route('admin.config'); });
	Route::get('config/delete/{id}', ['as' => 'admin.config.delete', 'uses' => 'AdminConfigController@getDelete']);
	Route::post('config/delete/{id}', ['as' => 'admin.config.destroy', 'uses' => 'AdminConfigController@postDelete']);

	/*
	 * Faqs
	 */

	Route::any('faq', ['as' => 'admin.faq', 'uses' => 'AdminFaqController@anyIndex']);

	Route::get('faq/create', ['as' => 'admin.faq.create', 'uses' => 'AdminFaqController@getCreate']);
	Route::post('faq/create', ['as' => 'admin.faq.save', 'uses' => 'AdminFaqController@postCreate']);

	Route::any('faq/edit', function(){ return Redirect::route('admin.faq'); });
	Route::get('faq/edit/{id}', ['as' => 'admin.faq.edit', 'uses' => 'AdminFaqController@getEdit']);
	Route::post('faq/edit/{id}', ['as' => 'admin.faq.update', 'uses' => 'AdminFaqController@postEdit']);

	Route::any('faq/delete', function(){ return Redirect::route('admin.faq'); });
	Route::get('faq/delete/{id}', ['as' => 'admin.faq.delete', 'uses' => 'AdminFaqController@getDelete']);
	Route::post('faq/delete/{id}', ['as' => 'admin.faq.destroy', 'uses' => 'AdminFaqController@postDelete']);

	/*
	 * Orders
	 */
	Route::any('order', ['as' => 'admin.order', 'uses' => 'AdminOrderController@anyIndex']);

	Route::any('order/view', function(){ return Redirect::route('admin.order'); });
	Route::get('order/view/{id}', ['as' => 'admin.order.view', 'uses' => 'AdminOrderController@getView']);

	Route::get('order/voucher/cancel', function(){ return Redirect::route('admin.order'); });
	Route::post('order/voucher/cancel', ['as' => 'admin.order.voucher_cancel', 'uses' => 'AdminOrderController@getVoucherCancel']);

	Route::get('order/teste', ['as' => 'admin.order.teste', 'uses' => 'AdminOrderController@teste']);

	Route::any('order/offers', ['as' => 'admin.order.offers', 'uses' => 'AdminOrderController@anyListByOffer']);

	Route::any('order/offers_export', function(){ return Redirect::route('admin.order'); });
	Route::get('order/offers_export/{offer_option_id}/{status?}', ['as' => 'admin.order.offers_export', 'uses' => 'AdminOrderController@getOffersExport']);
	Route::any('order/list_offers_export', function(){ return Redirect::route('admin.order.offers'); });
	Route::get('order/list_offers_export/{offer_id?}/{starts_on?}/{ends_on?}', ['as' => 'admin.order.list_offers_export', 'uses' => 'AdminOrderController@getListOffersExport']);
	Route::any('order/list_paym_export', function(){ return Redirect::route('admin.order'); });
	Route::get('order/list_paym_export/{status?}/{terms?}/{name?}/{email?}/{braspag_order_id?}/{offer_id?}/{date_start?}/{date_end?}', ['as' => 'admin.order.list_paym_export', 'uses' => 'AdminOrderController@getListPaymExport']);

	// Route::any('order/void', function(){ return Redirect::route('admin.order'); });
	// Route::get('order/void/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.void', 'uses' => 'AdminOrderController@getVoid']);
	Route::any('order/cancel', function(){ return Redirect::route('admin.order'); });
	Route::get('order/cancel/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.cancel', 'uses' => 'AdminOrderController@getCancel']);
	// Route::any('order/reject', function(){ return Redirect::route('admin.order'); });
	// Route::get('order/reject/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.reject', 'uses' => 'AdminOrderController@getReject']);
	Route::any('order/approve', function(){ return Redirect::route('admin.order'); });
	Route::get('order/approve/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.approve', 'uses' => 'AdminOrderController@getApprove']);
	Route::any('order/convert_value_2_credit', function(){ return Redirect::route('admin.order'); });
	Route::get('order/convert_value_2_credit/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.convert_value_2_credit', 'uses' => 'AdminOrderController@getConvertValue2Credit']);
	// Route::any('order/cancel_boletus', function(){ return Redirect::route('admin.order'); });
	// Route::get('order/cancel_boletus/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.cancel_boletus', 'uses' => 'AdminOrderController@getCancelPaidByCredit']);
	// Route::any('order/cancel_paid_by_credit', function(){ return Redirect::route('admin.order'); });
	// Route::get('order/cancel_paid_by_credit/{id}/{braspag_order_id}/{comment}', ['as' => 'admin.order.cancel_boletus', 'uses' => 'AdminOrderController@getCancelPaidByCredit']);

	Route::any('order/voucher/{offer_option_id?}', ['as' => 'admin.order.voucher', 'uses' => 'AdminOrderController@anyVouchers']);

	Route::any('order/voucher/exportar', function(){ return Redirect::route('admin.order'); });
	Route::get('order/voucher/exportar/{offer_option_id?}/{id?}', ['as' => 'admin.order.voucher_export', 'uses' => 'AdminOrderController@getVoucherExport']);

	// Route::get('order/validate_discount_coupon/{display_code}/{offers_options_ids}', ['as' => 'admin.order.val_disc_counpon', 'uses' => 'AdminOrderController@validateDiscountCoupon']);
	
	/*
	 * Category
	 */
	Route::any('category', ['as' => 'admin.category', 'uses' => 'AdminCategoryController@anyIndex']);

	Route::get('category/create', ['as' => 'admin.category.create', 'uses' => 'AdminCategoryController@getCreate']);
	Route::post('category/create', ['as' => 'admin.category.save', 'uses' => 'AdminCategoryController@postCreate']);

	Route::any('category/edit', function(){ return Redirect::route('admin.category'); });
	Route::get('category/edit/{id}', ['as' => 'admin.category.edit', 'uses' => 'AdminCategoryController@getEdit']);
	Route::post('category/edit/{id}', ['as' => 'admin.category.update', 'uses' => 'AdminCategoryController@postEdit']);

	Route::any('category/delete', function(){ return Redirect::route('admin.category'); });
	Route::get('category/delete/{id}', ['as' => 'admin.category.delete', 'uses' => 'AdminCategoryController@getDelete']);
	Route::post('category/delete/{id}', ['as' => 'admin.category.destroy', 'uses' => 'AdminCategoryController@postDelete']);

	Route::get('category/sort', ['as' => 'admin.category.sort', 'uses' => 'AdminCategoryController@getSort']);
	Route::post('category/sort', ['as' => 'admin.category.save_sort', 'uses' => 'AdminCategoryController@postSort']);


	/*
	 * Discount Coupons
	 */

	Route::any('coupon', ['as' => 'admin.coupon', 'uses' => 'AdminCouponController@anyIndex']);

	Route::get('coupon/create', ['as' => 'admin.coupon.create', 'uses' => 'AdminCouponController@getCreate']);
	Route::post('coupon/create', ['as' => 'admin.coupon.save', 'uses' => 'AdminCouponController@postCreate']);

	Route::any('coupon/edit', function(){ return Redirect::route('admin.coupon'); });
	Route::get('coupon/edit/{id}', ['as' => 'admin.coupon.edit', 'uses' => 'AdminCouponController@getEdit']);
	Route::post('coupon/edit/{id}', ['as' => 'admin.coupon.update', 'uses' => 'AdminCouponController@postEdit']);

	Route::any('coupon/delete', function(){ return Redirect::route('admin.coupon'); });
	Route::get('coupon/delete/{id}', ['as' => 'admin.coupon.delete', 'uses' => 'AdminCouponController@getDelete']);
	Route::post('coupon/delete/{id}', ['as' => 'admin.coupon.destroy', 'uses' => 'AdminCouponController@postDelete']);

	/*
	 * comment
	 */

	Route::any('comment/{id?}', ['as' => 'admin.comment', 'uses' => 'AdminCommentController@anyIndex']);
	Route::get('comment/approved/{id}/{approved}', ['as' => 'admin.comment.update_approved', 'uses' => 'AdminCommentController@getUpdateApproved']);

	/*
	 * NGOs
	 */

	Route::any('ngo', ['as' => 'admin.ngo', 'uses' => 'AdminNgoController@anyIndex']);

	Route::get('ngo/create', ['as' => 'admin.ngo.create', 'uses' => 'AdminNgoController@getCreate']);
	Route::post('ngo/create', ['as' => 'admin.ngo.save', 'uses' => 'AdminNgoController@postCreate']);

	Route::any('ngo/edit', function(){ return Redirect::route('admin.ngo'); });
	Route::get('ngo/edit/{id}', ['as' => 'admin.ngo.edit', 'uses' => 'AdminNgoController@getEdit']);
	Route::post('ngo/edit/{id}', ['as' => 'admin.ngo.update', 'uses' => 'AdminNgoController@postEdit']);

	Route::any('ngo/delete', function(){ return Redirect::route('admin.ngo'); });
	Route::get('ngo/delete/{id}', ['as' => 'admin.ngo.delete', 'uses' => 'AdminNgoController@getDelete']);
	Route::post('ngo/delete/{id}', ['as' => 'admin.ngo.destroy', 'uses' => 'AdminNgoController@postDelete']);

	Route::get('ngo/clearfield/{id}/{field}', ['as' => 'admin.ngo.clearfield', 'uses' => 'AdminNgoController@getClearfield']);

	/*
	 * Genres
	 */

	Route::any('genre', ['as' => 'admin.genre', 'uses' => 'AdminGenreController@anyIndex']);

	Route::get('genre/create', ['as' => 'admin.genre.create', 'uses' => 'AdminGenreController@getCreate']);
	Route::post('genre/create', ['as' => 'admin.genre.save', 'uses' => 'AdminGenreController@postCreate']);

	Route::any('genre/edit', function(){ return Redirect::route('admin.genre'); });
	Route::get('genre/edit/{id}', ['as' => 'admin.genre.edit', 'uses' => 'AdminGenreController@getEdit']);
	Route::post('genre/edit/{id}', ['as' => 'admin.genre.update', 'uses' => 'AdminGenreController@postEdit']);

	Route::any('genre/delete', function(){ return Redirect::route('admin.genre'); });
	Route::get('genre/delete/{id}', ['as' => 'admin.genre.delete', 'uses' => 'AdminGenreController@getDelete']);
	Route::post('genre/delete/{id}', ['as' => 'admin.genre.destroy', 'uses' => 'AdminGenreController@postDelete']);

	/*
	 * Tellus
	 */

	Route::any('tellus', ['as' => 'admin.tellus', 'uses' => 'AdminTellusController@anyIndex']);

	Route::get('tellus/create', ['as' => 'admin.tellus.create', 'uses' => 'AdminTellusController@getCreate']);
	Route::post('tellus/create', ['as' => 'admin.tellus.save', 'uses' => 'AdminTellusController@postCreate']);

	Route::any('tellus/edit', function(){ return Redirect::route('admin.tellus'); });
	Route::get('tellus/edit/{id}', ['as' => 'admin.tellus.edit', 'uses' => 'AdminTellusController@getEdit']);
	Route::post('tellus/edit/{id}', ['as' => 'admin.tellus.update', 'uses' => 'AdminTellusController@postEdit']);

	Route::any('tellus/delete', function(){ return Redirect::route('admin.tellus'); });
	Route::get('tellus/delete/{id}', ['as' => 'admin.tellus.delete', 'uses' => 'AdminTellusController@getDelete']);
	Route::post('tellus/delete/{id}', ['as' => 'admin.tellus.destroy', 'uses' => 'AdminTellusController@postDelete']);

	Route::get('tellus/sort', ['as' => 'admin.tellus.sort', 'uses' => 'AdminTellusController@getSort']);
	Route::post('tellus/sort', ['as' => 'admin.tellus.save_sort', 'uses' => 'AdminTellusController@postSort']);

	Route::get('tellus/clearfield/{id}/{field}', ['as' => 'admin.tellus.clearfield', 'uses' => 'AdminTellusController@getClearfield']);

	Route::get('tellus/approve/{id}/{approved}', ['as' => 'admin.tellus.approve', 'uses' => 'AdminTellusController@getApprove']);

	/*
	 * PartnerTestimony
	 */

	Route::any('partner_testimony', ['as' => 'admin.partner_testimony', 'uses' => 'AdminPartnerTestimonyController@anyIndex']);

	Route::get('partner_testimony/create', ['as' => 'admin.partner_testimony.create', 'uses' => 'AdminPartnerTestimonyController@getCreate']);
	Route::post('partner_testimony/create', ['as' => 'admin.partner_testimony.save', 'uses' => 'AdminPartnerTestimonyController@postCreate']);

	Route::any('partner_testimony/edit', function(){ return Redirect::route('admin.partner_testimony'); });
	Route::get('partner_testimony/edit/{id}', ['as' => 'admin.partner_testimony.edit', 'uses' => 'AdminPartnerTestimonyController@getEdit']);
	Route::post('partner_testimony/edit/{id}', ['as' => 'admin.partner_testimony.update', 'uses' => 'AdminPartnerTestimonyController@postEdit']);

	Route::any('partner_testimony/delete', function(){ return Redirect::route('admin.partner_testimony'); });
	Route::get('partner_testimony/delete/{id}', ['as' => 'admin.partner_testimony.delete', 'uses' => 'AdminPartnerTestimonyController@getDelete']);
	Route::post('partner_testimony/delete/{id}', ['as' => 'admin.partner_testimony.destroy', 'uses' => 'AdminPartnerTestimonyController@postDelete']);

	Route::get('partner_testimony/sort', ['as' => 'admin.partner_testimony.sort', 'uses' => 'AdminPartnerTestimonyController@getSort']);
	Route::post('partner_testimony/sort', ['as' => 'admin.partner_testimony.save_sort', 'uses' => 'AdminPartnerTestimonyController@postSort']);

	Route::get('partner_testimony/clearfield/{id}/{field}', ['as' => 'admin.partner_testimony.clearfield', 'uses' => 'AdminPartnerTestimonyController@getClearfield']);

	/*
	 * Suggest a trip
	 */

	Route::any('suggest', ['as' => 'admin.suggest', 'uses' => 'AdminSuggestATripController@anyIndex']);

	Route::get('suggest/create', ['as' => 'admin.suggest.create', 'uses' => 'AdminSuggestATripController@getCreate']);
	Route::post('suggest/create', ['as' => 'admin.suggest.save', 'uses' => 'AdminSuggestATripController@postCreate']);

	Route::any('suggest/edit', function(){ return Redirect::route('admin.suggest'); });
	Route::get('suggest/edit/{id}', ['as' => 'admin.suggest.edit', 'uses' => 'AdminSuggestATripController@getEdit']);
	Route::post('suggest/edit/{id}', ['as' => 'admin.suggest.update', 'uses' => 'AdminSuggestATripController@postEdit']);

	Route::any('suggest/delete', function(){ return Redirect::route('admin.suggest'); });
	Route::get('suggest/delete/{id}', ['as' => 'admin.suggest.delete', 'uses' => 'AdminSuggestATripController@getDelete']);
	Route::post('suggest/delete/{id}', ['as' => 'admin.suggest.destroy', 'uses' => 'AdminSuggestATripController@postDelete']);

	/*
	 * Destinos
	 */

	Route::any('destiny', ['as' => 'admin.destiny', 'uses' => 'AdminDestinyController@anyIndex']);

	Route::get('destiny/create', ['as' => 'admin.destiny.create', 'uses' => 'AdminDestinyController@getCreate']);
	Route::post('destiny/create', ['as' => 'admin.destiny.save', 'uses' => 'AdminDestinyController@postCreate']);

	Route::any('destiny/edit', function(){ return Redirect::route('admin.destiny'); });
	Route::get('destiny/edit/{id}', ['as' => 'admin.destiny.edit', 'uses' => 'AdminDestinyController@getEdit']);
	Route::post('destiny/edit/{id}', ['as' => 'admin.destiny.update', 'uses' => 'AdminDestinyController@postEdit']);

	Route::any('destiny/delete', function(){ return Redirect::route('admin.destiny'); });
	Route::get('destiny/delete/{id}', ['as' => 'admin.destiny.delete', 'uses' => 'AdminDestinyController@getDelete']);
	Route::post('destiny/delete/{id}', ['as' => 'admin.destiny.destroy', 'uses' => 'AdminDestinyController@postDelete']);

	/*
	 * Feriados
	 */

	Route::any('holiday', ['as' => 'admin.holiday', 'uses' => 'AdminHolidayController@anyIndex']);

	Route::get('holiday/create', ['as' => 'admin.holiday.create', 'uses' => 'AdminHolidayController@getCreate']);
	Route::post('holiday/create', ['as' => 'admin.holiday.save', 'uses' => 'AdminHolidayController@postCreate']);

	Route::any('holiday/edit', function(){ return Redirect::route('admin.holiday'); });
	Route::get('holiday/edit/{id}', ['as' => 'admin.holiday.edit', 'uses' => 'AdminHolidayController@getEdit']);
	Route::post('holiday/edit/{id}', ['as' => 'admin.holiday.update', 'uses' => 'AdminHolidayController@postEdit']);

	Route::any('holiday/delete', function(){ return Redirect::route('admin.holiday'); });
	Route::get('holiday/delete/{id}', ['as' => 'admin.holiday.delete', 'uses' => 'AdminHolidayController@getDelete']);
	Route::post('holiday/delete/{id}', ['as' => 'admin.holiday.destroy', 'uses' => 'AdminHolidayController@postDelete']);

	/*
	 * Included
	 */

	Route::any('included', ['as' => 'admin.included', 'uses' => 'AdminIncludedController@anyIndex']);

	Route::get('included/create', ['as' => 'admin.included.create', 'uses' => 'AdminIncludedController@getCreate']);
	Route::post('included/create', ['as' => 'admin.included.save', 'uses' => 'AdminIncludedController@postCreate']);

	Route::any('included/edit', function(){ return Redirect::route('admin.included'); });
	Route::get('included/edit/{id}', ['as' => 'admin.included.edit', 'uses' => 'AdminIncludedController@getEdit']);
	Route::post('included/edit/{id}', ['as' => 'admin.included.update', 'uses' => 'AdminIncludedController@postEdit']);

	Route::any('included/delete', function(){ return Redirect::route('admin.included'); });
	Route::get('included/delete/{id}', ['as' => 'admin.included.delete', 'uses' => 'AdminIncludedController@getDelete']);
	Route::post('included/delete/{id}', ['as' => 'admin.included.destroy', 'uses' => 'AdminIncludedController@postDelete']);

	/*
	 * Tags
	 */

	Route::any('tag', ['as' => 'admin.tag', 'uses' => 'AdminTagController@anyIndex']);

	Route::get('tag/create', ['as' => 'admin.tag.create', 'uses' => 'AdminTagController@getCreate']);
	Route::post('tag/create', ['as' => 'admin.tag.save', 'uses' => 'AdminTagController@postCreate']);

	Route::any('tag/edit', function(){ return Redirect::route('admin.tag'); });
	Route::get('tag/edit/{id}', ['as' => 'admin.tag.edit', 'uses' => 'AdminTagController@getEdit']);
	Route::post('tag/edit/{id}', ['as' => 'admin.tag.update', 'uses' => 'AdminTagController@postEdit']);

	Route::any('tag/delete', function(){ return Redirect::route('admin.tag'); });
	Route::get('tag/delete/{id}', ['as' => 'admin.tag.delete', 'uses' => 'AdminTagController@getDelete']);
	Route::post('tag/delete/{id}', ['as' => 'admin.tag.destroy', 'uses' => 'AdminTagController@postDelete']);

	/*
	 * Contracts
	 */

	Route::any('contract', ['as' => 'admin.contract', 'uses' => 'AdminContractController@anyIndex']);

	Route::get('contract/view/{id}', ['as' => 'admin.contract.view', 'uses' => 'AdminContractController@getView']);

	Route::get('contract/print/{id}', ['as' => 'admin.contract.print', 'uses' => 'AdminContractController@getPrint']);

	Route::get('contract/create', ['as' => 'admin.contract.create', 'uses' => 'AdminContractController@getCreate']);
	Route::post('contract/create', ['as' => 'admin.contract.save', 'uses' => 'AdminContractController@postCreate']);

	Route::get('contract/send/{id}', ['as' => 'admin.contract.send', 'uses' => 'AdminContractController@getSend']);

	Route::any('contract/edit', function(){ return Redirect::route('admin.contract'); });
	Route::get('contract/edit/{id}', ['as' => 'admin.contract.edit', 'uses' => 'AdminContractController@getEdit']);
	Route::post('contract/edit/{id}', ['as' => 'admin.contract.update', 'uses' => 'AdminContractController@postEdit']);

	Route::any('contract/delete', function(){ return Redirect::route('admin.contract'); });
	Route::get('contract/delete/{id}', ['as' => 'admin.contract.delete', 'uses' => 'AdminContractController@getDelete']);
	Route::post('contract/delete/{id}', ['as' => 'admin.contract.destroy', 'uses' => 'AdminContractController@postDelete']);

	/*
	 * Payments
	 */

	Route::any('payment', ['as' => 'admin.payment', 'uses' => 'AdminPaymentController@anyIndex']);

	Route::get('payment/update_status/{id}/{date?}', ['as' => 'admin.payment.update_status', 'uses' => 'AdminPaymentController@getUpdateStatus']);

	Route::any('payment/vouchers', ['as' => 'admin.payment.voucher', 'uses' => 'AdminPaymentController@anyVoucher']);

	Route::any('payment/vouchers_export', function(){ return Redirect::route('admin.payment.voucher'); });
	Route::get('payment/vouchers_export/{partner_name?}/{payment_id?}', ['as' => 'admin.payment.voucher_export', 'uses' => 'AdminPaymentController@getVoucherExport']);

	Route::any('payment/periodos', ['as' => 'admin.payment.period', 'uses' => 'AdminPaymentController@anyPeriod']);

	Route::get('payment/periodos/create', ['as' => 'admin.payment.create', 'uses' => 'AdminPaymentController@getCreate']);
	Route::post('payment/periodos/create', ['as' => 'admin.payment.save', 'uses' => 'AdminPaymentController@postCreate']);

	Route::any('payment/periodos/edit', function(){ return Redirect::route('admin.payment.period'); });
	Route::get('payment/periodos/edit/{id}', ['as' => 'admin.payment.edit', 'uses' => 'AdminPaymentController@getEdit']);
	Route::post('payment/periodos/edit/{id}', ['as' => 'admin.payment.update', 'uses' => 'AdminPaymentController@postEdit']);

	Route::any('payment/periodos/delete', function(){ return Redirect::route('admin.payment.period'); });
	Route::get('payment/periodos/delete/{id}', ['as' => 'admin.payment.delete', 'uses' => 'AdminPaymentController@getDelete']);
	Route::post('payment/periodos/delete/{id}', ['as' => 'admin.payment.destroy', 'uses' => 'AdminPaymentController@postDelete']);

	/*
	 * Transaction
	 */

	Route::any('transaction', ['as' => 'admin.transaction', 'uses' => 'AdminTransactionController@anyIndex']);

	Route::any('transaction/export', function(){ return Redirect::route('admin.transaction'); });
	Route::get('transaction/export/{date_start?}/{date_end?}', ['as' => 'admin.transaction.export', 'uses' => 'AdminTransactionController@getExport']);
    
    /*
	 * Newsletter
	 */
    Route::any('newsletter', ['as' => 'admin.newsletter', 'uses' => 'AdminNewsletterController@anyIndex']);
    Route::get('newsletter/export', ['as' => 'admin.newsletter.export', 'uses' => 'AdminNewsletterController@getExport']);
});
