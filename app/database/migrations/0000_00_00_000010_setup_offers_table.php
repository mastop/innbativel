<?php

use Illuminate\Database\Migrations\Migration;

class SetupOffersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('offers', function($table)
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
        $table->integer('ngo_id')->unsigned()->index();
        $table->integer('genre_id')->unsigned()->index();
		$table->string('title')->nullable();
		$table->string('subtitle')->nullable();
		$table->string('destiny')->nullable();
		$table->text('description')->nullable(); // HTML
		$table->string('event')->nullable();
		$table->string('saveme_title')->nullable();
		$table->string('slug')->nullable();
		$table->text('general_rules')->nullable(); // HTML
		$table->text('features')->nullable(); // HTML
		$table->dateTime('starts_on')->nullable();
		$table->dateTime('ends_on')->nullable();
		$table->string('cover_img')->nullable(); // URL
		$table->string('offer_old_img')->nullable(); // URL
		$table->string('newsletter_img')->nullable(); // URL
		$table->string('saveme_img')->nullable(); // URL
		$table->string('video')->nullable(); // URL
		$table->boolean('in_pre_booking')->default(false);
		$table->string('display_order')->default(99); // ordem das ofertas na home, em categorias e em qualquer outro lugar
		$table->integer('pre_booking_order')->default(99);

        /*
         * Foreign Keys
         */
		$table->foreign('partner_id')->references('id')->on('users'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('ngo_id')->references('id')->on('ngos'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('genre_id')->references('id')->on('genres'); // COM OU SEM "ON DELETE CASCATE"?

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

		Schema::drop('offers');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
