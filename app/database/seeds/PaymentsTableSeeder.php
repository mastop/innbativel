<?php

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class PaymentsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         $stmt = $pdo->prepare('INSERT INTO payments (id, sales_from, sales_to, date) VALUES (?, ?, ?, ?)');

//         if(!$stmt->execute($columns)){ print_r($stmt->errorInfo()); }

//         $id = $pdo->lastInsertId();
//         $sales_to = $column[2];
//         $script_date = date('Y-m-d H:i:s', strtotime($sales_to)+1);
//         $cron_date = Crontab::date2cron($script_date);
//         $cronjob = $cron_date.' php /Applications/MAMP/htdocs/innbativel/artisan fechamento '.$id.' --env=local';
//         Crontab::addJob($cronjob);

//         $stmt_update = $pdo->prepare('UPDATE payments SET cronjob = ? WHERE id = ?');

//         $columns_update[0] = $cronjob;
//         $columns_update[1] = $id;

//         if(!$stmt_update->execute($columns_update)){ print_r($stmt_update->errorInfo()); }

//         // Payment::where('id', $id)->update(['cronjob' => $cronjob]);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/payments.csv', $interpreter);
//   }
// }

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
