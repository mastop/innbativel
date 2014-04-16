<?php

class PaymentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments = [
    	[
    		'sales_from' => '2014-03-15 00:00:00',
    		'sales_to' => '2014-03-31 23:59:59',
    		'date' => '2014-04-15',
    	],
    	[
    		'sales_from' => '2014-04-01 00:00:00',
    		'sales_to' => '2014-04-15 23:59:59',
    		'date' => '2014-04-30',
    	],
    	[
    		'sales_from' => '2014-04-15 00:00:00',
    		'sales_to' => '2014-04-30 23:59:59',
    		'date' => '2014-05-15',
    	],
    	[
    		'sales_from' => '2014-05-01 00:00:00',
    		'sales_to' => '2014-05-15 23:59:59',
    		'date' => '2014-05-31',
    	],
    	[
    		'sales_from' => '2014-05-15 00:00:00',
    		'sales_to' => '2014-05-30 23:59:59',
    		'date' => '2014-06-15',
    	],
    	[
    		'sales_from' => '2014-06-01 00:00:00',
    		'sales_to' => '2014-06-15 23:59:59',
    		'date' => '2014-06-30',
    	],
    ];

    foreach ($payments as $payment)
    {
      Payment::create($payment);
    }
  }
}
