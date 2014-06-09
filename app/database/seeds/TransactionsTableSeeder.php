<?php

class TransactionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions = [
    	[
            'order_id' => 1,
            'status' => 'pagamento',
            'total' => 1101.00,
            'coupon_discount' => 100,
            'credit_discount' => 300,
            'created_at' => date('Y-m-d H:i:s',strtotime("-10 days")),
        ],
        [
            'order_id' => 2,
            'status' => 'pagamento',
            'total' => 1450.318568004,
            'coupon_discount' => 0,
            'credit_discount' => 100,
            'created_at' => date('Y-m-d H:i:s',strtotime("-11 days")),
        ],
        [
            'order_id' => 3,
            'status' => 'pagamento',
            'total' => 1593.203013,
            'coupon_discount' => 0,
            'credit_discount' => 0,
            'created_at' => date('Y-m-d H:i:s',strtotime("-12 days")),
        ],
        [
            'order_id' => 4,
            'status' => 'pagamento',
            'total' => 1648.13,
            'coupon_discount' => 0,
            'credit_discount' => 0,
            'created_at' => date('Y-m-d H:i:s',strtotime("-13 days")),
        ],
        [
            'order_id' => 5,
            'status' => 'pagamento',
            'total' => 0,
            'coupon_discount' => 100,
            'credit_discount' => 200,
            'created_at' => date('Y-m-d H:i:s',strtotime("-14 days")),
        ],
        [
            'order_id' => 6,
            'status' => 'pagamento',
            'total' => 601.00,
            'coupon_discount' => 0,
            'credit_discount' => 0,
            'created_at' => date('Y-m-d H:i:s',strtotime("-15 days")),
        ],
        [
            'order_id' => 7,
            'status' => 'pagamento',
            'total' => 280.00,
            'coupon_discount' => 100,
            'credit_discount' => 0,
            'created_at' => date('Y-m-d H:i:s',strtotime("-16 days")),
        ],
        [
            'order_id' => 8,
            'status' => 'pagamento',
            'total' => 0.00,
            'coupon_discount' => 0,
            'credit_discount' => 1500,
            'created_at' => date('Y-m-d H:i:s',strtotime("-17 days")),
        ],
        // [
        //     'order_id' => 1,
        //     'status' => 'pagamento',
        //     'total' => 1000,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-10 days")),
        // ],
        // [
        //     'order_id' => 2,
        //     'status' => 'pagamento',
        //     'total' => 1000,
        //     'credit_discount' => 30,
        //     'coupon_discount' => 20,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-11 days")),
        // ],
        // [
        //     'order_id' => 3,
        //     'status' => 'pagamento',
        //     'total' => 1000,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-13 days")),
        // ],
        // [
        //     'order_id' => 1,
        //     'status' => 'cancelamento',
        //     'total' => 1000,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-9 days")),
        // ],
        // [
        //     'order_id' => 2,
        //     'status' => 'convercao_creditos',
        //     'total' => 1000,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-7 days")),
        // ],
        // [
        //     'order_id' => 3,
        //     'status' => 'cancelamento',
        //     'total' => 1000,
        //     'created_at' => date('Y-m-d H:i:s',strtotime("-6 days")),
        // ],
    ];

    foreach ($transactions as $transaction)
    {
      Transaction::create($transaction);
    }
  }
}
