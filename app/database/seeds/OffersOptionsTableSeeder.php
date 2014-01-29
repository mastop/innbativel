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

//   	$todos_inclusos = array(
// 	  21 => 'instrutor',
// 	  20 => 'lanche',
// 	  63 => '10 diárias',
// 	  64 => '1 diária',
// 	  62 => '4 pessoas',
// 	  22 => 'embar-cação',
// 	  23 => 'equipa-mento',
// 	  24 => 'aula teórica',
// 	  25 => 'guia de turismo',
// 	  26 => 'ingresso incluso',
// 	  27 => 'passeio incluso',
// 	  28 => 'aluguel de carro',
// 	  29 => 'transfer privativo',
// 	  30 => 'transfer regular',
// 	  31 => 'restaurante',
// 	  32 => 'estacio-namento',
// 	  33 => 'wireless',
// 	  34 => 'biblioteca',
// 	  35 => 'lareira',
// 	  36 => 'sala de dvd',
// 	  37 => 'sala de jogos',
// 	  38 => 'fitness',
// 	  39 => 'spa',
// 	  40 => 'sauna',
// 	  41 => 'jacuzzi',
// 	  42 => 'piscina',
// 	  43 => 'vista montanha',
// 	  44 => 'vista lago',
// 	  45 => 'vista mar',
// 	  46 => 'varanda',
// 	  47 => 'all inclusive',
// 	  48 => 'jantar',
// 	  49 => 'almoço',
// 	  50 => 'café da manhã',
// 	  51 => '1 criança grátis',
// 	  52 => '2crianças grátis',
// 	  53 => '2 pessoas',
// 	  54 => '1 pessoa',
// 	  55 => '7 diárias',
// 	  56 => '6 diárias',
// 	  57 => '5 diárias',
// 	  58 => '4 diárias',
// 	  59 => '3 diárias',
// 	  60 => '2 diárias',
// 	  61 => 'vista campo',
// 	);

//     $pdo = new PDO('mysql:host=localhost;dbname=innbativel', 'root', '');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	$codigos_inclusos = explode("|", $columns[10]);
//     	$columns[10] = '<ul>';

//     	foreach ($codigos_inclusos as $cod) {
//     		$columns[10] .= '<il>' . $todos_inclusos[$cod] . '</il>';
//     	}

//     	$columns .= '</ul>';

//         $stmt = $pdo->prepare('INSERT INTO offers_options (id, offer_id, title, price_with_discount, max_qty, max_qty_per_buyer, min_qty, voucher_validity_start, voucher_validity_end, display_order, included) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/offers_options.csv', $interpreter);
  }
}
