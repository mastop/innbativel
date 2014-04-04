<?php

class SortsOfDestinyTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $sorts = [
		[ 'title' => 'Praia', 'is_active' => true ],
		[ 'title' => 'Serra', 'is_active' => true ],
		[ 'title' => 'Campo', 'is_active' => true ],
		[ 'title' => 'Cidade', 'is_active' => true ],
		[ 'title' => 'Termas', 'is_active' => true ],
		[ 'title' => 'Ecológico', 'is_active' => true ],
    ];

    foreach ($sorts as $sort)
    {
      SortOfDestiny::create($sort);
    }
  }
}
