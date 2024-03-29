<?php

use Illuminate\Database\Migrations\Migration;

class AddIsActiveToOffersOptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('offers_options', function($table)
        {
            $table->boolean('is_active')->default(true);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('offers_options', function($table)
        {
            $table->dropColumn('is_active');
        });
	}

}