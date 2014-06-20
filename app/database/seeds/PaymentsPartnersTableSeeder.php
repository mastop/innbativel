<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class PaymentsPartnersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO payments_partners (id, payment_id, partner_id, paid_on, total) VALUES (?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/payments_partners.csv', $interpreter);
//   }
// }

class PaymentsPartnersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments_partners = [
    	[
    		'payment_id' => 1,
    		'partner_id' => 100001,
    		'total' => 2000,
    	],
    	[
    		'payment_id' => 2,
    		'partner_id' => 100002,
    		'total' => 2000,
    	],
    ];

    foreach ($payments_partners as $payment_partner)
    {
      PaymentPartner::create($payment_partner);
    }
  }
}
