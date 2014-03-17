<?php
//'subcategories'
class SubcategoriesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $subcategories = [
      [
        'category_id' => 1,
        'title' => 'Praia',
        'is_active' => true,
        'display_order' => 1,
      ],
      [
        'category_id' => 1,
        'title' => 'Campo',
        'is_active' => true,
        'display_order' => 2,
      ],
      [
        'category_id' => 1,
        'title' => 'Serra/Montanha',
        'is_active' => true,
        'display_order' => 3,
      ],
      [
        'category_id' => 1,
        'title' => 'Termas',
        'is_active' => true,
        'display_order' => 4,
      ],
      [
        'category_id' => 1,
        'title' => 'Ecológico',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 2,
        'title' => 'Florianópolis',
        'is_active' => true,
        'display_order' => 1,
      ],
      [
        'category_id' => 2,
        'title' => 'Beto Carrero',
        'is_active' => true,
        'display_order' => 2,
      ],
      [
        'category_id' => 2,
        'title' => 'Porto Seguro',
        'is_active' => true,
        'display_order' => 3,
      ],
      [
        'category_id' => 2,
        'title' => 'Serra Gaúcha',
        'is_active' => true,
        'display_order' => 4,
      ],
      [
        'category_id' => 2,
        'title' => 'Bonito',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 2,
        'title' => 'Foz do Iguaçu',
        'is_active' => true,
        'display_order' => 6,
      ],
      [
        'category_id' => 3,
        'title' => 'Buenos Aires',
        'is_active' => true,
        'display_order' => 1,
      ],
      [
        'category_id' => 3,
        'title' => 'Chile',
        'is_active' => true,
        'display_order' => 2,
      ],
      [
        'category_id' => 3,
        'title' => 'Miami & Orlando',
        'is_active' => true,
        'display_order' => 3,
      ],
      [
        'category_id' => 4,
        'title' => 'Natal',
        'is_active' => true,
        'display_order' => 1,
      ],
      [
        'category_id' => 4,
        'title' => 'Réveillon',
        'is_active' => true,
        'display_order' => 2,
      ],
      [
        'category_id' => 4,
        'title' => 'Carnaval',
        'is_active' => true,
        'display_order' => 3,
      ],
      [
        'category_id' => 4,
        'title' => 'Páscoa',
        'is_active' => true,
        'display_order' => 4,
      ],
      [
        'category_id' => 4,
        'title' => '1º de Maio',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 4,
        'title' => 'Corpus Christi',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 5,
        'title' => 'Lua de Mel',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 5,
        'title' => 'Surf',
        'is_active' => true,
        'display_order' => 5,
      ],
      [
        'category_id' => 5,
        'title' => '3ª Idade',
        'is_active' => true,
        'display_order' => 5,
      ],
    ];

    foreach ($subcategories AS $subcategory)
    {
      Subcategory::create($subcategory);
    }
  }
}
