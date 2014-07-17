<?php

use Illuminate\Database\Migrations\Migration;

class RemoveDisplayMapOffers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('offers', function($table)
        {
            $table->dropColumn('display_map');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('offers', function($table)
        {
            $table->boolean('display_map')->default(false);
        });
	}

}