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
//     $config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();
//     $interpreter->unstrict();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//       try{
//         $stmt = $pdo->prepare('INSERT INTO vouchers (id, order_id, offer_option_id, used, display_code, name, email, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); file_put_contents('/tmp/vouchers.txt', serialize([$columns[0], $columns[7]]).'###', FILE_APPEND); }
//       }
//       catch (Exception $e) {
//         file_put_contents('/tmp/vouchers.txt', serialize([$columns[0], $columns[7]]).'###', FILE_APPEND);
//         print_r($columns);
//         print_r($e->getMessage()."\n");
//       }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/vouchers.csv', $interpreter);
//   }
// }

class VouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    
    $vouchers = [
      [
        'order_id' => 1,
        'offer_option_id' => 3003,
        'display_code' => 'sDKJ-878s-S87d-nsdj',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 3010,
        'display_code' => 'sakd-asda-sda3-safd',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 1,
        'offer_option_id' => 3011,
        'display_code' => 'gfhf-ghfg-ghgf-hggf',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 2,
        'offer_option_id' => 3003,
        'display_code' => 'sDKJ-878s-S87d-nsdj',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 3010,
        'display_code' => 'sakd-asda-sda3-safd',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 2,
        'offer_option_id' => 3011,
        'display_code' => 'gfhf-ghfg-ghgf-hggf',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 3,
        'offer_option_id' => 3003,
        'display_code' => 'sDKJ-878s-S87d-nsdj',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 3010,
        'display_code' => 'sakd-asda-sda3-safd',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 3,
        'offer_option_id' => 3011,
        'display_code' => 'gfhf-ghfg-ghgf-hggf',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 4,
        'offer_option_id' => 3003,
        'display_code' => 'sDKJ-878s-S87d-nsdj',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 4,
        'offer_option_id' => 3010,
        'display_code' => 'sakd-asda-sda3-safd',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 4,
        'offer_option_id' => 3011,
        'display_code' => 'gfhf-ghfg-ghgf-hggf',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 5,
        'offer_option_id' => 3011,
        'display_code' => 'vbfg-gtf0-bgbf-gbgb',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 6,
        'offer_option_id' => 3003,
        'display_code' => 'cvxx-vddf-df67-df76',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 7,
        'offer_option_id' => 3009,
        'display_code' => 'dfi3-dfgf-43rf-4567',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      [
        'order_id' => 8,
        'offer_option_id' => 3003,
        'display_code' => 'hjk0-hj4f-32fd-vcju',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 8,
        'offer_option_id' => 3010,
        'display_code' => 'bt56-bg7s-4frc-7nbg',
        'name' => 'Gilberto',
        'email' => 'gil@gmail.com',
        'status' => 'pago',
      ],
      [
        'order_id' => 8,
        'offer_option_id' => 3011,
        'display_code' => 'koj7-23ds-df7b-vjjh',
        'name' => 'Gilberto',
        'email' => 'lindo@nil.da',
        'status' => 'pago',
      ],
      ////////////////////////////////////////////
      // [
      //   'order_id' => 2,
      //   'offer_option_id' => 3004,
      //   'display_code' => 'we23-3e3e-3e3e-e33e',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'pago',
      // ],
      // ////////////////////////////////////////////
      // [
      //   'order_id' => 3,
      //   'offer_option_id' => 3005,
      //   'display_code' => 'y6y6-y6tr-6y6t-6yty',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'cancelado',
      // ],
      // [
      //   'order_id' => 3,
      //   'offer_option_id' => 3006,
      //   'display_code' => '1qww-w1w1-w321-231w',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'cancelado',
      // ],
      // [
      //   'order_id' => 3,
      //   'offer_option_id' => 3006,
      //   'display_code' => 'z3qa-qa12-qzaz-aqz2',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'cancelado',
      // ],
      // [
      //   'order_id' => 3,
      //   'offer_option_id' => 3006,
      //   'display_code' => 'a123-sda4-sad4-h7nh',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'pago',
      // ],
      // [
      //   'order_id' => 4,
      //   'offer_option_id' => 3010,
      //   'display_code' => 'fvt7-vfdv-nb65-4fdf3',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'pago',
      // ],
      // [
      //   'order_id' => 4,
      //   'offer_option_id' => 3010,
      //   'display_code' => 'nbn7-76nb-vcfg-hyl8',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'pago',
      // ],
      // [
      //   'order_id' => 4,
      //   'offer_option_id' => 3011,
      //   'display_code' => 'sdfg-45vf-nn6h-az49',
      //   'name' => 'Gilberto',
      //   'email' => 'lindo@nil.da',
      //   'status' => 'pago',
      // ],
    ];

    foreach ($vouchers as $voucher)
    {
      Voucher::create($voucher);
    }
  }
}
