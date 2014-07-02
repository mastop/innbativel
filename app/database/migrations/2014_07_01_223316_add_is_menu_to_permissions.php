<?php

use Illuminate\Database\Migrations\Migration;

class AddIsMenuToPermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permissions', function($table)
        {
            $table->boolean('is_menu')->default(false)->after('description');
            $table->integer('display_order')->default(99)->after('is_menu');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permissions', function($table)
        {
            $table->dropColumn('is_menu');
            $table->dropColumn('display_order');
        });
	}

}