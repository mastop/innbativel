<?php

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class ProfilesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

  	$config = new LexerConfig();
  	$config->setFromCharset('UTF-8');
    $config->setToCharset('LATIN1');
  	$lexer = new Lexer($config); //ISO8591 ou UTF-8

  	$interpreter = new Interpreter();
    $interpreter->unstrict();

  	$interpreter->addObserver(function(array $columns) use ($pdo) {
      try{
    		$stmt = $pdo->prepare('INSERT INTO profiles (id, user_id, facebook_id, first_name, last_name, birthday, cpf, telephone, telephone2, img, credit, city, state, street, number, complement, neighborhood, zip, company_name, cnpj, site, coordinates) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
      }
      catch (Exception $e) {
        print_r($columns);
        print_r($e->getMessage()."\n");
      }
  	});

    $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/profiles.csv', $interpreter);
  }
}

// class ProfilesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {

//     $profiles = [
//       [
//         'user_id' => 1,
//         'first_name' => 'Cawe',
//         'last_name' => 'Coy',
//       ],
//       [
//         'user_id' => 2,
//         'first_name' => 'Programação',
//         'last_name' => 'Innbatível',
//       ],
//       [
//         'user_id' => 3,
//         'first_name' => 'Mastop',
//         'last_name' => 'Internet Development',
//       ],
//       [
//         'user_id' => 4,
//         'first_name' => 'Comercial',
//         'last_name' => 'Innbatível',
//       ],
//       [
//         'user_id' => 5,
//         'first_name' => 'Financeiro',
//         'last_name' => 'Innbatível',
//       ],
//     ];

//     foreach ($profiles as $profile)
//     {
//       Profile::create($profile);
//     }
//   }
// }