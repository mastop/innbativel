<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OrdersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO orders (id, user_id, braspag_order_id, antifraud_id, braspag_id, status, total, credit_discount, cpf, telephone, is_gift, payment_terms, boleto, capture_date, history, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)) print_r($stmt->errorInfo());
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/orders.csv', $interpreter);
//   }
// }

class OrdersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $orders = [
      [
        'user_id' => 1,
        'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
        'antifraud_id' => '1234-1234-1234-1234',
        'braspag_id' => '1234-1234-1234-1234',
        'status' => 'pago',
        'donation' => 1,
        'total' => 495.00,
        'credit_discount' => 200.00,
        'interest_rate' => 0.10,
        'card_boletus_rate' => 6.65,
        'antecipation_rate' => 3.63,
        'coupon_id' => 1,
        'cpf' => '1231231233',
        'telephone' => '48 99223300',
        'payment_terms' => '3x no cartão Mastercard',
        'history' => 'Transação iniciada em 25/10/2013 11:09',
        'capture_date' => '2013-11-04 11:27:49',
        'created_at' => date('Y-m-d H:i:s',strtotime("-13 days"))
      ],
      [
        'user_id' => 2,
        'braspag_order_id' => '9080-CDS8-DSA9-8967',
        'antifraud_id' => '1234-1234-1234-1234',
        'braspag_id' => '1234-1234-1234-1234',
        'status' => 'pago',
        'donation' => 1,
        'total' => 3000.00,
        'card_boletus_rate' => 6.65,
        'antecipation_rate' => 3.63,
        'cpf' => '1231231233',
        'telephone' => '48 99223300',
        'payment_terms' => '1x no cartão Mastercard',
        'history' => 'Transação iniciada em 25/10/2013 11:09',
        'capture_date' => '2013-11-04 11:27:49',
        'created_at' => date('Y-m-d H:i:s',strtotime("-10 days"))
      ],
      [
        'user_id' => 1,
        'braspag_order_id' => 'LOS9-8SDA-HASD-O9U8',
        'antifraud_id' => '1234-1234-1234-1234',
        'braspag_id' => '1234-1234-1234-1234',
        'status' => 'pago',
        'donation' => 1,
        'total' => 1500.00,
        'card_boletus_rate' => 6.65,
        'antecipation_rate' => 3.63,
        'cpf' => '1231231233',
        'telephone' => '48 99223300',
        'payment_terms' => '1x no cartão Mastercard',
        'history' => 'Transação iniciada em 25/10/2013 11:09',
        'capture_date' => '2013-11-04 11:27:49',
        'created_at' => date('Y-m-d H:i:s',strtotime("-11 days"))
      ],
      [
        'user_id' => 1,
        'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
        'antifraud_id' => '1234-1234-1234-1234',
        'braspag_id' => '1234-1234-1234-1234',
        'status' => 'pago',
        'donation' => 1,
        'total' => 751.00,
        'card_boletus_rate' => 6.65,
        'antecipation_rate' => 3.63,
        'cpf' => '1231231233',
        'telephone' => '48 99223300',
        'payment_terms' => '1x no cartão Mastercard',
        'history' => 'Transação iniciada em 25/10/2013 11:09',
        'capture_date' => '2013-11-04 11:27:49',
        'created_at' => date('Y-m-d H:i:s',strtotime("-13 days"))
      ],
      
    ];

    foreach ($orders as $order)
    {
      Order::create($order);
    }

  }
}
