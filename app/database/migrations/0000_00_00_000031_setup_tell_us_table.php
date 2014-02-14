<?php

use Illuminate\Database\Migrations\Migration;

class SetupTellUsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('tell_us', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->string('name')->nullable();
		$table->string('destiny')->nullable();
		$table->string('partner_name')->nullable();
		$table->dateTime('travel_date')->nullable();
		$table->string('depoiment')->nullable();
		$table->string('img')->nullable();
		$table->integer('display_order')->default(99);

        /*
         * Time Stamps
         */
        $table->timestamps();
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

		Schema::drop('tell_us');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
