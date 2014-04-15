<?php

use Illuminate\Database\Migrations\Migration;

class SetupTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('transactions', function($table)
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
        $table->integer('payment_partner_id')->unsigned()->index();
        $table->enum('status', array('pagamento', 'cancelamento'))->default('pagamento');
        $table->decimal('total', 7, 2)->nullable();
        $table->decimal('credit_discount', 7, 2)->nullable();
        $table->decimal('coupon_discount', 7, 2)->nullable();

        /*
         * Foreign Keys
         */
        $table->foreign('order_id')->references('id')->on('orders'); // COM OU SEM "ON DELETE CASCATE"?
        $table->foreign('payment_partner_id')->references('id')->on('payments_partners'); // COM OU SEM "ON DELETE CASCATE"?

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

		Schema::drop('transactions');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
