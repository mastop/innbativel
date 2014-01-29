<?php

use Illuminate\Database\Migrations\Migration;

class SetupUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('users', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->string('username', 30)->unique()->index();
		$table->string('password', 60)->index();
		$table->string('salt', 32);
		$table->string('email', 255)->unique()->index();
		$table->boolean('verified')->default(1);
		$table->boolean('disabled')->default(0);

        /*
         * Soft Deletes
         */
        $table->softDeletes();

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

		Schema::drop('users');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
