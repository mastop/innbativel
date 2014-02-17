<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

class OffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$sql = File::get(app_path() . '/database/seeds/assets/sql/offersOptions.sql');
	DB::statement($sql);

  //   $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

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
