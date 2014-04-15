<?php

use Illuminate\Database\Migrations\Migration;

class SetupPaymentsPartnersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('payments_partners', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
        $table->integer('partner_id')->unsigned()->index();
        $table->integer('payment_id')->unsigned()->index();
        $table->decimal('total', 8, 2)->nullable();
        $table->dateTime('paid_on')->nullable();

        /*
         * Foreign Keys
         */
        $table->foreign('partner_id')->references('id')->on('users'); // COM OU SEM "ON DELETE CASCATE"?
        $table->foreign('payment_id')->references('id')->on('payments'); // COM OU SEM "ON DELETE CASCATE"?
        
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

		Schema::drop('payments_partners');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
