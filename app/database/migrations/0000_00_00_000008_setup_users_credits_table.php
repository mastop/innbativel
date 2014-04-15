<?php

use Illuminate\Database\Migrations\Migration;

class SetupUsersCreditsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('users_credits', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
        $table->integer('user_id')->unsigned()->index();
		$table->integer('new_user_id')->unsigned()->index();
		$table->decimal('value', 7, 2)->index();

        /*
         * Foreign Keys
         */
		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->foreign('new_user_id')->references('id')->on('users')->onDelete('cascade');

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

		Schema::drop('users_credits');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
