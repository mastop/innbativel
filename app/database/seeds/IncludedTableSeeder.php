<?php
// 'included'

class IncludedTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$includeds = [
		[ 'id' => 21, 'title' => 'instrutor', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 20, 'title' => 'lanche', 				'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 63, 'title' => '10 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 64, 'title' => '1 diária', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 62, 'title' => '4 pessoas', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 22, 'title' => 'embar-cação', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 23, 'title' => 'equipa-mento', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 24, 'title' => 'aula teórica', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 25, 'title' => 'guia de turismo', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 26, 'title' => 'ingresso incluso', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 27, 'title' => 'passeio incluso', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 28, 'title' => 'aluguel de carro', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 29, 'title' => 'transfer privativo', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 30, 'title' => 'transfer regular', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 31, 'title' => 'restaurante', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 32, 'title' => 'estacio-namento', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 33, 'title' => 'wireless', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 34, 'title' => 'biblioteca', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 35, 'title' => 'lareira', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 36, 'title' => 'sala de dvd', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 37, 'title' => 'sala de jogos', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 38, 'title' => 'fitness', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 39, 'title' => 'spa', 				'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 40, 'title' => 'sauna', 				'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 41, 'title' => 'jacuzzi', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 42, 'title' => 'piscina', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 43, 'title' => 'vista montanha', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 44, 'title' => 'vista lago', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 45, 'title' => 'vista mar', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 46, 'title' => 'varanda', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 47, 'title' => 'all inclusive', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 48, 'title' => 'jantar', 				'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 49, 'title' => 'almoço', 				'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 50, 'title' => 'café da manhã', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 51, 'title' => '1 criança grátis', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 52, 'title' => '2crianças grátis', 	'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 53, 'title' => '2 pessoas', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 54, 'title' => '1 pessoa', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 55, 'title' => '7 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 56, 'title' => '6 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 57, 'title' => '5 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 58, 'title' => '4 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 59, 'title' => '3 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 60, 'title' => '2 diárias', 			'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
		[ 'id' => 61, 'title' => 'vista campo', 		'icon' => '<span class="entypo">✈</span>', 'description' => '', ],
	];

    foreach ($includeds as $included)
    {
      Included::create($included);
    }
  }
}
