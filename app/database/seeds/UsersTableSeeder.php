<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class UsersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=innbativel.ctypvw54pblq.us-east-1.rds.amazonaws.com;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

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
		'username' => 'cawecoy',
		'email'    => 'cawecoy@gmail.com',
		'password' => 'programmer',
		'api_key' => 'ashd908hads9',
	  ],
	  [
		'username' => 'programacao',
		'email'    => 'programacao@innbativel.com.br',
		'password' => 'ff99bad467e5496212b799b5490392c4',
		'api_key' => 'sadmio0sadh089sa',
	  ],
	  [
		'username' => 'danielmai',
		'email'    => 'designer@innbativel.com.br',
		'password' => 'designer',
		'api_key' => 'sjdsa8hsdia',
	  ],
	  [
		'username' => 'paulosabbaneli',
		'email'    => 'gerente@innbativel.com.br',
		'password' => 'manager',
		'api_key' => 'mj09sd0jh09dsha',
	  ],
	];

	foreach ($users as $user)
	{
	  $created = User::create($user);
	}
  }
}
