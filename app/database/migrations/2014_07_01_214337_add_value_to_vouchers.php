<?php

use Illuminate\Database\Migrations\Migration;

class AddValueToVouchers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vouchers', function($table)
        {
            $table->decimal('price', 7, 2)->nullable()->after('offer_option_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vouchers', function($table)
        {
            $table->dropColumn('price');
        });
	}

}