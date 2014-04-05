<?php
// 'offers' e 'offers_additional'

// use Goodby\CSV\Import\Standard\Lexer;
// use Goodby\CSV\Import\Standard\Interpreter;
// use Goodby\CSV\Import\Standard\LexerConfig;

// class OffersTableSeeder extends DatabaseSeeder
// {
//   public function run()
//   {
//     $pdo = new PDO('mysql:host=innbativel.ctypvw54pblq.us-east-1.rds.amazonaws.com;dbname=innbativel', 'innbativel', 'aWdh2kHAF6A3');

//     $config = new LexerConfig();
//     $config->setToCharset('UTF-8');
//     $lexer = new Lexer($config); //ISO8591 ou UTF-8

//     $interpreter = new Interpreter();

//     $interpreter->addObserver(function(array $columns) use ($pdo) {
//     	$stmt = $pdo->prepare('INSERT INTO offers (id, partner_id, ngo_id, title, subtitle, description, destiny, saveme_title, general_rules, starts_on, ends_on, cover_img, offer_old_img, newsletter_img, saveme_img, video, slug, display_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//         $stmt->execute($columns);
//     });

//     $lexer->parse(app_path().'/database/seeds/assets/offers.csv', $interpreter);
//   }
// }

/*
class OffersTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$sql = File::get(app_path() . '/database/seeds/assets/sql/offers.sql');
	DB::statement($sql);
  }
}
*/

class OffersTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$offers = [
	  [
		'title' => 'Florianópolis - SC',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-destaque.jpg',
		'genre_id' => 1,
		'category_id' => 1,
		'genre2_id' => 2,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Praia do Rosa - SC',
		'subtitle' => 'Dias de sossego na maravilhosa Praia do Rosa!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-hp-01.jpg',
		'category_id' => 1,
		'genre_id' => 3,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Urubici - SC',
		'subtitle' => 'Garanta já dias apaixonados na Serra Catarinense! Urubici lhe aguarda com paisagens de tirar o fôlego, e muitos vinhos para degustar! Válido também em Julho!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-hp-02.jpg',
		'category_id' => 1,
		'genre_id' => 4,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Compre sua viagem de férias e garanta momentos inesquecíveis em Santiago. Aproveite!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pi-01.jpg',
		'category_id' => 1,
		'genre_id' => 5,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Buenos Aires - Argentina',
		'subtitle' => 'Aproveite o feriadão de Páscoa e Tiradentes para curtir o melhor da Argentina!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pi-02.jpg',
		'category_id' => 1,
		'genre_id' => 6,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Bonito - MS',
		'subtitle' => 'Encante-se com Bonito, a Capital Brasileira do Ecoturismo!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pn-01.jpg',
		'category_id' => 1,
		'genre_id' => 7,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Chocofest em Gramado - RS',
		'subtitle' => 'Delicie-se com os melhores chocolates de Gramado e ainda participe desta linda festa!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pn-02.jpg',
		'category_id' => 1,
		'genre_id' => 8,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Aproveite o feriadão de Páscoa e faça sua Viagem Internacional ao Chile! Brinque na neve no Valle Nevado!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-de-01.jpg',
		'category_id' => 1,
		'genre_id' => 6,
		'partner_id' => 1,
		'ngo_id' => 5,
		'destiny_id' => 1,
		'starts_on' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'ends_on' => date('Y-m-d H:i:s',strtotime("+30 days")),
	  ],
	  [
		'title' => 'Campos do Jordão',
		'subtitle' => 'Aproveite e curta Campos do Jordão ainda mais! Descontos de até 50% em restaurantes, passeios e baladas. Válido na Páscoa e em JULHO!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-de-02.jpg',
		'category_id' => 1,
		'genre_id' => 9,
		'genre2_id' => 10,
		'partner_id' => 1,
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
		case 1: 
			$o->group()->attach(1, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(58, array('display_order' => 3));
			$o->included()->attach(50, array('display_order' => 4));
			break;
		case 2:
			$o->group()->attach(2, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(59, array('display_order' => 2));
			$o->included()->attach(50, array('display_order' => 3));
			break;
		case 3:
			$o->group()->attach(2, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(60, array('display_order' => 2));
			$o->included()->attach(50, array('display_order' => 3));
			break;
		case 4:
			$o->group()->attach(3, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 5:
			$o->group()->attach(3, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(57, array('display_order' => 3));
			break;
		case 6: 
			$o->group()->attach(4, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 7:
			$o->group()->attach(4, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(59, array('display_order' => 3));
			break;
		case 8:
			$o->group()->attach(5, array('display_order' => $o->id)); 

			$o->included()->attach(65, array('display_order' => 1));
			$o->included()->attach(54, array('display_order' => 2));
			$o->included()->attach(58, array('display_order' => 3));
			break;
		case 9:
			$o->group()->attach(5, array('display_order' => $o->id)); 

			$o->included()->attach(53, array('display_order' => 1));
			$o->included()->attach(57, array('display_order' => 2));
			break;
	  }
	}
  }
}
