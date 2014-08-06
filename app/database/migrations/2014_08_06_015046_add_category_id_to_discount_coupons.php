<?php

use Illuminate\Database\Migrations\Migration;

class AddCategoryIdToDiscountCoupons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('discount_coupons', function($table)
        {
            $table->integer('category_id')->unsigned()->index()->nullable()->after('offer_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('set null')->onUpdate('cascade');
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
            $table->dropColumn('category_id');
        });
	}

}