<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class VouchersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	ov.id_compra AS order_offer_id, ov.usado AS used, ov.numero AS display_code, ov.nome AS name, ov.email_voucher AS email
//         $stmt = $pdo->prepare('INSERT INTO vouchers (order_offer_id, used, display_code, name, email) VALUES (?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
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
        'display_code' => '1234-1234-1234-4321',
        'name' => 'Lindonilda, a Onipresente',
        'email' => 'lindo@nil.da',
      ],
    ];

    foreach ($vouchers as $voucher)
    {
      Voucher::create($voucher);
    }
  }
}
