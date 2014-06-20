<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class UsersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

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
// 	    if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
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
		'password' => 'a425352a84b14c7acb601495bd156322', // "programmer" em MD5
		'api_key' => 'ashd908hads9',
	  ],
	  [
		'username' => 'programacao',
		'email'    => 'programacao@innbativel.com.br',
		'password' => 'ff99bad467e5496212b799b5490392c4',
		'api_key' => 'sadmio0sadh089sa',
	  ],
	  [
		'username' => 'mastop',
		'email'    => 'mastop@mastop.com.br',
		'password' => '30bbd156641d2e54f275a64950349585',
		'api_key' => 'pQqRQXVZ2gG6JV',
	  ],
	  [
		'username' => 'comercial',
		'email'    => 'comercial@innbativel.com.br',
		'password' => 'DB24AC',
		'api_key' => 'sjdsa8hsdia',
	  ],
	  [
		'username' => 'financeiro',
		'email'    => 'financeiro@innbativel.com.br',
		'password' => 'DB24AC',
		'api_key' => 'mj09sd0jh09dsha',
	  ],
	];

	foreach ($users as $user)
	{
	  $created = User::create($user);
      $EmailArray = explode('@', $user['email']);
      $nome = ucfirst($EmailArray[0]);
      $sobrenome = ucfirst(substr($EmailArray[1], 0, strpos($EmailArray[1], '.')));
      $created->profile()->create(array('first_name' => $nome, 'last_name' => $sobrenome));
	}
  }
}
