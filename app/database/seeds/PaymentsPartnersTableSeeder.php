<?php

class PaymentsPartnersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments_partners = [
    ];

    foreach ($payments_partners as $payment_partner)
    {
      PaymentPartner::create($payment_partner);
    }
  }
}
