<?php

use Illuminate\Database\Migrations\Migration;

class SetupPaymentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('payments', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
        $table->dateTime('sales_from');
        $table->dateTime('sales_to');
        $table->date('date');
        $table->string('cronjob')->nullable();
        
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

		Schema::drop('payments');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
