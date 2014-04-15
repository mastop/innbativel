<?php

class TransactionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions = [
    	[
            'order_id' => 1,
            'payment_partner_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
            'credit_discount' => 30,
            'coupon_discount' => 20,
        ],
        [
            'order_id' => 2,
            'payment_partner_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
            'credit_discount' => 30,
            'coupon_discount' => 20,
        ],
        [
            'order_id' => 3,
            'payment_partner_id' => 1,
            'status' => 'pagamento',
            'total' => 1000,
            'credit_discount' => 30,
            'coupon_discount' => 20,
        ],
    ];

    foreach ($transactions as $transaction)
    {
      Transaction::create($transaction);
    }
  }
}
