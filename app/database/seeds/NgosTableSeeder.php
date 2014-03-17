<?php

class NgosTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $ongs = [
      [
        'id' => 5,
        'name' => 'ECOA',
        'description' => 'Ajude o planeta!',
        'img' => '/assets/uploads/images/ngos/img/ecoa-23-anos.jpg',
      ],
      [
        'id' => 6,
        'name' => 'CARE',
        'description' => 'Ajude o planeta!',
        'img' => '/assets/uploads/images/ngos/img/ecoa-23-anos.jpg',
      ],
    ];

    foreach ($ongs as $ong)
    {
      Ngo::create($ong);
    }
  }
}
