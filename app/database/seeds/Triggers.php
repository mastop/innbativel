<?php

class Triggers extends DatabaseSeeder
{
	public function run()
	{
	    $DB_NAME = Config::get('database.connections.mysql.database');
		$DB_HOST = Config::get('database.connections.mysql.host');
		$DB_USER = Config::get('database.connections.mysql.username'); 
		$DB_PASS = Config::get('database.connections.mysql.password'); 

		$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);



		$triggers = 'DROP TRIGGER IF EXISTS inst_order;';
		if(!$mysqli->query($triggers)) print_r($mysqli->error);

		$triggers = file_get_contents(app_path().'/database/seeds/assets/Triggers/inst_order.sql');
		if(!$mysqli->query($triggers)) print_r($mysqli->error);



		$triggers = 'DROP TRIGGER IF EXISTS upd_order;';
		if(!$mysqli->query($triggers)) print_r($mysqli->error);

		$triggers = file_get_contents(app_path().'/database/seeds/assets/Triggers/upd_order.sql');
		if(!$mysqli->query($triggers)) print_r($mysqli->error);



		$triggers = 'DROP FUNCTION IF EXISTS inst_transaction_partial_cancellation;';
		if(!$mysqli->query($triggers)) print_r($mysqli->error);

		$triggers = file_get_contents(app_path().'/database/seeds/assets/Triggers/inst_transaction_partial_cancellation.sql');
		if(!$mysqli->query($triggers)) print_r($mysqli->error);



		$triggers = 'DROP TRIGGER IF EXISTS inst_voucher;';
		if(!$mysqli->query($triggers)) print_r($mysqli->error);

		$triggers = file_get_contents(app_path().'/database/seeds/assets/Triggers/inst_voucher.sql');
		if(!$mysqli->query($triggers)) print_r($mysqli->error);



		$triggers = 'DROP TRIGGER IF EXISTS upd_voucher;';
		if(!$mysqli->query($triggers)) print_r($mysqli->error);

		$triggers = file_get_contents(app_path().'/database/seeds/assets/Triggers/upd_voucher.sql');
		if(!$mysqli->query($triggers)) print_r($mysqli->error);
	}
}
