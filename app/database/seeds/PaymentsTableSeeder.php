<?php

class PaymentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments = [
    ];

    foreach ($payments as $payment)
    {
      Payment::create($payment);
    }
  }
}
