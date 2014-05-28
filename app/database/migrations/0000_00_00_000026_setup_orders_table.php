<?php

use Illuminate\Database\Migrations\Migration;

class SetupOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('orders', function($table)
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
		$table->string('braspag_order_id')->nullable();
		$table->string('antifraud_id')->nullable();
		$table->string('braspag_id')->nullable();
		$table->integer('coupon_id')->unsigned()->index()->nullable();
		$table->enum('status', array('pendente', 'revisao', 'pago', 'cancelado', 'convercao_creditos', 'cancelado_parcial'))->default('pendente');
		$table->integer('first_digits_card')->nullable();
		$table->integer('holder_card')->nullable();
		$table->decimal('donation', 4, 2)->default(0);
        $table->decimal('total', 9, 2)->nullable();
        $table->decimal('credit_discount', 9, 2)->nullable();
		$table->decimal('card_boletus_rate', 12, 12)->default(0);
        $table->decimal('antecipation_rate', 12, 12)->default(0);
        $table->decimal('interest_rate', 12, 12)->default(0); // TAXA DE JUROS
		$table->string('cpf')->nullable();
		$table->string('telephone')->nullable();
		$table->boolean('is_gift')->default(false);
		$table->string('payment_terms')->nullable();
		$table->string('boleto')->nullable();
		$table->string('capture_date')->nullable();
		$table->text('history')->nullable();

        /*
         * Foreign Keys
         */
		$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		$table->foreign('coupon_id')->references('id')->on('discount_coupons');

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

		Schema::drop('orders');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
