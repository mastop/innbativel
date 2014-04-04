<?php

use Illuminate\Database\Migrations\Migration;

class SetupSortsOfDestinyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('sorts_of_destiny', function($table)
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
		$table->boolean('is_active')->default(true);
      });

      ////////////////////////////////////////////////////

      Schema::create('destinies_sorts_of_destiny', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('destiny_id')->unsigned()->index();
		$table->integer('sort_of_destiny_id')->unsigned()->index();

        /*
         * Foreign Keys
         */
		$table->foreign('destiny_id')->references('id')->on('destinies')->onDelete('cascade');
		$table->foreign('sort_of_destiny_id')->references('id')->on('sorts_of_destiny')->onDelete('cascade');
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

		Schema::drop('sorts_of_destiny');
		Schema::drop('destinies_sorts_of_destiny');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
