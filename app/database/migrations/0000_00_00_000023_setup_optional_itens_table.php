<?php

use Illuminate\Database\Migrations\Migration;

class SetupOptionalItensTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('optional_itens', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->string('icon')->nullable();
		$table->string('title')->nullable();
        $table->integer('price')->nullable();
        $table->integer('display_order')->nullable();
      });

      ////////////////////////////////////////////////////

      Schema::create('offers_optional_itens', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('offer_id')->unsigned()->index();
		$table->integer('optional_iten_id')->unsigned()->index();

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
		$table->foreign('optional_iten_id')->references('id')->on('optional_itens')->onDelete('cascade');
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

		Schema::drop('optional_itens');
		Schema::drop('offers_optional_itens');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
