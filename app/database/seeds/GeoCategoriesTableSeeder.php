<?php
// 'offer_geo_category' e 'geo_categories'
class GeoCategoriesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $geo_categories = [
      [
        'title' => 'Nordeste',
        'slug' => 'nordeste',
        'display_order' => 1,
      ],
      [
        'title' => 'Sudeste',
        'slug' => 'sudeste',
        'display_order' => 2,
      ],
    ];

    foreach ($geo_categories as $geo_category)
    {
      $g = GeoCategory::create($geo_category);
      $g->offer()->attach(1);
      $g->offer()->attach(2);
    }
  }
}
