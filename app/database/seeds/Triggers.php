<?php

class Triggers extends DatabaseSeeder
{
	public function run()
	{
        $this->command->info('Início dos Triggers');
        $pdo = DB::connection()->getPdo();
		$triggers = 'DROP TRIGGER IF EXISTS inst_order;';

        if($pdo->exec($triggers) === false) print_r($pdo->errorInfo());

		$triggers = file_get_contents(app_path().'/database/seeds/assets/ImportacaoBDNovo/Triggers/inst_order.sql');
		($pdo->exec($triggers) === false) ? print_r($pdo->errorInfo()) : $this->command->info('Trigger inst_order criado.');



		$triggers = 'DROP TRIGGER IF EXISTS upd_order;';
		if($pdo->exec($triggers) === false) print_r($pdo->errorInfo());

		$triggers = file_get_contents(app_path().'/database/seeds/assets/ImportacaoBDNovo/Triggers/upd_order.sql');
        ($pdo->exec($triggers) === false) ? print_r($pdo->errorInfo()) : $this->command->info('Trigger upd_order criado.');



		$triggers = 'DROP FUNCTION IF EXISTS inst_transaction_partial_cancellation;';
		if($pdo->exec($triggers) === false) print_r($pdo->errorInfo());

		$triggers = file_get_contents(app_path().'/database/seeds/assets/ImportacaoBDNovo/Triggers/inst_transaction_partial_cancellation.sql');
        ($pdo->exec($triggers) === false) ? print_r($pdo->errorInfo()) : $this->command->info('Trigger inst_transaction_partial_cancellation criado.');



		$triggers = 'DROP TRIGGER IF EXISTS inst_voucher;';
		if($pdo->exec($triggers) === false) print_r($pdo->errorInfo());

		$triggers = file_get_contents(app_path().'/database/seeds/assets/ImportacaoBDNovo/Triggers/inst_voucher.sql');
        ($pdo->exec($triggers) === false) ? print_r($pdo->errorInfo()) : $this->command->info('Trigger inst_voucher criado.');



		$triggers = 'DROP TRIGGER IF EXISTS upd_voucher;';
		if($pdo->exec($triggers) === false) print_r($pdo->errorInfo());

		$triggers = file_get_contents(app_path().'/database/seeds/assets/ImportacaoBDNovo/Triggers/upd_voucher.sql');
        ($pdo->exec($triggers) === false) ? print_r($pdo->errorInfo()) : $this->command->info('Trigger upd_voucher criado.');
	}
}
