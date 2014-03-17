<?php
// 'groups'

class GroupsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$groups = [
		[
			'title' => 'Principal',
			'url' => '#',
			'display_order' => '1',
		],
		[
			'title' => 'Confira Hotéis e Pousadas de qualidade pelo menor preço',
			'url' => '#',
			'display_order' => '2',
		],
		[
			'title' => 'Pacotes Internacionais: viaje agora para o exterior',
			'url' => '#',
			'display_order' => '3',
		],
		[
			'title' => 'Curta o Brasil com estes Pacotes Nacionais INNBatíveis',
			'url' => '#',
			'display_order' => '4',
		],
		[
			'title' => 'Férias, feriados, feriadões: encontre ofertas em datas especiais',
			'url' => '#',
			'display_order' => '5',
		],
	];

	foreach ($groups as $group)
	{
		Group::create($group);
	}
  }
}
