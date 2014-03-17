<?php

use Illuminate\Database\Migrations\Migration;

class SetupSubcategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Creates the users table
      Schema::create('subcategories', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->increments('id');
		$table->integer('category_id')->unsigned()->index();
		$table->string('title')->nullable();
		$table->integer('is_active')->default(1);
		$table->integer('display_order')->default(99);

		$table->foreign('category_id')->references('id')->on('categories');
      });

      ////////////////////////////////////////////////////

      Schema::create('offers_subcategories', function($table)
      {
        /*
         * Storage Engines
         */
        $table->engine = 'InnoDB';

        /*
         * Fields
         */
		$table->integer('offer_id')->unsigned()->index();
		$table->integer('subcategory_id')->unsigned()->index();

        /*
         * Foreign Keys
         */
		$table->foreign('offer_id')->references('id')->on('offers');
		$table->foreign('subcategory_id')->references('id')->on('subcategories');
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

		Schema::drop('subcategories');
		Schema::drop('offers_subcategories');

		DB::statement('SET foreign_key_checks = 1');
		DB::statement('SET UNIQUE_CHECKS=1');
    }

}
