<?php

use Illuminate\Database\Migrations\Migration;

class SetupDiscountCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('discount_coupons', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields

         if user_id is not null then qty = 1 automatically and only 1 specific user (user_id) can use it
if offer_id is not null then it can be used only for an specific offer (offer_id)
         */
		$table->increments('id');
		$table->integer('user_id')->unsigned()->index()->nullable();
		$table->integer('offer_id')->unsigned()->index()->nullable();
		$table->string('display_code')->nullable();
		$table->integer('value')->nullable();
		$table->integer('qty')->nullable();
		$table->integer('qty_used')->nullable();
		$table->dateTime('starts_on')->nullable();
		$table->dateTime('ends_on')->nullable();

        /*
         * Foreign Keys
         */
		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
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

		Schema::drop('discount_coupons');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
