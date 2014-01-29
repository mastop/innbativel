<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class UsersIndicationsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO users_indications (id, user_id, name, email, created_at) VALUES (?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/users_indications.csv', $interpreter);
//   }
// }

class UsersIndicationsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $users_indications = [
      [
        'user_id' => 1,
        'name' => 'Almerir de Silveirado Jacaré',
        'email' => 'jacare@gmail.com',
      ],
    ];

    foreach ($users_indications as $user_indication)
    {
      UserIndication::create($user_indication);
    }
  }
}
