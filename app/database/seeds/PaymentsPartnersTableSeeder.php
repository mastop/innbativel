<?php

class PaymentsPartnersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments_partners = [
    	[
    		'payment_id' => 1,
    		'partner_id' => 1,
    		'total' => 2000,
    	],
    	[
    		'payment_id' => 1,
    		'partner_id' => 2,
    		'total' => 2000,
    	],
    ];

    foreach ($payments_partners as $payment_partner)
    {
      PaymentPartner::create($payment_partner);
    }
  }
}
