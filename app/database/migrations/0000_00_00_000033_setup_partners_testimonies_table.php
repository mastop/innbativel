<?php

use Illuminate\Database\Migrations\Migration;

class SetupPartnersTestimoniesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('partners_testimonies', function($table)
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
		$table->string('sponsor')->nullable();
		$table->string('role')->nullable();
		$table->string('testimony')->nullable();
		$table->string('img')->nullable();
		$table->integer('display_order')->default(99);
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

		Schema::drop('partners_testimonies');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
