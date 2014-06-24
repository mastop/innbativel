<?php

use Illuminate\Database\Migrations\Migration;

class DropOfferOldImgFromOffers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('offers', function($table)
        {
            $table->dropColumn('offer_old_img');
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
            $table->string('offer_old_img')->nullable();
        });
	}

}