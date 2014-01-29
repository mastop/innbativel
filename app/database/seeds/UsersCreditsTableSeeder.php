<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class UsersCreditsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO users_credits (id, user_id, new_user_id, value, created_at) VALUES (?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/users_credits.csv', $interpreter);
//   }
// }

class UsersCreditsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $users_credits = [
      [
        'user_id' => 1,
        'new_user_id' => 2,
        'value' => 3000,
      ],
    ];

    foreach ($users_credits as $user_credit)
    {
      UserCredit::create($user_credit);
    }
  }
}
