<?php

use Illuminate\Database\Migrations\Migration;

class SetupProfilesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('profiles', function($table)
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
        $table->integer('facebook_id')->nullable();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->date('birthday')->nullable();
        $table->string('cpf')->nullable();
        $table->string('telephone')->nullable();
        $table->string('telephone2')->nullable();
        $table->string('img')->nullable();
        $table->string('credit')->nullable();
        $table->string('city')->index()->nullable();
        $table->string('state')->index()->nullable();
        $table->string('country')->nullable();
        $table->string('street')->nullable();
        $table->string('number')->nullable();
        $table->string('complement')->nullable();
        $table->string('neighborhood')->nullable();
        $table->string('zip')->nullable();
        $table->string('company_name')->nullable();
        $table->string('cnpj')->nullable();
        $table->string('coordinates')->nullable();
        $table->string('site')->nullable();
        $table->string('ip')->nullable();

        /*
         * Foreign Keys
         */
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

      Schema::drop('profiles');

      DB::statement('SET foreign_key_checks = 1');
      DB::statement('SET UNIQUE_CHECKS=1');
    }

}
