<?php

use Illuminate\Database\Migrations\Migration;

class SetupOffersOptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('offers_options', function($table)
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
		$table->string('title')->nullable();
		$table->string('subtitle')->nullable();
		$table->decimal('price_original', 7, 2)->nullable();
        $table->decimal('price_with_discount', 7, 2)->nullable();
		$table->decimal('transfer', 7, 2)->nullable();
		$table->integer('min_qty')->nullable();
		$table->integer('max_qty')->nullable();
		$table->integer('max_qty_per_buyer')->nullable();
        $table->tinyInteger('percent_off')->nullable();
		$table->dateTime('voucher_validity_start')->nullable();
		$table->dateTime('voucher_validity_end')->nullable();
		$table->integer('display_order')->default(99); // ordem da opções na página da oferta

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');

          /*
           * Soft Delete
           */
        $table->softDeletes();
      });

        /*
         * Valor de auto incremento inicial = 3001
         */
        $statement = "
                        ALTER TABLE offers_options AUTO_INCREMENT = 3001;
                    ";

        DB::unprepared($statement);

		// TABELA PIVOT (MANY TO MANY) ENTRE "OFERTAS" (PRODUTOS COMPOSTOS)
      Schema::create('offers_additional', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('offer_main_id')->unsigned()->index();
		$table->integer('offer_additional_id')->unsigned()->index();
        $table->integer('display_order')->default(99);
        /*
         * Foreign Keys
         */
		$table->foreign('offer_main_id')->references('id')->on('offers')->onDelete('cascade');
		$table->foreign('offer_additional_id')->references('id')->on('offers_options')->onDelete('cascade');
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

		Schema::drop('offers_options');
		Schema::drop('offers_additional');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
