<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OrdersOffersOptionsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO orders_offers_options (id, order_id, offer_option_id, qty) VALUES (?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/orders_offers_options.csv', $interpreter);
//   }
// }

class OrdersOffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $orders_offers_options = [
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'qty' => 3,
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 3,
        'qty' => 1,
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 4,
        'qty' => 2,
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 2,
        'qty' => 2,
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 5,
        'qty' => 2,
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 2,
        'qty' => 5,
      ],
    ];

    foreach ($orders_offers_options as $order_offer_option)
    {
      OrderOfferOption::create($order_offer_option);
    }

  }
}
