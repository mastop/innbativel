<?php

use Illuminate\Database\Migrations\Migration;

class DiscountCouponSoftDelete extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('discount_coupons', function($table)
		{

			/*
	         * Soft Delete
	         */
	        $table->softDeletes();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('discount_coupons', function($table)
		{

			$table->dropColumn('deleted_at');

		});
	}

}