<?php

use Illuminate\Database\Migrations\Migration;

class AddSoldPopupFeaturesOffers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Adiciona colunas sold e popup_features e remove subsubtitle em offers
        Schema::table('offers', function($table)
        {
            $table->integer('sold')->default(0)->after('is_active');
            $table->text('popup_features')->nullable()->after('features');
            $table->dropColumn('subsubtitle');
        });
        // Remove max_qty_per_buyer de offers_options
        Schema::table('offers_options', function($table)
        {
            $table->dropColumn('max_qty_per_buyer');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        // Remove colunas sold e popup_features e adiciona subsubtitle em offers
        Schema::table('offers', function($table)
        {
            $table->string('subsubtitle')->nullable()->after('subtitle');
            $table->dropColumn('sold', 'popup_features');
        });
        // Adiciona max_qty_per_buyer em offers_options
        Schema::table('offers_options', function($table)
        {
            $table->integer('max_qty_per_buyer')->nullable()->after('max_qty');
        });
	}

}