<?php

use Illuminate\Database\Migrations\Migration;

class AddShortTitleOffers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('offers', function($table)
        {
            $table->string('short_title')->nullable()->after('title');
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
            $table->dropColumn('short_title');
        });
	}

}