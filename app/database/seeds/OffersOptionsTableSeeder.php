<?php
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

class OffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	// $sql = File::get(app_path() . '/database/seeds/assets/ImportacaoBDNovo/sql/offersOptions.sql');
	// DB::statement($sql);

    $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

    $config = new LexerConfig();
    $config->setFromCharset('UTF-8');
    $config->setToCharset('LATIN1');
    $lexer = new Lexer($config); //ISO8591 ou UTF-8

    $interpreter = new Interpreter();
    $interpreter->unstrict();

    $interpreter->addObserver(function(array $columns) use ($pdo) {
        try{
    		$stmt = $pdo->prepare('INSERT INTO offers_options (id, offer_id, title, price_with_discount, max_qty, min_qty, voucher_validity_start, voucher_validity_end, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
        }
        catch (Exception $e) {
            print_r($columns);
            print_r($e->getMessage()."\n");
        }
    });

    $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/offers_options.csv', $interpreter);
  }
}

// class OffersOptionsTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {

// 	$offers_options = [
// 	  [
// 		'price_original' => 1498.00,
// 		'price_with_discount' => 696.00,
// 		'percent_off' => 54,
// 		'offer_id' => 2001,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 640.00,
// 		'price_with_discount' => 299.00,
// 		'percent_off' => 53,
// 		'offer_id' => 2002,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 1200.00,
// 		'price_with_discount' => 600.00,
// 		'percent_off' => 50,
// 		'offer_id' => 2003,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 400.00,
// 	  ],
// 	  [
// 		'price_original' => 2498.00,
// 		'price_with_discount' => 999.00,
// 		'percent_off' => 60,
// 		'offer_id' => 2004,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 2798.00,
// 		'price_with_discount' => 1099.00,
// 		'percent_off' => 61,
// 		'offer_id' => 2005,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 1392.00,
// 		'price_with_discount' => 596.00,
// 		'percent_off' => 57,
// 		'offer_id' => 2006,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 1392.00,
// 		'price_with_discount' => 696.00,
// 		'percent_off' => 50,
// 		'offer_id' => 2007,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 3598.00,
// 		'price_with_discount' => 1499.00,
// 		'percent_off' => 58,
// 		'offer_id' => 2008,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 100.00,
// 	  ],
// 	  [
// 		'price_original' => 790.00,
// 		'price_with_discount' => 380.00,
// 		'percent_off' => 58,
// 		'offer_id' => 2009,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 300.00,
// 	  ],
// 	  [
// 		'price_original' => 1200.00,
// 		'price_with_discount' => 600.00,
// 		'percent_off' => 50,
// 		'offer_id' => 2009,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 400.00,
// 	  ],
// 	  [
// 		'price_original' => 600.00,
// 		'price_with_discount' => 300.00,
// 		'percent_off' => 50,
// 		'offer_id' => 2009,
// 		'title' => 'Teste',
// 		'subtitle' => 'Teste',
// 		'min_qty' => 10,
// 		'max_qty' => 100,
// 		'max_qty_per_buyer' => 20,
// 		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
// 		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
// 		'transfer' => 200.00,
// 	  ],
// 	];

// 	foreach ($offers_options as $offer_option)
// 	{
// 	  OfferOption::create($offer_option);
// 	}
//   }
// }
