<?php

use Illuminate\Database\Migrations\Migration;

class SetupFaqsGroupsTable extends Migration {

	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

		Schema::create('faqs_groups', function($table)
		{
			/*
			 * Storage Engines
			 */
			$table->engine = 'InnoDB';

			/*
			 * Fields
			 */
			$table->increments('id');
			$table->string('title');
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

        Schema::drop('faqs_groups');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}