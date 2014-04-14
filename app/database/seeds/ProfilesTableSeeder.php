<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class ProfilesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

// 	$config = new LexerConfig();
// 	$config->setToCharset('UTF-8');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 		$stmt = $pdo->prepare('INSERT INTO profiles (id, user_id, facebook_id, first_name, last_name, birthday, cpf, telephone, telephone2, img, credit, city, state, street, number, complement, neighborhood, zip, company_name, cnpj, site, coordinates, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
// 	    if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
// 	});

// 	$lexer->parse(app_path().'/database/seeds/assets/profiles.csv', $interpreter);
//   }
// }

class ProfilesTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $profiles = [
      [
        'user_id' => 1,
        'first_name' => 'Cawe',
        'last_name' => 'Coy',
      ],
      [
        'user_id' => 2,
        'first_name' => 'Daniel',
        'last_name' => 'Mai',
      ],
      [
        'user_id' => 3,
        'first_name' => 'Alguem Nome',
        'last_name' => 'Sobrenome',
      ],
      [
        'user_id' => 4,
        'first_name' => 'Fulano',
        'last_name' => 'De Tal',
      ],
    ];

    foreach ($profiles as $profile)
    {
      Profile::create($profile);
    }
  }
}
