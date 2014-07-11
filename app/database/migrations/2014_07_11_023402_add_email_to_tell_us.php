<?php

use Illuminate\Database\Migrations\Migration;

class AddEmailToTellUs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tell_us', function($table)
        {
            $table->string('email')->nullable()->after('name');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('tell_us', function($table)
        {
            $table->dropColumn('email');
        });
	}

}