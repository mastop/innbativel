<?php

use Illuminate\Database\Migrations\Migration;

class AddShortTitleGroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('groups', function($table)
        {
            $table->string('short_title')->nullable()->after('title');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('groups', function($table)
        {
            $table->dropColumn('short_title');
        });
	}

}