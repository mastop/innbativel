<?php

class PaymentsPartnersVouchersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments_partners_vouchers = [
    ];

    foreach ($payments_partners_vouchers as $payment_partner_voucher)
    {
      PaymentPartnerVoucher::create($payment_partner_voucher);
    }
  }
}
