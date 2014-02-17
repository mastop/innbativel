<?php
// 'offers' e 'offers_additional'

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OffersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=innbativel.ctypvw54pblq.us-east-1.rds.amazonaws.com;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	$stmt = $pdo->prepare('INSERT INTO offers (id, partner_id, ngo_id, title, subtitle, description, destiny, saveme_title, general_rules, starts_on, ends_on, cover_img, offer_old_img, newsletter_img, saveme_img, video, slug, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/offers.csv', $interpreter);
//   }
// }

class OffersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$sql = File::get(app_path() . '/database/seeds/assets/sql/offers.sql');
	DB::statement($sql);
  }
}
