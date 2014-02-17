<?php
// 'saveme'

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class SavemesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO saveme (id, title, geocode) VALUES (?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/saveme.csv', $interpreter);
//   }
// }

class SavemesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $savemes = [
      [
        'title' => 'Rio de Janeiro',
        'geocode' => 483,
      ],
      [
        'title' => 'São Paulo',
        'geocode' => 63,
      ],
    ];

    foreach ($savemes as $saveme)
    {
      Saveme::create($saveme);
      // $s->offer()->attach(783, array('priority' => 1));
      // $s->offer()->attach(783, array('priority' => 2));
    }
  }
}
