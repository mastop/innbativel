<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class TellUsTableSeeder extends DatabaseSeeder
// {
//     public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();
//     $interpreter->unstrict();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//       try{
//         $stmt = $pdo->prepare('INSERT INTO tell_us (name, destiny, partner_name, travel_date, depoiment, img, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
//       }
//       catch (Exception $e) {
//         print_r($columns);
//         print_r($e->getMessage()."\n");
//       }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/tell_us.csv', $interpreter);
//   }
// }

class TellUsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $tell_uss = [
      [
        'name' => 'Jimi Handrix',
        'destiny' => 'Jupter',
        'partner_name' => 'WTF',
        'travel_date' => '01/11/2013',
        'depoiment' => 'A viage foi paulada eim',
        'img' => '/assets/uploads/images/tellus/img/ecoa-23-anos.jpg',
        'display_order' => 1,
      ],[
        'name' => 'Fernando Santos',
        'destiny' => 'Oiapoque',
        'partner_name' => 'Orkut',
        'travel_date' => '2030-12-30 10:44:42',
        'depoiment' => 'Eu queria ver a neve. E para ver a neve, nada melhor que ir ao Oiapoque, já que no Chuí o tempo estava quente.',
        'img' => '/assets/uploads/images/tellus/img/ecoa-23-anos.jpg',
        'display_order' => 2,
      ],
    ];

    foreach ($tell_uss as $tell_us)
    {
      TellUs::create($tell_us);
    }
  }
}
