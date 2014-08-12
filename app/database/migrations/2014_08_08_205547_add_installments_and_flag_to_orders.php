<?php

use Illuminate\Database\Migrations\Migration;

class AddInstallmentsAndFlagToOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('orders', function($table)
        {
            $table->integer('installments')->default(1)->after('payment_terms');
            $table->string('flag')->nullable()->after('payment_terms');
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
            $table->dropColumn('installments');
            $table->dropColumn('flag');
        });
	}
}