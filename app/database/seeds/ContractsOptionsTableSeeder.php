<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class ContractsOptionsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
// 	$pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

// 	$config = new LexerConfig();
// 	$config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();
// 	$interpreter->unstrict();

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 	    try{
// 	    	$stmt = $pdo->prepare('INSERT INTO contract_options (id, contract_id, title, price_original, price_with_discount, percent_off, transfer, max_qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
// 		    if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
// 	    }
// 	    catch (Exception $e) {
// 			print_r($columns);
// 			print_r($e->getMessage()."\n");
// 		}
// 	});

// 	$lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/contract_options.csv', $interpreter);
//   }
// }

class ContractOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

  }
}
