<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OffersImagesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();
//     $interpreter->unstrict();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         try{
//             $stmt = $pdo->prepare('INSERT INTO offers_images (offer_id, url) VALUES (?, ?)');
//             if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
//         }
//         catch (Exception $e) {
//             print_r($columns);
//             print_r($e->getMessage()."\n");
//         }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/offers_images.csv', $interpreter);
//   }
// }

class OffersImagesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	// $offers_images = [
	//   [
	//     'offer_id' => 783,
	//     'url' => 'http://ofertasinnbativel.s3.amazonaws.com/c683df579fcdeb8334ffbabdeaa6940e2270_t.jpg',
	//   ],
	//   [
	//     'offer_id' => 784,
	//     'url' => 'http://ofertasinnbativel.s3.amazonaws.com/08ee15aa60a7b2cd6352ab38e073eea712336_t.jpg',
	//   ],
	// ];

	// foreach ($offers_images as $offer_image)
	// {
	//   OfferImage::create($offer_image);
	// }
  }
}
