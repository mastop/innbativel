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
		$table->integer('category_id')->unsigned()->index();
		$table->integer('genre_id')->unsigned()->index()->nullable();
		$table->integer('genre2_id')->unsigned()->index()->nullable();
		$table->integer('destiny_id')->unsigned()->index();
		$table->integer('ngo_id')->unsigned()->index();
		$table->integer('tell_us_id')->unsigned()->index()->nullable();
		$table->string('title')->nullable();
		$table->string('subtitle')->nullable();
		$table->string('subsubtitle')->nullable(); // HTML
		$table->decimal('price_original', 7, 2)->nullable();
		$table->decimal('price_with_discount', 7, 2)->nullable();
        $table->tinyInteger('percent_off')->nullable();
		$table->text('rules')->nullable(); // HTML
		$table->text('features')->nullable(); // HTML
		$table->string('slug')->nullable();
		$table->dateTime('starts_on')->nullable();
		$table->dateTime('ends_on')->nullable();
		$table->string('cover_img')->nullable(); // URL
		$table->string('offer_old_img')->nullable(); // URL
		$table->string('newsletter_img')->nullable(); // URL
		$table->boolean('display_map')->default(false);
		$table->integer('display_order')->default(99); // ordem das ofertas na home, em categorias e em qualquer outro lugar
		$table->boolean('is_product')->default(false);
		$table->boolean('is_available')->default(true);
		$table->boolean('is_active')->default(true);

		/*
		 * Foreign Keys
		 */
		$table->foreign('partner_id')->references('id')->on('users'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('category_id')->references('id')->on('categories'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('genre_id')->references('id')->on('genres'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('genre2_id')->references('id')->on('genres'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('destiny_id')->references('id')->on('destinies'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('ngo_id')->references('id')->on('ngos'); // COM OU SEM "ON DELETE CASCATE"?
		$table->foreign('tell_us_id')->references('id')->on('tell_us'); // COM OU SEM "ON DELETE CASCATE"?
		
		/*
		 * Time Stamps
		 */
		$table->timestamps();

        /*
         * Soft Delete
         */
        $table->softDeletes();
	  });
        /*
         * Valor de auto incremento inicial = 2001
         */
        $statement = "
                        ALTER TABLE offers AUTO_INCREMENT = 2001;
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

		Schema::drop('offers');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
	}

}
