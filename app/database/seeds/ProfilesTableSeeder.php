<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class ProfilesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=innbativel.ctypvw54pblq.us-east-1.rds.amazonaws.com;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

// 	$config = new LexerConfig();
// 	$config->setToCharset('UTF-8');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 		$stmt = $pdo->prepare('INSERT INTO profiles (id, user_id, facebook_id, first_name, last_name, birthday, cpf, telephone, telephone2, img, credit, city, state, street, number, complement, neighborhood, zip, site, coordinates, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
// 	    $stmt->execute($columns);
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
    ];

    foreach ($profiles as $profile)
    {
      Profile::create($profile);
    }
  }
}
