<?php

use Illuminate\Database\Migrations\Migration;

class SetupGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  // Creates the users table
	  Schema::create('groups', function($table)
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
		$table->string('url')->nullable();
		$table->integer('display_order')->default(99);

	  });

	  ////////////////////////////////////////////////////

	  Schema::create('offers_groups', function($table)
	  {
		/*
		 * Storage Engines
		 */
		$table->engine = 'InnoDB';

		/*
		 * Fields
		 */
		$table->integer('offer_id')->unsigned()->index();
		$table->integer('group_id')->unsigned()->index();
		$table->integer('display_order')->nullable();

		/*
		 * Foreign Keys
		 */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
		$table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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

		Schema::drop('groups');
		Schema::drop('offers_groups');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
	}

}
