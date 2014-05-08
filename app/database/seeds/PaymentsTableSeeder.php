<?php

class PaymentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments = [
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
      $id = Payment::create($payment)->id;

      $script_date = date('Y-m-d H:i:s', strtotime($payment['sales_to'])+1);
      $cron_date = Crontab::date2cron($script_date);
      $cronjob = $cron_date.' php /Applications/MAMP/htdocs/innbativel/artisan fechamento '.$id.' --env=local';
      Crontab::addJob($cronjob);

      Payment::where('id', $id)->update(['cronjob' => $cronjob]);
    }
  }
}
