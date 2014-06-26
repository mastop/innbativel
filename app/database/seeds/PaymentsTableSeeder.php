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
//     $config->setFromCharset('UTF-8');
//     $config->setToCharset('LATIN1');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();
//     $interpreter->unstrict();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//         try{
//             $stmt = $pdo->prepare('INSERT INTO payments (id, sales_from, sales_to, date, is_sales_close) VALUES (?, ?, ?, ?, ?)');

//             $columns[4] = ($column[2] > date('Y-m-d H:i:s') ? 0 : 1;

//             if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }

//             $id = $pdo->lastInsertId();
//             $sales_to = $column[2];
//             $script_date = date('Y-m-d H:i:s', strtotime($sales_to)+1);
//             $cron_date = Crontab::date2cron($script_date);
//             $cronjob = $cron_date.' php /var/app/current/artisan fechamento '.$id;
            
//             if($sales_to > date('Y-m-d H:i:s')){
//               Crontab::addJob($cronjob);
//             }

//             $stmt_update = $pdo->prepare('UPDATE payments SET cronjob = ? WHERE id = ?');

//             $columns_update[0] = $cronjob;
//             $columns_update[1] = $id;

//             if(!$stmt_update->execute($columns_update)){ print_r($columns_update); print_r($stmt_update->errorInfo()); }

//             // Payment::where('id', $id)->update(['cronjob' => $cronjob]);
//         }
//         catch (Exception $e) {
//             print_r($columns);
//             print_r($e->getMessage()."\n");
//         }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/payments.csv', $interpreter);
//   }
// }

class PaymentsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

    $payments = [
    	 [
            'sales_from' => '2014-03-16 00:00:00',
            'sales_to' => '2014-03-31 23:59:59',
            'date' => '2014-04-15',
        ],
        [
            'sales_from' => '2014-04-01 00:00:00',
            'sales_to' => '2014-04-15 23:59:59',
            'date' => '2014-04-30',
        ],
        [
            'sales_from' => '2014-04-16 00:00:00',
            'sales_to' => '2014-04-30 23:59:59',
            'date' => '2014-05-15',
        ],
        [
            'sales_from' => '2014-05-01 00:00:00',
            'sales_to' => '2014-05-15 23:59:59',
            'date' => '2014-05-31',
        ],
        [
            'sales_from' => '2014-05-16 00:00:00',
            'sales_to' => '2014-05-31 23:59:59',
            'date' => '2014-06-15',
        ],
        [
            'sales_from' => '2014-06-01 00:00:00',
            'sales_to' => '2014-06-15 23:59:59',
            'date' => '2014-05-30',
        ],
    ];

    foreach ($payments as $payment)
    {
      $id = Payment::create($payment)->id;

      $script_date = date('Y-m-d H:i:s', strtotime($payment['sales_to'])+1);
      $cron_date = Crontab::date2cron($script_date);
      $cronjob = $cron_date.' php /var/app/current/artisan fechamento '.$id.' --env=local';
      Crontab::addJob($cronjob);

      Payment::where('id', $id)->update(['cronjob' => $cronjob]);
    }
  }
}
