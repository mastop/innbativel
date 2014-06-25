<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class CommentsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
	// $config->setFromCharset('UTF-8');
	// $config->setToCharset('LATIN1');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();
		// $interpreter->unstrict();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
		// try{
	//     	$columns[3] = ($columns[3] == 's') ? true : false;
	//         $stmt = $pdo->prepare('INSERT INTO comments (offer_id, user_id, comment, approved, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?)');
	//         if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
			// }
			// catch (Exception $e) {
		 //        print_r($columns);
		 //        print_r($e->getMessage()."\n");
		 //      }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/comments.csv', $interpreter);
//   }
// }

class CommentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	// $comments = [
	//   [
	//     'offer_id' => 783,
	//     'user_id' => 1,
	//     'comment' => 'bla bla bla',
	//     'approved' => true,
	//   ],
	//   [
	//     'offer_id' => 783,
	//     'user_id' => 2,
	//     'comment' => 'uh uh uh',
	//   ],
	// ];

	// foreach ($comments as $comment)
	// {
	//   Comment::create($comment);
	// }
  }
}
