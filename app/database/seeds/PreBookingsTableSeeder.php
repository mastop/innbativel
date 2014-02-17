<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class PreBookingsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	$stmt = $pdo->prepare('INSERT INTO pre_bookings (offer_id, user_id, email, name, telephone, created_at) VALUES (?, ?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/pre_bookings.csv', $interpreter);
//   }
// }

class PreBookingsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $pre_bookings = [
      [
        'offer_id' => 783,
        'user_id' => 1,
      ],
    ];

    foreach ($pre_bookings as $pre_booking)
    {
      PreBooking::create($pre_booking);
    }
  }
}
