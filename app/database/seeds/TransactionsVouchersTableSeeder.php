<?php

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
