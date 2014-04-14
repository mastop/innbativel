<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class VouchersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	ov.id_compra AS order_offer_id, ov.usado AS used, ov.numero AS display_code, ov.nome AS name, ov.email_voucher AS email
//         $stmt = $pdo->prepare('INSERT INTO vouchers (order_offer_id, used, display_code, name, email) VALUES (?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/vouchers.csv', $interpreter);
//   }
// }

class VouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    
    $vouchers = [
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 3,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 2,
        'offer_option_id' => 2,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 4,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 4,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 3,
        'offer_option_id' => 5,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'subtotal' => 100,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
    ];

    foreach ($vouchers as $voucher)
    {
      Voucher::create($voucher);
    }
  }
}
