<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OffersImagesTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	oi.id_oferta AS offer_id, oi.imagem AS url
//         $stmt = $pdo->prepare('INSERT INTO offers_images (offer_id, url) VALUES (?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/offers_images.csv', $interpreter);
//   }
// }

class OffersImagesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $offers_images = [
      [
        'offer_id' => 783,
        'url' => 'http://ofertasinnbativel.s3.amazonaws.com/c683df579fcdeb8334ffbabdeaa6940e2270_t.jpg',
      ],
      [
        'offer_id' => 784,
        'url' => 'http://ofertasinnbativel.s3.amazonaws.com/08ee15aa60a7b2cd6352ab38e073eea712336_t.jpg',
      ],
    ];

    foreach ($offers_images as $offer_image)
    {
      OfferImage::create($offer_image);
    }
  }
}
