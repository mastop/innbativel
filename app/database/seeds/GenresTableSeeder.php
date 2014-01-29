<?php
//'genres'
class GenresTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $genres = [
      [
        'name' => 'Pacote aéreo',
        'icon_url' => '/assets/uploads/images/genres/img/ico-pacote.png',
      ],
      [
        'name' => 'Somente hospedagem',
        'icon_url' => '/assets/uploads/images/genres/img/ico-pacote.png',
      ],
    ];

    foreach ($genres as $genre)
    {
      Genre::create($genre);
    }
  }
}
