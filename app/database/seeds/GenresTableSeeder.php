<?php
//'genres'
class GenresTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$genres = [
	  [ // 1
		'title' => 'Período Limitado',
		'icon' => '<span class="entypo clock"></span>',
	  ],
	  [ // 2
		'title' => 'Viaje na Páscoa ou no Dia do Trabalho',
		'icon' => '<span class="entypo calendar"></span>',
	  ],
	  [ // 3
		'title' => 'Recomendado',
		'icon' => '<span class="entypo thumbs-up"></span>',
	  ],
	  [ // 4
		'title' => 'Novidade',
		'icon' => '<span class="entypo new"></span>',
	  ],
	  [ // 5
		'title' => 'Viaje nas férias',
		'icon' => '<span class="entypo calendar"></span>',
	  ],
	  [ // 6
		'title' => 'Viaje na Páscoa',
		'icon' => '<span class="entypo calendar"></span>',
	  ],
	  [ // 7
		'title' => 'Ecoturismo',
		'icon' => '<span class="entypo leaf"></span>',
	  ],
	  [ // 8
		'title' => 'Campeão de vendas',
		'icon' => '<span class="entypo star"></span>',
	  ],
	  [ // 9
		'title' => 'Viaje na Páscoa e em Julho',
		'icon' => '<span class="entypo calendar"></span>',
	  ],
	  [ // 10
		'title' => 'Preço INNBatível!',
		'icon' => '<span class="entypo trophy"></span>',
	  ],
	];

	foreach ($genres as $genre)
	{
	  Genre::create($genre);
	}
  }
}
