<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class FaqsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {

//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

// 	$config = new LexerConfig()->setToCharset('UTF-8');
// 	$lexer = new Lexer($config); //ISO8591 ou UTF-8

// 	$interpreter = new Interpreter();

// 	$faq = new Faq;

// 	$interpreter->addObserver(function(array $columns) use ($pdo) {
// 	    $stmt = $pdo->prepare('INSERT INTO faqs (id, question, answer, group_title) VALUES (?, ?, ?, ?)');
// 	    $stmt->execute($columns);
// 	});

// 	$lexer->parse(app_path().'/database/seeds/assets/faqs.csv', $interpreter);

//   }
// }

class FaqsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $faqs = [
      [
        'question' => 'La pergunta?',
        'answer' => 'La resposta!',
        'group_title' => 'lala',
      ],
      [
        'question' => 'La pergunta de nuevo?',
        'answer' => 'La resposta de nuevo!',
        'group_title' => 'lala',
      ],
    ];

    foreach ($faqs as $faq)
    {
      Faq::create($faq);
    }
  }
}
