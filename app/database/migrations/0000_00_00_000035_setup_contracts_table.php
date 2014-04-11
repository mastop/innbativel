<?php

use Illuminate\Database\Migrations\Migration;

class SetupContractsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('contracts', function($table)
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
		$table->integer('consultant_id')->unsigned()->index();
		$table->string('company_name')->nullable(); //razao_social
		$table->string('cnpj')->nullable();
		$table->string('trading_name')->nullable();	//nome_fantasia
		$table->string('address')->nullable();
		$table->string('complement')->nullable();
		$table->string('neighborhood')->nullable();
		$table->string('zip')->nullable();
		$table->string('city')->nullable();
		$table->string('state')->nullable();
		$table->string('agent1_name')->nullable();
		$table->string('agent1_cpf')->nullable();
		$table->string('agent1_telephone')->nullable();
		$table->string('agent2_name')->nullable();
		$table->string('agent2_cpf')->nullable();
		$table->string('agent2_telephone')->nullable();
		$table->string('bank_name')->nullable();
		$table->integer('bank_number')->nullable();
		$table->string('bank_holder')->nullable();
		$table->string('bank_agency')->nullable();
		$table->string('bank_account')->nullable();
		$table->string('bank_cpf_cnpj')->nullable();
		$table->string('bank_financial_email')->nullable();
		$table->boolean('is_signed')->default(false);
		$table->boolean('is_sent')->default(false);
		$table->date('initial_term')->nullable(); // PRAZO INICIAL
		$table->date('final_term')->nullable(); // PRAZO FINAL
		$table->string('restriction')->nullable();
		$table->string('has_scheduling')->nullable();
		$table->string('sched_contact')->nullable();
		$table->date('sched_max_date')->nullable();
		$table->string('sched_dates')->nullable();
		$table->string('sched_min_antecedence')->nullable();
		$table->integer('n_people')->nullable();
		$table->text('features')->nullable();
		$table->text('rules')->nullable();
		$table->text('clauses')->nullable();
		$table->string('ip')->nullable();
		$table->datetime('signed_at')->nullable();

		$table->foreign('partner_id')->references('id')->on('users');
		$table->foreign('consultant_id')->references('id')->on('users');

        /*
         * Time Stamps
         */
        $table->timestamps();

      });

      Schema::create('contract_options', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('contract_id')->unsigned()->index();
		$table->string('title')->nullable();
		$table->integer('price_original')->nullable();
		$table->integer('price_with_discount')->nullable();
		$table->integer('percent_off')->nullable();
		$table->integer('transfer')->nullable();
		$table->integer('max_qty')->nullable();

		$table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

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

		Schema::drop('contracts');
		Schema::drop('contract_options');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
