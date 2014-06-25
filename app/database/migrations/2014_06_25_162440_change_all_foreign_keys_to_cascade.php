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
		
		Schema::table('role_user', function($table)
		{

			// $table->dropForeign('contracts_partner_id_foreign');
			$table->dropForeign('role_user_user_id_foreign');
			$table->dropForeign('role_user_role_id_foreign');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade'); // significa que se eu deletar um user, esse role_user vai ser deletado
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('offers_included', function($table)
		{

			$table->dropForeign('offers_included_offer_id_foreign');
			$table->dropForeign('offers_included_included_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('included_id')->references('id')->on('included')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('comments', function($table)
		{

			$table->dropForeign('comments_offer_id_foreign');
			$table->dropForeign('comments_user_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('contracts', function($table)
		{

			DB::statement('ALTER TABLE contracts CHANGE partner_id partner_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE contracts CHANGE consultant_id consultant_id INT(10) UNSIGNED NULL');

			$table->dropForeign('contracts_partner_id_foreign');
			$table->dropForeign('contracts_consultant_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade'); // significa que se eu deletar um parceiro (usuario), NAO vai deletar o contrato, vai apenas deixar sem parceiro
			$table->foreign('consultant_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('contract_options', function($table)
		{
			$table->dropForeign('contract_options_contract_id_foreign');
		
			$table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('offers', function($table)
		{

			DB::statement('ALTER TABLE offers CHANGE partner_id partner_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE category_id category_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE genre_id genre_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE genre2_id genre2_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE destiny_id destiny_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE tell_us_id tell_us_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE ngo_id ngo_id INT(10) UNSIGNED NULL');

			$table->dropForeign('offers_partner_id_foreign');
            $table->dropForeign('offers_category_id_foreign');
            $table->dropForeign('offers_genre_id_foreign');
            $table->dropForeign('offers_genre2_id_foreign');
            $table->dropForeign('offers_destiny_id_foreign');
            $table->dropForeign('offers_ngo_id_foreign');
            $table->dropForeign('offers_tell_us_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('genre2_id')->references('id')->on('genres')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('destiny_id')->references('id')->on('destinies')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('ngo_id')->references('id')->on('ngos')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('tell_us_id')->references('id')->on('tell_us')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('offers_groups', function($table)
		{

			$table->dropForeign('offers_groups_offer_id_foreign');
			$table->dropForeign('offers_groups_group_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('offers_holidays', function($table)
		{

			$table->dropForeign('offers_holidays_offer_id_foreign');
			$table->dropForeign('offers_holidays_holiday_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('discount_coupons', function($table)
		{

			DB::statement('ALTER TABLE discount_coupons CHANGE user_id user_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE discount_coupons CHANGE offer_id offer_id INT(10) UNSIGNED NULL');

			$table->dropForeign('discount_coupons_user_id_foreign');
			$table->dropForeign('discount_coupons_offer_id_foreign');
		
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('set null')->onUpdate('cascade');
		
		});

		Schema::table('offers_options', function($table)
		{

			$table->dropForeign('offers_options_offer_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('offers_additional', function($table)
		{

			$table->dropForeign('offers_additional_offer_main_id_foreign');
			$table->dropForeign('offers_additional_offer_additional_id_foreign');
		
			$table->foreign('offer_main_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('offer_additional_id')->references('id')->on('offers_options')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('offers_images', function($table)
		{

			$table->dropForeign('offers_images_offer_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('permission_role', function($table)
		{

			$table->dropForeign('permission_role_permission_id_foreign');
			$table->dropForeign('permission_role_role_id_foreign');
		
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade')->onUpdate('cascade');

		});

		Schema::table('profiles', function($table)
		{

			$table->dropForeign('profiles_user_id_foreign');
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('orders', function($table)
		{

			DB::statement('ALTER TABLE orders CHANGE user_id user_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE orders CHANGE coupon_id coupon_id INT(10) UNSIGNED NULL');

			$table->dropForeign('orders_user_id_foreign');
			$table->dropForeign('orders_coupon_id_foreign');
		
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('coupon_id')->references('id')->on('discount_coupons')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('transactions_vouchers', function($table)
		{
			DB::statement('ALTER TABLE transactions_vouchers CHANGE voucher_id voucher_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE transactions_vouchers CHANGE transaction_id transaction_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE transactions_vouchers CHANGE payment_partner_id payment_partner_id INT(10) UNSIGNED NULL');

			$table->dropForeign('transactions_vouchers_voucher_id_foreign');
			$table->dropForeign('transactions_vouchers_transaction_id_foreign');
			$table->dropForeign('transactions_vouchers_payment_partner_id_foreign');
		
			$table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('payment_partner_id')->references('id')->on('payments_partners')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('vouchers', function($table)
		{

			DB::statement('ALTER TABLE vouchers CHANGE offer_option_id offer_option_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE vouchers CHANGE order_id order_id INT(10) UNSIGNED NULL');

			$table->dropForeign('vouchers_offer_option_id_foreign');
			$table->dropForeign('vouchers_order_id_foreign');
		
			$table->foreign('offer_option_id')->references('id')->on('offers_options')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('set null')->onUpdate('cascade');
		
		});

		Schema::table('transactions', function($table)
		{

			DB::statement('ALTER TABLE transactions CHANGE order_id order_id INT(10) UNSIGNED NULL');

			$table->dropForeign('transactions_order_id_foreign');
		
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('payments_partners', function($table)
		{

			DB::statement('ALTER TABLE payments_partners CHANGE partner_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE payments_partners CHANGE payment_id INT(10) UNSIGNED NULL');

			$table->dropForeign('payments_partners_partner_id_foreign');
			$table->dropForeign('payments_partners_payment_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
			$table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null')->onUpdate('cascade');

		});

		Schema::table('destinies_sorts_of_destiny', function($table)
		{

			$table->dropForeign('destinies_sorts_of_destiny_destiny_id_foreign');
			$table->dropForeign('destinies_sorts_of_destiny_sort_of_destiny_id_foreign');
		
			$table->foreign('destiny_id')->references('id')->on('destinies')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('sort_of_destiny_id')->references('id')->on('sorts_of_destiny')->onDelete('cascade')->onUpdate('cascade');
		
		});

		Schema::table('offers_tags', function($table)
		{

			$table->dropForeign('offers_tags_offer_id_foreign');
			$table->dropForeign('offers_tags_tag_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
		
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('role_user', function($table)
		{

			$table->dropForeign('role_user_user_id_foreign');
			$table->dropForeign('role_user_role_id_foreign');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

		});

		Schema::table('offers_included', function($table)
		{

			$table->dropForeign('offers_included_offer_id_foreign');
			$table->dropForeign('offers_included_included_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('included_id')->references('id')->on('included')->onDelete('cascade');

		});

		Schema::table('comments', function($table)
		{

			$table->dropForeign('comments_offer_id_foreign');
			$table->dropForeign('comments_user_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

		});

		Schema::table('contracts', function($table)
		{

			DB::statement('ALTER TABLE contracts CHANGE partner_id partner_id INT(10) UNSIGNED');
			DB::statement('ALTER TABLE contracts CHANGE consultant_id consultant_id INT(10) UNSIGNED');

			$table->dropForeign('contracts_partner_id_foreign');
			$table->dropForeign('contracts_consultant_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users');
			$table->foreign('consultant_id')->references('id')->on('users');

		});

		Schema::table('contract_options', function($table)
		{

			$table->dropForeign('contract_options_contract_id_foreign');
		
			$table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

		});

		Schema::table('offers', function($table)
		{

			DB::statement('ALTER TABLE offers CHANGE partner_id partner_id INT(10) UNSIGNED');
            DB::statement('ALTER TABLE offers CHANGE category_id category_id INT(10) UNSIGNED');
            DB::statement('ALTER TABLE offers CHANGE genre_id genre_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE genre2_id genre2_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE destiny_id destiny_id INT(10) UNSIGNED');
            DB::statement('ALTER TABLE offers CHANGE tell_us_id tell_us_id INT(10) UNSIGNED NULL');
            DB::statement('ALTER TABLE offers CHANGE ngo_id ngo_id INT(10) UNSIGNED');

			$table->dropForeign('offers_partner_id_foreign');
            $table->dropForeign('offers_category_id_foreign');
            $table->dropForeign('offers_genre_id_foreign');
            $table->dropForeign('offers_genre2_id_foreign');
            $table->dropForeign('offers_destiny_id_foreign');
            $table->dropForeign('offers_ngo_id_foreign');
            $table->dropForeign('offers_tell_us_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users');
			$table->foreign('category_id')->references('id')->on('categories');
			$table->foreign('genre_id')->references('id')->on('genres');
			$table->foreign('genre2_id')->references('id')->on('genres');
			$table->foreign('destiny_id')->references('id')->on('destinies');
			$table->foreign('ngo_id')->references('id')->on('ngos');
			$table->foreign('tell_us_id')->references('id')->on('tell_us');

		});

		Schema::table('offers_groups', function($table)
		{

			$table->dropForeign('offers_groups_offer_id_foreign');
			$table->dropForeign('offers_groups_group_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
		
		});

		Schema::table('offers_holidays', function($table)
		{

			$table->dropForeign('offers_holidays_offer_id_foreign');
			$table->dropForeign('offers_holidays_holiday_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade');
		
		});

		Schema::table('discount_coupons', function($table)
		{

			DB::statement('ALTER TABLE discount_coupons CHANGE user_id user_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE discount_coupons CHANGE offer_id offer_id INT(10) UNSIGNED NULL');

			$table->dropForeign('discount_coupons_user_id_foreign');
			$table->dropForeign('discount_coupons_offer_id_foreign');
		
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
		
		});

		Schema::table('offers_options', function($table)
		{

			$table->dropForeign('offers_options_offer_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');

		});

		Schema::table('offers_additional', function($table)
		{

			$table->dropForeign('offers_additional_offer_main_id_foreign');
			$table->dropForeign('offers_additional_offer_additional_id_foreign');
		
			$table->foreign('offer_main_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('offer_additional_id')->references('id')->on('offers_options')->onDelete('cascade');
		
		});

		Schema::table('offers_images', function($table)
		{

			$table->dropForeign('offers_images_offer_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('district');
		
		});

		Schema::table('permission_role', function($table)
		{

			$table->dropForeign('permission_role_permission_id_foreign');
			$table->dropForeign('permission_role_role_id_foreign');
		
			$table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

		});

		Schema::table('profiles', function($table)
		{

			$table->dropForeign('profiles_user_id_foreign');
		
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		
		});

		Schema::table('orders', function($table)
		{

			DB::statement('ALTER TABLE orders CHANGE user_id user_id INT(10) UNSIGNED');
			DB::statement('ALTER TABLE orders CHANGE coupon_id coupon_id INT(10) UNSIGNED NULL');

			$table->dropForeign('orders_user_id_foreign');
			$table->dropForeign('orders_coupon_id_foreign');
		
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('coupon_id')->references('id')->on('discount_coupons');

		});

		Schema::table('transactions_vouchers', function($table)
		{

			DB::statement('ALTER TABLE transactions_vouchers CHANGE voucher_id voucher_id INT(10) UNSIGNED');
			DB::statement('ALTER TABLE transactions_vouchers CHANGE transaction_id transaction_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE transactions_vouchers CHANGE payment_partner_id payment_partner_id INT(10) UNSIGNED NULL');

			$table->dropForeign('transactions_vouchers_voucher_id_foreign');
			$table->dropForeign('transactions_vouchers_transaction_id_foreign');
			$table->dropForeign('transactions_vouchers_payment_partner_id_foreign');
		
			$table->foreign('voucher_id')->references('id')->on('vouchers');
			$table->foreign('transaction_id')->references('id')->on('transactions');
			$table->foreign('payment_partner_id')->references('id')->on('payments_partners');

		});

		Schema::table('vouchers', function($table)
		{

			DB::statement('ALTER TABLE vouchers CHANGE offer_option_id offer_option_id INT(10) UNSIGNED');
			DB::statement('ALTER TABLE vouchers CHANGE order_id order_id INT(10) UNSIGNED');

			$table->dropForeign('vouchers_offer_option_id_foreign');
			$table->dropForeign('vouchers_order_id_foreign');
		
			$table->foreign('offer_option_id')->references('id')->on('offers_options')->onDelete('cascade');
			$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
		
		});

		Schema::table('transactions', function($table)
		{

			DB::statement('ALTER TABLE transactions CHANGE order_id order_id INT(10) UNSIGNED');

			$table->dropForeign('transactions_order_id_foreign');
		
			$table->foreign('order_id')->references('id')->on('orders');

		});

		Schema::table('payments_partners', function($table)
		{

			DB::statement('ALTER TABLE payments_partners CHANGE partner_id INT(10) UNSIGNED NULL');
			DB::statement('ALTER TABLE payments_partners CHANGE payment_id INT(10) UNSIGNED NULL');

			$table->dropForeign('payments_partners_partner_id_foreign');
			$table->dropForeign('payments_partners_payment_id_foreign');
		
			$table->foreign('partner_id')->references('id')->on('users');
			$table->foreign('payment_id')->references('id')->on('payments');

		});

		Schema::table('destinies_sorts_of_destiny', function($table)
		{

			$table->dropForeign('destinies_sorts_of_destiny_destiny_id_foreign');
			$table->dropForeign('destinies_sorts_of_destiny_sort_of_destiny_id_foreign');
		
			$table->foreign('destiny_id')->references('id')->on('destinies')->onDelete('cascade');
			$table->foreign('sort_of_destiny_id')->references('id')->on('sorts_of_destiny')->onDelete('cascade');
		
		});

		Schema::table('offers_tags', function($table)
		{

			$table->dropForeign('offers_tags_offer_id_foreign');
			$table->dropForeign('offers_tags_tag_id_foreign');
		
			$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
			$table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
		
		});

	}

}