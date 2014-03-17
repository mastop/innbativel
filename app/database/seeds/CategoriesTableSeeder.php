<?php
//'categories'
class CategoriesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $categories = [
      [
        'title' => 'Hotéis & Pousadas',
        'slug' => 'hoteis-e-pousadas',
        'display_order' => 1,
      ],
      [
        'title' => 'Pacotes Nacionais',
        'slug' => 'pacotes-nacionais',
        'display_order' => 2,
      ],
      [
        'title' => 'Pacotes Internacionais',
        'slug' => 'pacotes-internacionais',
        'display_order' => 3,
      ],
      [
        'title' => 'Feriados',
        'slug' => 'feriados',
        'display_order' => 4,
      ],
      [
        'title' => 'Passeios',
        'slug' => 'passeios',
        'display_order' => 5,
      ],
	  [
        'title' => 'Pacotes especiais',
        'slug' => 'pacotes-especiais',
        'display_order' => 6,
      ],
    ];

    foreach ($categories as $category)
    {
      Category::create($category);
    }
  }
}
