<?php

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class ContractsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

    $config = new LexerConfig();
    $config->setToCharset('UTF-8');
    $lexer = new Lexer($config); //ISO8591 ou UTF-8

    $interpreter = new Interpreter();

    $interpreter->addObserver(function(array $columns) use ($pdo) {
    	$stmt = $pdo->prepare('INSERT INTO contracts (id, partner_id, company_name, cnpj, trading_name, address, complement, neighborhood, zip, city, state, agent1_name, agent1_cpf, agent1_telephone, agent2_name, agent2_cpf, agent2_telephone, bank_name, bank_number, bank_holder, bank_agency, bank_account, bank_financial_email, is_signed, is_sent, consultant, term, restriction, has_scheduling, sched_contact, sched_max_date, sched_dates, sched_min_antecedence, n_people, details, clauses, ip, signed_at, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute($columns);
    });

    $lexer->parse(app_path().'/database/seeds/assets/contracts.csv', $interpreter);
  }
}

class ContractsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

  }
}
