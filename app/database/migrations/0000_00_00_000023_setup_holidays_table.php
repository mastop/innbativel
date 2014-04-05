<?php

use Illuminate\Database\Migrations\Migration;

class SetupHolidaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('holidays', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->string('title')->nullable();
		$table->integer('display_order')->default(99);
      });

      ////////////////////////////////////////////////////

      Schema::create('offers_holidays', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('offer_id')->unsigned()->index();
		$table->integer('holiday_id')->unsigned()->index();

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
		$table->foreign('holiday_id')->references('id')->on('holidays')->onDelete('cascade');
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

		Schema::drop('holidays');
		Schema::drop('offers_holidays');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
