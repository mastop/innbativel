<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class UsersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

// 	$config = new LexerConfig();
// 	$config->setToCharset('UTF-8');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 		$email = $columns[2];
// 		$columns[4] = Str::lower(Str::slug($email) . '-' .Str::random(16));

// 		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
// 		$length = 10;
// 		$columns[5] = Hash::make(substr(str_shuffle($chars),0,$length));

// 	    $stmt = $pdo->prepare('INSERT INTO users (id, salt, email, created_at, username, password, created_at) VALUES (?, ?, ?, ?, ?, ?)');
// 	    $stmt->execute($columns);
// 	});

// 	$lexer->parse(app_path().'/database/seeds/assets/users.csv', $interpreter);
//   }
// }

class UsersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $users = [
      [
        'username' => 'felipepodesta',
        'email'    => 'felipepodesta@me.com',
        'password' => 'programmer',
      ],
      [
        'username' => 'danielmai',
        'email'    => 'designer@innbativel.com.br',
        'password' => 'programmer',
      ],
      [
        'username' => 'cawecoy',
        'email'    => 'cawecoy@gmail.com',
        'password' => 'programmer',
      ],
    ];

    foreach ($users as $user)
    {
      $created = User::create($user);
    }
  }
}
