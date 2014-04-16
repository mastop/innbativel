<?php

class TransactionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions = [
    	[
            'order_id' => 1,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
            'created_at' => date('Y-m-d H:i:s',strtotime("-10 days")),
        ],
        [
            'order_id' => 2,
            'changer_id' => 2,
            'status' => 'pagamento',
            'total' => 1000,
            'credit_discount' => 30,
            'coupon_discount' => 20,
            'created_at' => date('Y-m-d H:i:s',strtotime("-11 days")),
        ],
        [
            'order_id' => 3,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
            'created_at' => date('Y-m-d H:i:s',strtotime("-13 days")),
        ],
        [
            'order_id' => 1,
            'changer_id' => 1,
            'status' => 'cancelamento',
            'total' => 1000,
            'created_at' => date('Y-m-d H:i:s',strtotime("-9 days")),
        ],
        [
            'order_id' => 2,
            'changer_id' => 1,
            'status' => 'convercao_credito',
            'total' => 1000,
            'created_at' => date('Y-m-d H:i:s',strtotime("-7 days")),
        ],
        [
            'order_id' => 3,
            'changer_id' => 1,
            'status' => 'cancelamento',
            'total' => 1000,
            'created_at' => date('Y-m-d H:i:s',strtotime("-6 days")),
        ],
    ];

    foreach ($transactions as $transaction)
    {
      Transaction::create($transaction);
    }
  }
}
