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
//         $stmt = $pdo->prepare('INSERT INTO vouchers (id, order_offer_id, used, display_code, name, email) VALUES (?, ?, ?, ?, ?, ?)');
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
        'display_code' => 'sDKJ-878s-S87d-nsdj',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'display_code' => 'sakd-asda-sda3-safd',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 2,
        'display_code' => 'gfhf-ghfg-ghgf-hggf',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 3,
        'display_code' => 'vbfg-gtf0-bgbf-gbgb',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 2,
        'offer_option_id' => 2,
        'display_code' => 'cvxx-vddf-df67-df76',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 4,
        'display_code' => 'dfi3-dfgf-43rf-4567',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 4,
        'display_code' => 'we23-3e3e-3e3e-e33e',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 3,
        'offer_option_id' => 5,
        'display_code' => 'y6y6-y6tr-6y6t-6yty',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'display_code' => '1qww-w1w1-w321-231w',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'display_code' => 'z3qa-qa12-qzaz-aqz2',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'cancelado',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 6,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 4,
        'offer_option_id' => 10,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 4,
        'offer_option_id' => 10,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      [
        'order_id' => 4,
        'offer_option_id' => 11,
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
    ];

    foreach ($vouchers as $voucher)
    {
      Voucher::create($voucher);
    }
  }
}
