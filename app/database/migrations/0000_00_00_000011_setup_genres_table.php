<?php

use Illuminate\Database\Migrations\Migration;

class SetupGenresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  // Creates the users table
	  Schema::create('genres', function($table)
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
		$table->string('icon')->nullable();
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

		Schema::drop('genres');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
	}

}
