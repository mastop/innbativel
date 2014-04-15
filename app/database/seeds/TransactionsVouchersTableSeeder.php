<?php

class TransactionsVouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions_vouchers = [
    	[
    		'transaction_id' => 1,
            'voucher_id' => 1,
    	],
    ];

    foreach ($transactions_vouchers as $transaction_voucher)
    {
      TransactionVoucher::create($transaction_voucher);
    }
  }
}
