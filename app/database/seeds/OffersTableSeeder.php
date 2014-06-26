<?php
// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OffersTableSeeder extends DatabaseSeeder
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
//       try{
//         $stmt = $pdo->prepare('INSERT INTO offers (id, partner_id, ngo_id, category_id, title, subtitle, features, destiny_id, rules, starts_on, ends_on, slug, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//         if(!$stmt->execute($columns)){ print_r($columns); print_r($stmt->errorInfo()); }
//       }
//       catch (Exception $e) {
//         print_r($columns);
//         print_r($e->getMessage()."\n");
//       }
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/ImportacaoBDNovo/offers.csv', $interpreter);
//   }
// }

class OffersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$offers = [
	  [
		'title' => 'Florianópolis - SC',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-destaque.jpg',
		'genre_id' => 1,
		'category_id' => 1,
		'genre2_id' => 2,
		'partner_id' => 100001,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Praia do Rosa - SC',
		'subtitle' => 'Dias de sossego na maravilhosa Praia do Rosa!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-hp-01.jpg',
		'category_id' => 1,
		'genre_id' => 3,
		'partner_id' => 100002,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'is_product' => true,
	  ],
	  [
		'title' => 'Urubici - SC',
		'subtitle' => 'Garanta já dias apaixonados na Serra Catarinense! Urubici lhe aguarda com paisagens de tirar o fôlego, e muitos vinhos para degustar! Válido também em Julho!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-hp-02.jpg',
		'category_id' => 1,
		'genre_id' => 4,
		'partner_id' => 100001,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Compre sua viagem de férias e garanta momentos inesquecíveis em Santiago. Aproveite!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-pi-01.jpg',
		'category_id' => 1,
		'genre_id' => 5,
		'partner_id' => 100002,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Buenos Aires - Argentina',
		'subtitle' => 'Aproveite o feriadão de Páscoa e Tiradentes para curtir o melhor da Argentina!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-pi-02.jpg',
		'category_id' => 1,
		'genre_id' => 6,
		'partner_id' => 100001,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Bonito - MS',
		'subtitle' => 'Encante-se com Bonito, a Capital Brasileira do Ecoturismo!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-pn-01.jpg',
		'category_id' => 1,
		'genre_id' => 7,
		'partner_id' => 100002,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Chocofest em Gramado - RS',
		'subtitle' => 'Delicie-se com os melhores chocolates de Gramado e ainda participe desta linda festa!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-pn-02.jpg',
		'category_id' => 1,
		'genre_id' => 8,
		'partner_id' => 100001,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Aproveite o feriadão de Páscoa e faça sua Viagem Internacional ao Chile! Brinque na neve no Valle Nevado!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-de-01.jpg',
		'category_id' => 1,
		'genre_id' => 6,
		'partner_id' => 100002,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Campos do Jordão',
		'subtitle' => 'Aproveite e curta Campos do Jordão ainda mais! Descontos de até 50% em restaurantes, passeios e baladas. Válido na Páscoa e em JULHO!',
		'cover_img' => 'http://innbativel.brace.io/assets/uploads/oferta-home-de-02.jpg',
		'category_id' => 1,
		'genre_id' => 9,
		'genre2_id' => 10,
		'partner_id' => 100001,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	];

	foreach ($offers as $offer)
	{
	  $o = Offer::create($offer);

	  switch($o->id){
		case 2001:
			$o->group()->attach(1, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(58, array('display_order' => 3));
			$o->included()->attach(50, array('display_order' => 4));
			break;
		case 2002:
			$o->group()->attach(2, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(59, array('display_order' => 2));
			$o->included()->attach(50, array('display_order' => 3));
			break;
		case 2003:
			$o->group()->attach(2, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(60, array('display_order' => 2));
			$o->included()->attach(50, array('display_order' => 3));
			break;
		case 2004:
			$o->group()->attach(3, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 2005:
			$o->group()->attach(3, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(57, array('display_order' => 3));
			break;
		case 2006:
			$o->group()->attach(4, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 2007:
			$o->group()->attach(4, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 2008:
			$o->group()->attach(5, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(58, array('display_order' => 3));
			break;
		case 2009:
			$o->group()->attach(5, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(57, array('display_order' => 2));
			break;
	  }
	}
  }
}
