<?php

use Illuminate\Database\Migrations\Migration;

class SetupRoleUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('role_user', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('user_id')->unsigned()->index();
		$table->integer('role_id')->unsigned()->index();

        /*
         * Foreign Keys
         */
		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');


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

		Schema::drop('role_user');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
