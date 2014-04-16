<?php

class TransactionsVouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $transactions_vouchers = [
    	[
            'transaction_id' => 1,
            'voucher_id' => 1,
            'payment_partner_id' => 1,
        ],
        [
            'transaction_id' => 1,
            'voucher_id' => 2,
            'payment_partner_id' => 1,
        ],
        [
            'transaction_id' => 1,
            'voucher_id' => 3,
            'payment_partner_id' => 1,
        ],
        [
            'transaction_id' => 1,
            'voucher_id' => 4,
            'payment_partner_id' => 1,
        ],
        //////////////////////////////
        [
            'transaction_id' => 2,
            'voucher_id' => 5,
            'payment_partner_id' => 1,
        ],
        [
            'transaction_id' => 2,
            'voucher_id' => 6,
            'payment_partner_id' => 1,
        ],
        [
            'transaction_id' => 2,
            'voucher_id' => 7,
            'payment_partner_id' => 1,
        ],
        //////////////////////////////
        [
            'transaction_id' => 3,
            'voucher_id' => 8,
            'payment_partner_id' => 2,
        ],
        [
            'transaction_id' => 3,
            'voucher_id' => 9,
            'payment_partner_id' => 2,
        ],
        [
            'transaction_id' => 3,
            'voucher_id' => 10,
            'payment_partner_id' => 2,
        ],
        [
            'transaction_id' => 3,
            'voucher_id' => 11,
            'payment_partner_id' => 2,
        ],
        //////////////////////////////
        [
            'transaction_id' => 4,
            'voucher_id' => 3,
            'payment_partner_id' => 1,
            'status' => 'cancelamento',
        ],
        //////////////////////////////
        [
            'transaction_id' => 5,
            'voucher_id' => 5,
            'status' => 'cancelamento',
        ],
        //////////////////////////////
        [
            'transaction_id' => 6,
            'voucher_id' => 8,
            'status' => 'cancelamento',
        ],
        [
            'transaction_id' => 6,
            'voucher_id' => 9,
            'status' => 'cancelamento',
        ],
        [
            'transaction_id' => 6,
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
