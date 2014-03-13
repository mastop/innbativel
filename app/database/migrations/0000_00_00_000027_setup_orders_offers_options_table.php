<?php

use Illuminate\Database\Migrations\Migration;

class SetupOrdersOffersOptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

	  Schema::create('orders_offers_options', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('order_id')->unsigned()->index();
		$table->integer('offer_option_id')->unsigned()->index();
		$table->integer('qty')->nullable();

        /*
         * Foreign Keys
         */
		$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
		$table->foreign('offer_option_id')->references('id')->on('offers_options')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		DB::statement('SET foreign_key_checks = 0');
		DB::statement('SET UNIQUE_CHECKS=0');

		Schema::drop('orders_offers_options');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
