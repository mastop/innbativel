<?php

use Illuminate\Database\Migrations\Migration;

class SetupTransactionsVouchersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('transactions_vouchers', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
        $table->integer('voucher_id')->unsigned()->index();
        $table->integer('payment_partner_id')->unsigned()->index()->nullable();
        $table->enum('status', array('pagamento', 'cancelamento'))->default('pagamento');

        /*
         * Foreign Keys
         */
        $table->foreign('voucher_id')->references('id')->on('vouchers'); // COM OU SEM "ON DELETE CASCATE"?
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

		Schema::drop('transactions_vouchers');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
