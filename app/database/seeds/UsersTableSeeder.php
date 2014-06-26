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
// 	$config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();
// 	$interpreter->unstrict();

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 		try{
// 			// $stmt = $pdo->prepare('INSERT INTO users (id, salt, email, password, created_at, username, api_key) VALUES (?, ?, ?, ?, ?, ?, ?)');
// 	  //   	if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
// 	    	$user = new User;
// 	    	$user->id = $columns[0];
// 	    	$user->username = $columns[0];
// 	    	$user->api_key = $columns[0];
// 	    	$user->salt = $columns[1];
// 	    	$user->email = $columns[2];
// 	    	$user->password = $columns[3];
// 	    	$user->created_at = $columns[4];
// 	    	$user->save();
// 		}
// 		catch (Exception $e) {
// 			print_r($columns);
// 			print_r($e->getMessage()."\n");
// 		}
// 	});

// 	$lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/users.csv', $interpreter);
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
