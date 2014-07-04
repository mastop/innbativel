<?php

use Illuminate\Database\Migrations\Migration;

class AddMenuNameToPermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permissions', function($table)
        {
            $table->string('menu_name');
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
            $table->dropColumn('menu_name');
        });
	}

}