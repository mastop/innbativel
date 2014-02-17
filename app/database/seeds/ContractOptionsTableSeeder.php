<?php

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class ContractOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

    $config = new LexerConfig();
    $config->setToCharset('UTF-8');
    $lexer = new Lexer($config); //ISO8591 ou UTF-8

    $interpreter = new Interpreter();

    $interpreter->addObserver(function(array $columns) use ($pdo) {
        $stmt = $pdo->prepare('INSERT INTO contract_options (id, contract_id, option, price_original, price_with_discount, percent_off, transfer, max_qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute($columns);
    });

    $lexer->parse(app_path().'/database/seeds/assets/contract_options.csv', $interpreter);
  }
}

// class ContractOptionsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {

//   }
// }
