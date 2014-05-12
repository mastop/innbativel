<?php

use Illuminate\Database\Migrations\Migration;

class SetupVouchersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('vouchers', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('order_id')->unsigned()->index();
        $table->integer('offer_option_id')->unsigned()->index();
        $table->decimal('subtotal', 7, 2)->nullable();
        $table->enum('status', array('pendente', 'pago', 'cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'))->default('pendente');
		$table->boolean('used')->default(false);
		$table->string('display_code')->nullable();
		$table->string('name')->nullable();
		$table->string('email')->nullable();
        $table->string('tracking_code')->nullable();

        /*
         * Foreign Keys
         */
		$table->foreign('offer_option_id')->references('id')->on('offers_options')->onDelete('cascade');
		$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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

		Schema::drop('vouchers');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
