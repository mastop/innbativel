<?php

use Illuminate\Database\Migrations\Migration;

class SetupIncludedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('included', function($table)
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
		$table->string('description')->nullable();
		$table->string('icon')->nullable();

      });

      ////////////////////////////////////////////////////

      Schema::create('offers_included', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('offer_id')->unsigned()->index();
		$table->integer('included_id')->unsigned()->index();
		$table->integer('display_order')->default(99);

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
		$table->foreign('included_id')->references('id')->on('included')->onDelete('cascade');
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

		Schema::drop('included');
		Schema::drop('offers_included');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
