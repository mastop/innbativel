<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

/*
class OffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$sql = File::get(app_path() . '/database/seeds/assets/sql/offersOptions.sql');
	DB::statement($sql);

  //   $pdo = new PDO('mysql:host='.Config::get('database.connections.mysql.host').';dbname='.Config::get('database.connections.mysql.database'), Config::get('database.connections.mysql.username'), Config::get('database.connections.mysql.password'));

  //   $config = new LexerConfig();
  //   $config->setToCharset('UTF-8');
  //   $lexer = new Lexer($config); //ISO8591 ou UTF-8

  //   $interpreter = new Interpreter();

  //   $interpreter->addObserver(function(array $columns) use ($pdo) {
  //   	// o último item contém o id dos included, separados por "|" ... é necessário removê-los dessa array e armazená-los,
  //   	// pois iremos inserí-los na sua devida tabela depois de inserir a opção de oferta
  //   	$codigos_inclusos = array_pop($columns);

		// $stmt = $pdo->prepare('INSERT INTO offers_options (id, offer_id, title, price_with_discount, max_qty, max_qty_per_buyer, min_qty, voucher_validity_start, voucher_validity_end, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  //       if(!$stmt->execute($columns)) print_r($stmt->errorInfo());

  //       $id = $columns[0];
  //       $codigos_inclusos = explode("|", $codigos_inclusos);

  //       $included = '';

  //       foreach ($codigos_inclusos as $order => $code) {
  //       	$included .= '($id, $code, $order),';
  //       }

  //       $included = substr_replace($included, "", -1);

  //       $stmt = $pdo->prepare('INSERT INTO offers_options_included (offer_option_id, included_id, display_order) VALUES $included');
  //       $stmt->execute();
  //   });

  //   $lexer->parse(app_path().'/database/seeds/assets/offers_options.csv', $interpreter);
  }
}
*/
class OffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$offers_options = [
	  [
		'price_original' => 1498.00,
		'price_with_discount' => 696.00,
		'percent_off' => 54,
		'offer_id' => 1,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 640.00,
		'price_with_discount' => 299.00,
		'percent_off' => 53,
		'offer_id' => 2,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1200.00,
		'price_with_discount' => 600.00,
		'percent_off' => 50,
		'offer_id' => 3,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 400.00,
	  ],
	  [
		'price_original' => 2498.00,
		'price_with_discount' => 999.00,
		'percent_off' => 60,
		'offer_id' => 4,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 2798.00,
		'price_with_discount' => 1099.00,
		'percent_off' => 61,
		'offer_id' => 5,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1392.00,
		'price_with_discount' => 596.00,
		'percent_off' => 57,
		'offer_id' => 6,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1392.00,
		'price_with_discount' => 696.00,
		'percent_off' => 50,
		'offer_id' => 7,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 3598.00,
		'price_with_discount' => 1499.00,
		'percent_off' => 58,
		'offer_id' => 8,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 790.00,
		'price_with_discount' => 380.00,
		'percent_off' => 58,
		'offer_id' => 9,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 300.00,
	  ],
	  [
		'price_original' => 1200.00,
		'price_with_discount' => 600.00,
		'percent_off' => 50,
		'offer_id' => 9,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 400.00,
	  ],
	  [
		'price_original' => 600.00,
		'price_with_discount' => 300.00,
		'percent_off' => 50,
		'offer_id' => 9,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 200.00,
	  ],
	];

	foreach ($offers_options as $offer_option)
	{
	  OfferOption::create($offer_option);
	}
  }
}
