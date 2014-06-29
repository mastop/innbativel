<?php

use Illuminate\Database\Migrations\Migration;

class AddAllowNewsletterProfile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('profiles', function($table)
        {
            $table->boolean('allow_newsletter')->default(true);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('profiles', function($table)
        {
            $table->dropColumn('allow_newsletter');
        });
	}

}