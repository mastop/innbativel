<?php

use Illuminate\Database\Migrations\Migration;

class SetupOffersImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('offers_images', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('offer_id')->unsigned()->index();
		$table->string('url')->nullable();

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
      });
        /*
         * Valor de auto incremento inicial = 10001
         */
        $statement = "
                        ALTER TABLE offers_images AUTO_INCREMENT = 10001;
                    ";

        DB::unprepared($statement);
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

		Schema::drop('offers_images');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
