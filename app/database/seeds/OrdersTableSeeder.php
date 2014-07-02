<?php

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class OrdersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    
    $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

    $config = new LexerConfig();
    $config->setFromCharset('UTF-8');
    $config->setToCharset('LATIN1');
    $lexer = new Lexer($config); //ISO8591 ou UTF-8

    $interpreter = new Interpreter();
    $interpreter->unstrict();

    $rates[0][0] = Configuration::get('card-tax-1x');
    $rates[0][1] = Configuration::get('card-tax-3x');
    $rates[0][2] = Configuration::get('card-tax-6x');
    $rates[0][3] = Configuration::get('card-tax-10x');

    $rates[1][0] = Configuration::get('antecipation-tax-1x');
    $rates[1][1] = Configuration::get('antecipation-tax-3x');
    $rates[1][2] = Configuration::get('antecipation-tax-6x');
    $rates[1][3] = Configuration::get('antecipation-tax-10x');

    $rates[3][0] = Configuration::get('boletus-value');

    $interpreter->addObserver(function(array $columns) use ($pdo, $rates) {
        try{
            $payment_terms = $columns[11];

            if(strpos($payment_terms, 'Cartão') !== false){

                preg_match_all('!\d+!', $payment_terms, $installment);
                $installment = $installment[0][0];

                if($installment == '1'){
                    $columns[17] = $rates[0][0]; // Configuration::get('card-tax-1x'); // card_boletus_rate
                    $columns[18] = $rates[1][0]; // Configuration::get('antecipation-tax-1x'); // antecipation_rate
                }
                else if($installment == '3'){
                    $columns[17] = $rates[0][1]; // Configuration::get('card-tax-3x'); // card_boletus_rate
                    $columns[18] = $rates[1][1]; // Configuration::get('antecipation-tax-3x'); // antecipation_rate
                }
                else if($installment == '6'){
                    $columns[17] = $rates[0][2]; // Configuration::get('card-tax-6x'); // card_boletus_rate
                    $columns[18] = $rates[1][2]; // Configuration::get('antecipation-tax-6x'); // antecipation_rate
                }
                else if($installment == '10'){
                    $columns[17] = $rates[0][3]; // Configuration::get('card-tax-10x'); // card_boletus_rate
                    $columns[18] = $rates[1][3]; // Configuration::get('antecipation-tax-10x'); // antecipation_rate
                }
                else{
                    $columns[17] = 0; // card_boletus_rate
                    $columns[18] = 0; // antecipation_rate
                }
            }
            else if($payment_terms == 'Boleto'){
                $columns[17] = $rates[3][0]; // Configuration::get('boletus-value'); // card_boletus_rate
                $columns[18] = 0; // antecipation_rate
            }
            else{ // IF $payment_terms == Créditos do usuário ou cupom de desconto
                $columns[17] = 0; // card_boletus_rate
                $columns[18] = 0; // antecipation_rate
            }

            $stmt = $pdo->prepare('INSERT INTO orders (id, user_id, braspag_order_id, antifraud_id, braspag_id, status, total, credit_discount, cpf, telephone, is_gift, payment_terms, boleto, capture_date, history, created_at, updated_at, card_boletus_rate, antecipation_rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
        }
        catch (Exception $e) {
            print_r($columns);
            print_r($e->getMessage()."\n");
        }
    });

    $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/orders.csv', $interpreter);
  }
}

// class OrdersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $orders = [
//       [
//         'id' => 1,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 1,
//         'total' => 1101.00,
//         'credit_discount' => 300.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 0.0266,
//         'antecipation_rate' => 0.0149,
//         'coupon_id' => 2,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => '1x no cartão Mastercard',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-10 days"))
//       ],
//       [
//         'id' => 2,
//         'user_id' => 100002,
//         'braspag_order_id' => '9080-CDS8-DSA9-8967',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 1,
//         'total' => 1450.318568004,
//         'credit_discount' => 100.00,
//         'interest_rate' => 0.035202404,
//         'card_boletus_rate' => 0.0341,
//         'antecipation_rate' => 0.0298,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => '3x no cartão Mastercard',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-11 days"))
//       ],
//       [
//         'id' => 3,
//         'user_id' => 100001,
//         'braspag_order_id' => 'LOS9-8SDA-HASD-O9U8',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 0,
//         'total' => 1593.203013,
//         'interest_rate' => 0.062135342,
//         'card_boletus_rate' => 0.0366,
//         'antecipation_rate' => 0.05215,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => '6x no cartão Mastercard',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-12 days"))
//       ],
//       [
//         'id' => 4,
//         'user_id' => 100001,
//         'braspag_order_id' => 'LOS9-8SDA-HASD-O9U8',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 0,
//         'total' => 1648.13,
//         'interest_rate' => 0.09875344,
//         'card_boletus_rate' => 0.0266,
//         'antecipation_rate' => 0.0149,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => '10x no cartão Mastercard',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-13 days"))
//       ],
//       [
//         'id' => 5,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 0,
//         'total' => 0.00,
//         'coupon_id' => 1,
//         'credit_discount' => 200.00,
//         'card_boletus_rate' => 0.0,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Créditos/Cupom desconto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-14 days"))
//       ],
//       [
//         'id' => 6,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 1,
//         'total' => 601.00,
//         'card_boletus_rate' => 1.60,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-15 days"))
//       ],
//       [
//         'id' => 7,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SD78-NHD0-SD81-ZCY5',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 0,
//         'total' => 280.00,
//         'coupon_id' => 1,
//         'card_boletus_rate' => 1.60,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-16 days"))
//       ],
//       [
//         'id' => 8,
//         'user_id' => 100001,
//         'braspag_order_id' => 'PED8-34MD-SLL3-SPD9',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pago',
//         'donation' => 1,
//         'total' => 0.00,
//         'credit_discount' => 1500.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 0.0,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Créditos do usuário',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => date('Y-m-d H:i:s',strtotime("-17 days"))
//       ],
//       [
//         'id' => 9,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-10 23:59:59'
//       ],
//       [
//         'id' => 10,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-11 00:00:00'
//       ],
//       [
//         'id' => 11,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-11 00:00:01'
//       ],
//       [
//         'id' => 12,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-20 12:34:56'
//       ],
//       [
//         'id' => 13,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-26 23:59:58'
//       ],
//       [
//         'id' => 14,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-26 23:59:59'
//       ],
//       [
//         'id' => 15,
//         'user_id' => 100001,
//         'braspag_order_id' => 'SDNM-FGB7-DSF2-34FZ',
//         'antifraud_id' => '1234-1234-1234-1234',
//         'braspag_id' => '1234-1234-1234-1234',
//         'status' => 'pendente',
//         'donation' => 0,
//         'total' => 0.00,
//         'credit_discount' => 0.00,
//         'interest_rate' => 0.00,
//         'card_boletus_rate' => 1.6,
//         'antecipation_rate' => 0.0,
//         'cpf' => '1231231233',
//         'telephone' => '48 99223300',
//         'payment_terms' => 'Boleto',
//         'history' => 'Transação iniciada em 25/10/2013 11:09',
//         'capture_date' => '2013-11-04 11:27:49',
//         'created_at' => '2014-03-27 00:00:00'
//       ],
//     ];

//     foreach ($orders as $order)
//     {
//       Order::create($order);
//     }

//   }
// }
