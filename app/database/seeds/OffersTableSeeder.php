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
	  ],
	  [
		'title' => 'Praia do Rosa - SC',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-hp-01.jpg',
		'genre_id' => 3,
	  ],
	  [
		'title' => 'Urubici - SC',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-hp-02.jpg',
		'genre_id' => 4,
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pi-01.jpg',
		'genre_id' => 5,
	  ],
	  [
		'title' => 'Buenos Aires - Argentina',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pi-02.jpg',
		'genre_id' => 6,
	  ],
	  [
		'title' => 'Bonito - MS',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pn-01.jpg',
		'genre_id' => 7,
	  ],
	  [
		'title' => 'Chocofest em Gramado - RS',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-pn-02.jpg',
		'genre_id' => 8,
	  ],
	  [
		'title' => 'Santiago do Chile',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-de-01.jpg',
		'genre_id' => 6,
	  ],
	  [
		'title' => 'Campos do Jordão',
		'subtitle' => 'Aproveite os feriadões de Páscoa ou Dia do Trabalho (1º de Maio) e conheça Florianópolis, a Ilha da Magia!',
		'cover_img' => 'http://innbativel.kissr.com/assets/uploads/oferta-home-de-02.jpg',
		'genre_id' => 9,
	  ],
	];

	foreach ($offers as $offer)
	{
	  $o = Offer::create($offer);

	  switch($o->id){
		case 1: $o->group()->attach(1, array('display_order' => $o->id)); break;
		case 2: $o->group()->attach(2, array('display_order' => $o->id)); break;
		case 3: $o->group()->attach(2, array('display_order' => $o->id)); break;
		case 4: $o->group()->attach(3, array('display_order' => $o->id)); break;
		case 5: $o->group()->attach(3, array('display_order' => $o->id)); break;
		case 6: $o->group()->attach(4, array('display_order' => $o->id)); break;
		case 7: $o->group()->attach(4, array('display_order' => $o->id)); break;
		case 8: $o->group()->attach(5, array('display_order' => $o->id)); break;
		case 9: $o->group()->attach(5, array('display_order' => $o->id)); break;
	  }
	}
  }
}
