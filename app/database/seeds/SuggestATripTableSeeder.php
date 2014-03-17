<?php

class SuggestATripTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $suggests = [
      [
        'destiny' => 'Florianópolis',
        'suggestion' => 'QUERO UMA VIAGEM PAULADA PRA FLORIPA UHULL',
        'name' => 'Zé do Biscoito',
        'email' => 'ze@biscoito.co.uk',
      ],
    ];

    foreach ($suggests as $suggest)
    {
      SuggestATrip::create($suggest);
    }
  }
}
