<?php
// 'tags'

class HolidaysTableSeeder extends DatabaseSeeder
{
  public function run()
  {
	$holidays = [
		[ 'title' => 'Natal', 'display_order' => 1 ],
		[ 'title' => 'Revellion', 'display_order' => 2 ],
		[ 'title' => 'Páscoa', 'display_order' => 3 ],
		[ 'title' => 'Dia do Trabalho', 'display_order' => 4 ],
	];

	foreach ($holidays as $holiday)
	{
	  Holiday::create($holiday);
	}
  }
}
