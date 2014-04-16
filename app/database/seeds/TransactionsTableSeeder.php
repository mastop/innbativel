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
        ],
        [
            'order_id' => 2,
            'changer_id' => 2,
            'status' => 'pagamento',
            'total' => 1000,
            'credit_discount' => 30,
            'coupon_discount' => 20,
        ],
        [
            'order_id' => 3,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
        ],
        [
            'order_id' => 1,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
        ],
        [
            'order_id' => 2,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
        ],
        [
            'order_id' => 3,
            'changer_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
        ],
    ];

    foreach ($transactions as $transaction)
    {
      Transaction::create($transaction);
    }
  }
}
