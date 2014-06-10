<?php

class BannersTableSeeder extends DatabaseSeeder
{
	public function run()
	{
		$banners = [
			[
				'img' => 'http://innbativel.brace.io/assets/uploads/banner1.jpg',
				'link' => '#',
				'title' => 'Feriadão em Montevideo, Buenos Aires e Punta del Este',
				'subtitle' => 'No seu feriado de 1º de Maio, dia do trabalho, aventure-se pela América do Sul!',
			],
			[
				'img' => 'http://innbativel.brace.io/assets/uploads/oferta-home.jpg',
				'link' => '#',
				'title' => 'Reveillon em Floripa',
				'subtitle' => 'Curta o Reveillon na Ilha da Magia!',
			],
			[
				'img' => 'http://innbativel.brace.io/assets/uploads/banner3.jpg',
				'link' => '#',
				'title' => 'Destinos românticos para casais',
				'subtitle' => 'Confira ofertas com destinos românticos para casais em Lua de Mel',
			],
		];

		foreach ($banners as $banner)
		{
			Banner::create($banner);
		}
	}
}
