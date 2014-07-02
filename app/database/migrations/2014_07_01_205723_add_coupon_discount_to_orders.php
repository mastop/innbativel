<?php

use Illuminate\Database\Migrations\Migration;

class AddCouponDiscountToOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('orders', function($table)
        {
            $table->decimal('coupon_discount', 9, 2)->nullable()->after('credit_discount');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('orders', function($table)
        {
            $table->dropColumn('coupon_discount');
        });
	}

}