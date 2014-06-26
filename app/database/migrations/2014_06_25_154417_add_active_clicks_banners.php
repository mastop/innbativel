<?php

use Illuminate\Database\Migrations\Migration;

class AddActiveClicksBanners extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // Adiciona colunas is_active e clicks em banners
        Schema::table('banners', function($table)
        {
            $table->integer('clicks')->default(0);
            $table->boolean('is_active')->default(true);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        // Remove colunas is_active e clicks de banners
        Schema::table('banners', function($table)
        {
            $table->dropColumn('is_active', 'clicks');
        });
	}

}