<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class CommentsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	$columns[3] = ($columns[3] == 's') ? true : false;
//         $stmt = $pdo->prepare('INSERT INTO comments (offer_id, user_id, comment, approved, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/comments.csv', $interpreter);
//   }
// }

class CommentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $comments = [
      [
        'offer_id' => 783,
        'user_id' => 1,
        'comment' => 'bla bla bla',
        'approved' => true,
      ],
      [
        'offer_id' => 783,
        'user_id' => 2,
        'comment' => 'uh uh uh',
      ],
    ];

    foreach ($comments as $comment)
    {
      Comment::create($comment);
    }
  }
}
