<?php

use Illuminate\Database\Migrations\Migration;

class SetupAddFaqsGroupsForeignKeyToFaqs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('faqs', function($table)
        {
        	$table->dropColumn('group_title');
        	$table->dropColumn('answer');
        });

        Schema::table('faqs', function($table)
        {
        	$table->text('answer')->nullable()->after('question');
        	$table->integer('faq_group_id')->unsigned()->index()->nullable()->after('id');
        	$table->integer('display_order')->default(99);

        	$table->foreign('faq_group_id')->references('id')->on('faqs_groups')->onDelete('set null')->onUpdate('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('faqs', function($table)
        {
        	$table->dropForeign('faq_faq_group_id_foreign');
        	$table->dropColumn('faq_group_id');
        	$table->dropColumn('display_order');
        	$table->dropColumn('answer');

        	$table->string('group_title')->nullable();
        	$table->string('answer')->nullable();

        });
	}

}