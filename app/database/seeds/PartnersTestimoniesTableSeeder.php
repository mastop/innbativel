<?php

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class PartnersTestimoniesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

    $config = new LexerConfig();
    $config->setFromCharset('UTF-8');
    $config->setToCharset('LATIN1');
    $lexer = new Lexer($config); //ISO8591 ou UTF-8

    $interpreter = new Interpreter();
    $interpreter->unstrict();

    $interpreter->addObserver(function(array $columns) use ($pdo) {
    	try{
            $stmt = $pdo->prepare('INSERT INTO partners_testimonies (name, destiny, sponsor, role, testimony, img, display_order) VALUES (?, ?, ?, ?, ?, ?, ?)');
            if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
        }
        catch (Exception $e) {
            print_r($columns);
            print_r($e->getMessage()."\n");
        }
    });

    $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/partners_testimonies.csv', $interpreter);
  }
}

// class PartnersTestimoniesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $partners_testimonies = [
//       [
//         'name' => 'Parceiro fodão',
//         'destiny' => 'Floripa',
//         'sponsor' => 'Jão do lol',
//         'role' => 'Gerente hoteleiro',
//         'testimony' => 'A INN é imbatível',
//         'img' => '/assets/uploads/images/partner_testimony/img/ecoa-23-anos.jpg',
//         'display_order' => 1,
//       ],
//       [
//         'name' => 'Hoteis farofas',
//         'destiny' => 'Ceará',
//         'sponsor' => 'Zé Picão',
//         'role' => 'Coordenador chefe da zeladoria de banheiros do hotel',
//         'testimony' => 'A INN é transparente',
//         'img' => '/assets/uploads/images/partner_testimony/img/ecoa-23-anos.jpg',
//         'display_order' => 2,
//       ],
//     ];

//     foreach ($partners_testimonies as $partner_testimony)
//     {
//       PartnerTestimony::create($partner_testimony);
//     }
//   }
// }
