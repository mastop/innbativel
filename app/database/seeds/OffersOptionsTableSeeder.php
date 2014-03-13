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

  //   $pdo = new PDO('mysql:host=innbativel.ctypvw54pblq.us-east-1.rds.amazonaws.com;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

  //   $config = new LexerConfig();
  //   $config->setToCharset('UTF-8');
  //   $lexer = new Lexer($config); //ISO8591 ou UTF-8

  //   $interpreter = new Interpreter();

  //   $interpreter->addObserver(function(array $columns) use ($pdo) {
  //   	// o último item contém o id dos included, separados por "|" ... é necessário removê-los dessa array e armazená-los,
  //   	// pois iremos inserí-los na sua devida tabela depois de inserir a opção de oferta
  //   	$codigos_inclusos = array_pop($columns);

		// $stmt = $pdo->prepare('INSERT INTO offers_options (id, offer_id, title, price_with_discount, max_qty, max_qty_per_buyer, min_qty, voucher_validity_start, voucher_validity_end, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  //       $stmt->execute($columns);

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
		'price_original' => 149800,
		'price_with_discount' => 69600,
		'percent_off' => 54,
		'offer_id' => 1,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 64000,
		'price_with_discount' => 29900,
		'percent_off' => 53,
		'offer_id' => 2,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 60000,
		'price_with_discount' => 29900,
		'percent_off' => 50,
		'offer_id' => 3,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 249800,
		'price_with_discount' => 99900,
		'percent_off' => 60,
		'offer_id' => 4,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 279800,
		'price_with_discount' => 109900,
		'percent_off' => 61,
		'offer_id' => 5,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 139200,
		'price_with_discount' => 59600,
		'percent_off' => 57,
		'offer_id' => 6,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 139200,
		'price_with_discount' => 69600,
		'percent_off' => 50,
		'offer_id' => 7,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 359800,
		'price_with_discount' => 149900,
		'percent_off' => 58,
		'offer_id' => 8,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'price_original' => 38000,
		'price_with_discount' => 15900,
		'percent_off' => 58,
		'offer_id' => 9,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'max_qty_per_buyer' => 20,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	];

	foreach ($offers_options as $offer_option)
	{
	  $op = OfferOption::create($offer_option);

	  switch($op->id){
		case 1:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(58, array('display_order' => 3,'display_home' => true));
			$op->included->attach(50, array('display_order' => 4,'display_home' => true));
			break;
		case 2:
			$op->included->attach(53, array('display_order' => 1,'display_home' => true));
			$op->included->attach(59, array('display_order' => 2,'display_home' => true));
			$op->included->attach(50, array('display_order' => 3,'display_home' => true));
			break;
		case 3:
			$op->included->attach(53, array('display_order' => 1,'display_home' => true));
			$op->included->attach(60, array('display_order' => 2,'display_home' => true));
			$op->included->attach(50, array('display_order' => 3,'display_home' => true));
			break;
		case 4:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(59, array('display_order' => 3,'display_home' => true));
			break;
		case 5:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(57, array('display_order' => 3,'display_home' => true));
			break;
		case 6:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(59, array('display_order' => 3,'display_home' => true));
			break;
		case 7:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(59, array('display_order' => 3,'display_home' => true));
			break;
		case 8:
			$op->included->attach(65, array('display_order' => 1,'display_home' => true));
			$op->included->attach(54, array('display_order' => 2,'display_home' => true));
			$op->included->attach(58, array('display_order' => 3,'display_home' => true));
			break;
		case 9:
			$op->included->attach(53, array('display_order' => 1,'display_home' => true));
			$op->included->attach(57, array('display_order' => 2,'display_home' => true));
			break;
	  }
	}
  }
}
