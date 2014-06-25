<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class FaqsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {

//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
//   	$lexer = new Lexer($config);

//     $interpreter = new Interpreter();
      // $interpreter->unstrict();

//   	$interpreter->addObserver(function(array $columns) use ($pdo) {
        // try{
//   	    $stmt = $pdo->prepare('INSERT INTO faqs (question, answer, group_title) VALUES (?, ?, ?)');
//   	    if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
        // }
        // catch (Exception $e) {
        //   print_r($columns);
        //   print_r($e->getMessage()."\n");
        // }
//   	});

//   	$lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/faqs.csv', $interpreter);

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
