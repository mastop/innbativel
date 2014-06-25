<?php

//21

use Illuminate\Database\Migrations\Migration;

class ChangeAllForeignKeysToCascade extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('role_user', function($table)
		{

			$table->foreign('user_id')->onUpdate('cascade');
			$table->foreign('role_id')->onUpdate('cascade');

		});

		Schema::create('offers_included', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
			$table->foreign('included_id')->onUpdate('cascade');

		});

		Schema::create('comments', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
			$table->foreign('user_id')->onUpdate('cascade');

		});

		Schema::create('contracts', function($table)
		{
		
			$table->foreign('partner_id')->onUpdate('cascade');
			$table->foreign('consultant_id')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('contract_options', function($table)
		{
		
			$table->foreign('contract_id')->onUpdate('cascade');

		});

		Schema::create('offers', function($table)
		{
		
			$table->foreign('partner_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('category_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('genre_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('genre2_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('destiny_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('ngo_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('tell_us_id')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('offers_groups', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
			$table->foreign('group_id')->onUpdate('cascade');
		
		});

		Schema::create('offers_holidays', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
			$table->foreign('holiday_id')->onUpdate('cascade');
		
		});

		Schema::create('discount_coupons', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('cascade');
			$table->foreign('offer_id')->onUpdate('cascade');
		
		});

		Schema::create('offers_options', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');

		});

		Schema::create('offers_additional', function($table)
		{
		
			$table->foreign('offer_main_id')->onUpdate('cascade');
			$table->foreign('offer_additional_id')->onUpdate('cascade');
		
		});

		Schema::create('offers_images', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
		
		});

		Schema::create('permission_role', function($table)
		{
		
			$table->foreign('permission_id')->onUpdate('cascade');
			$table->foreign('role_id')->onUpdate('cascade');

		});

		Schema::create('profiles', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('cascade');
		
		});

		Schema::create('orders', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('cascade');
			$table->foreign('coupon_id')->onUpdate('cascade');

		});

		Schema::create('transactions_vouchers', function($table)
		{
		
			$table->foreign('voucher_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('transaction_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('payment_partner_id')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('vouchers', function($table)
		{
		
			$table->foreign('offer_option_id')->onUpdate('cascade');
			$table->foreign('order_id')->onUpdate('cascade');
		
		});

		Schema::create('transactions', function($table)
		{
		
			$table->foreign('order_id')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('payments_partners', function($table)
		{
		
			$table->foreign('partner_id')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('payment_id')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::create('destinies_sorts_of_destiny', function($table)
		{
		
			$table->foreign('destiny_id')->onUpdate('cascade');
			$table->foreign('sort_of_destiny_id')->onUpdate('cascade');
		
		});

		Schema::create('offers_tags', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('cascade');
			$table->foreign('tag_id')->onUpdate('cascade');
		
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::create('role_user', function($table)
		{

			$table->foreign('user_id')->onUpdate('restrict');
			$table->foreign('role_id')->onUpdate('restrict');

		});

		Schema::create('offers_included', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
			$table->foreign('included_id')->onUpdate('restrict');

		});

		Schema::create('comments', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
			$table->foreign('user_id')->onUpdate('restrict');

		});

		Schema::create('contracts', function($table)
		{
		
			$table->foreign('partner_id')->onUpdate('restrict');
			$table->foreign('consultant_id')->onDelete('restrict')->onUpdate('restrict');

		});

		Schema::create('contract_options', function($table)
		{
		
			$table->foreign('contract_id')->onUpdate('cascade');

		});

		Schema::create('offers', function($table)
		{
		
			$table->foreign('partner_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('category_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('genre_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('genre2_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('destiny_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('ngo_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('tell_us_id')->onDelete('restrict')->onUpdate('restrict');

		});

		Schema::create('offers_groups', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
			$table->foreign('group_id')->onUpdate('restrict');
		
		});

		Schema::create('offers_holidays', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
			$table->foreign('holiday_id')->onUpdate('restrict');
		
		});

		Schema::create('discount_coupons', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('restrict');
			$table->foreign('offer_id')->onUpdate('restrict');
		
		});

		Schema::create('offers_options', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');

		});

		Schema::create('offers_additional', function($table)
		{
		
			$table->foreign('offer_main_id')->onUpdate('restrict');
			$table->foreign('offer_additional_id')->onUpdate('restrict');
		
		});

		Schema::create('offers_images', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
		
		});

		Schema::create('permission_role', function($table)
		{
		
			$table->foreign('permission_id')->onUpdate('restrict');
			$table->foreign('role_id')->onUpdate('restrict');

		});

		Schema::create('profiles', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('restrict');
		
		});

		Schema::create('orders', function($table)
		{
		
			$table->foreign('user_id')->onUpdate('restrict');
			$table->foreign('coupon_id')->onUpdate('restrict');

		});

		Schema::create('transactions_vouchers', function($table)
		{
		
			$table->foreign('voucher_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('transaction_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('payment_partner_id')->onDelete('restrict')->onUpdate('restrict');

		});

		Schema::create('vouchers', function($table)
		{
		
			$table->foreign('offer_option_id')->onUpdate('restrict');
			$table->foreign('order_id')->onUpdate('restrict');
		
		});

		Schema::create('transactions', function($table)
		{
		
			$table->foreign('order_id')->onDelete('restrict')->onUpdate('restrict');

		});

		Schema::create('payments_partners', function($table)
		{
		
			$table->foreign('partner_id')->onDelete('restrict')->onUpdate('restrict');
			$table->foreign('payment_id')->onDelete('restrict')->onUpdate('restrict');

		});

		Schema::create('destinies_sorts_of_destiny', function($table)
		{
		
			$table->foreign('destiny_id')->onUpdate('restrict');
			$table->foreign('sort_of_destiny_id')->onUpdate('restrict');
		
		});

		Schema::create('offers_tags', function($table)
		{
		
			$table->foreign('offer_id')->onUpdate('restrict');
			$table->foreign('tag_id')->onUpdate('restrict');
		
		});
		
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	// public function up()
	// {
		
	// 	Schema::create('role_user', function($table)
	// 	{

	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
	// 		$table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade');

	// 	});

	// 	Schema::create('offers_included', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('included_id')->references('id')->on('included')->onUpdate('cascade');

	// 	});

	// 	Schema::create('comments', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');

	// 	});

	// 	Schema::create('contracts', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
	// 		$table->foreign('consultant_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

	// 	});

	// 	Schema::create('contract_options', function($table)
	// 	{
		
	// 		$table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('cascade');

	// 	});

	// 	Schema::create('offers', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('genre_id')->references('id')->on('genres')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('genre2_id')->references('id')->on('genres')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('destiny_id')->references('id')->on('destinies')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('ngo_id')->references('id')->on('ngos')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('tell_us_id')->references('id')->on('tell_us')->onUpdate('cascade')->onDelete('cascade');

	// 	});

	// 	Schema::create('offers_groups', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('group_id')->references('id')->on('groups')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('offers_holidays', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('holiday_id')->references('id')->on('holidays')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('discount_coupons', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('offers_options', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');

	// 	});

	// 	Schema::create('offers_additional', function($table)
	// 	{
		
	// 		$table->foreign('offer_main_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('offer_additional_id')->references('id')->on('offers_options')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('offers_images', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('permission_role', function($table)
	// 	{
		
	// 		$table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('cascade');
	// 		$table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade');

	// 	});

	// 	Schema::create('profiles', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('orders', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
	// 		$table->foreign('coupon_id')->references('id')->on('discount_coupons');

	// 	});

	// 	Schema::create('transactions_vouchers', function($table)
	// 	{
		
	// 		$table->foreign('voucher_id')->references('id')->on('vouchers')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('cascade')->onDelete('cascade');
	// 		$table->foreign('payment_partner_id')->references('id')->on('payments_partners')->onUpdate('cascade')->onDelete('cascade');

	// 	});

	// 	Schema::create('vouchers', function($table)
	// 	{
		
	// 		$table->foreign('offer_option_id')->references('id')->on('offers_options')->onUpdate('cascade');
	// 		$table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('transactions', function($table)
	// 	{
		
	// 		$table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');

	// 	});

	// 	Schema::create('payments_partners', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
	// 		$table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade');

	// 	});

	// 	Schema::create('destinies_sorts_of_destiny', function($table)
	// 	{
		
	// 		$table->foreign('destiny_id')->references('id')->on('destinies')->onUpdate('cascade');
	// 		$table->foreign('sort_of_destiny_id')->references('id')->on('sorts_of_destiny')->onUpdate('cascade');
		
	// 	});

	// 	Schema::create('offers_tags', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('cascade');
	// 		$table->foreign('tag_id')->references('id')->on('tags')->onUpdate('cascade');
		
	// 	});

	// }

	// *
	//  * Reverse the migrations.
	//  *
	//  * @return void
	 
	// public function down()
	// {
		
	// 	Schema::create('role_user', function($table)
	// 	{

	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');
	// 		$table->foreign('role_id')->references('id')->on('roles')->onUpdate('restrict');

	// 	});

	// 	Schema::create('offers_included', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('included_id')->references('id')->on('included')->onUpdate('restrict');

	// 	});

	// 	Schema::create('comments', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');

	// 	});

	// 	Schema::create('contracts', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
	// 		$table->foreign('consultant_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');

	// 	});

	// 	Schema::create('contract_options', function($table)
	// 	{
		
	// 		$table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('restrict');

	// 	});

	// 	Schema::create('offers', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('category_id')->references('id')->on('categories')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('genre_id')->references('id')->on('genres')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('genre2_id')->references('id')->on('genres')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('destiny_id')->references('id')->on('destinies')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('ngo_id')->references('id')->on('ngos')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('tell_us_id')->references('id')->on('tell_us')->onUpdate('restrict')->onDelete('restrict');

	// 	});

	// 	Schema::create('offers_groups', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('group_id')->references('id')->on('groups')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('offers_holidays', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('holiday_id')->references('id')->on('holidays')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('discount_coupons', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('offers_options', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');

	// 	});

	// 	Schema::create('offers_additional', function($table)
	// 	{
		
	// 		$table->foreign('offer_main_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('offer_additional_id')->references('id')->on('offers_options')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('offers_images', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('district');
		
	// 	});

	// 	Schema::create('permission_role', function($table)
	// 	{
		
	// 		$table->foreign('permission_id')->references('id')->on('permissions')->onUpdate('restrict');
	// 		$table->foreign('role_id')->references('id')->on('roles')->onUpdate('restrict');

	// 	});

	// 	Schema::create('profiles', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('orders', function($table)
	// 	{
		
	// 		$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict');
	// 		$table->foreign('coupon_id')->references('id')->on('discount_coupons');

	// 	});

	// 	Schema::create('transactions_vouchers', function($table)
	// 	{
		
	// 		$table->foreign('voucher_id')->references('id')->on('vouchers')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('transaction_id')->references('id')->on('transactions')->onUpdate('restrict')->onDelete('restrict');
	// 		$table->foreign('payment_partner_id')->references('id')->on('payments_partners')->onUpdate('restrict')->onDelete('restrict');

	// 	});

	// 	Schema::create('vouchers', function($table)
	// 	{
		
	// 		$table->foreign('offer_option_id')->references('id')->on('offers_options')->onUpdate('restrict');
	// 		$table->foreign('order_id')->references('id')->on('orders')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('transactions', function($table)
	// 	{
		
	// 		$table->foreign('order_id')->references('id')->on('orders')->onUpdate('restrict')->onDelete('restrict');

	// 	});

	// 	Schema::create('payments_partners', function($table)
	// 	{
		
	// 		$table->foreign('partner_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
	// 		$table->foreign('payment_id')->references('id')->on('payments')->onDelete('restrict')->onUpdate('restrict');

	// 	});

	// 	Schema::create('destinies_sorts_of_destiny', function($table)
	// 	{
		
	// 		$table->foreign('destiny_id')->references('id')->on('destinies')->onUpdate('restrict');
	// 		$table->foreign('sort_of_destiny_id')->references('id')->on('sorts_of_destiny')->onUpdate('restrict');
		
	// 	});

	// 	Schema::create('offers_tags', function($table)
	// 	{
		
	// 		$table->foreign('offer_id')->references('id')->on('offers')->onUpdate('restrict');
	// 		$table->foreign('tag_id')->references('id')->on('tags')->onUpdate('restrict');
		
	// 	});

	// }

}