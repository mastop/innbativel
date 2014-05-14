<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class TransactionsVouchersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO transactions_vouchers (id, voucher_id, payment_partner_id, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/transactions_vouchers.csv', $interpreter);
//   }
// }

class TransactionsVouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions_vouchers = [
    	[
            'voucher_id' => 1,
            'payment_partner_id' => 1,
        ],
        [
            'voucher_id' => 2,
            'payment_partner_id' => 1,
        ],
        [
            'voucher_id' => 3,
            'payment_partner_id' => 1,
        ],
        [
            'voucher_id' => 4,
            'payment_partner_id' => 1,
        ],
        //////////////////////////////
        [
            'voucher_id' => 5,
            'payment_partner_id' => 1,
        ],
        [
            'voucher_id' => 6,
            'payment_partner_id' => 1,
        ],
        [
            'voucher_id' => 7,
            'payment_partner_id' => 1,
        ],
        //////////////////////////////
        [
            'voucher_id' => 8,
            'payment_partner_id' => 2,
        ],
        [
            'voucher_id' => 9,
            'payment_partner_id' => 2,
        ],
        [
            'voucher_id' => 10,
            'payment_partner_id' => 2,
        ],
        [
            'voucher_id' => 11,
            'payment_partner_id' => 2,
        ],
        //////////////////////////////
        [
            'voucher_id' => 3,
            'payment_partner_id' => 1,
            'status' => 'cancelamento',
        ],
        //////////////////////////////
        [
            'voucher_id' => 5,
            'status' => 'cancelamento',
        ],
        //////////////////////////////
        [
            'voucher_id' => 8,
            'status' => 'cancelamento',
        ],
        [
            'voucher_id' => 9,
            'status' => 'cancelamento',
        ],
        [
            'voucher_id' => 10,
            'status' => 'cancelamento',
        ],
    ];

    foreach ($transactions_vouchers as $transaction_voucher)
    {
      TransactionVoucher::create($transaction_voucher);
    }
  }
}
