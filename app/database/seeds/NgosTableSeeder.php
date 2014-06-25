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
        'img' => '//innbativel.s3.amazonaws.com/ecoa.jpg',
      ],
      [
        'id' => 6,
        'name' => 'CARE',
        'description' => 'Ajude o planeta!',
        'img' => '//innbativel.s3.amazonaws.com/ecoa.jpg',
      ],
    ];

    foreach ($ongs as $ong)
    {
      Ngo::create($ong);
    }
  }
}
