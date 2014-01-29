<?php

class RolesTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $roles = [
      [
        'name' => 'programador',
        'description' => 'Programador',
        'level' => '777',
      ],
      [
        'name' => 'administrador',
        'description' => 'Administrador',
        'level' => '777',
      ],
      [
        'name' => 'gerente',
        'description' => 'Gerente',
        'level' => '777',
      ],
      [
        'name' => 'Marketing',
        'description' => 'marketing',
        'level' => '777',
      ],
      [
        'name' => 'comercial',
        'description' => 'Comercial',
        'level' => '777',
      ],
      [
        'name' => 'atendimento',
        'description' => 'Atendimento',
        'level' => '777',
      ],
      [
        'name' => 'jornalista',
        'description' => 'Jornalista',
        'level' => '777',
      ],
      [
        'name' => 'designer',
        'description' => 'Designer',
        'level' => '777',
      ],
      [
        'name' => 'parceiro',
        'description' => 'Parceiro',
        'level' => '777',
      ],
      [
        'name' => 'cliente',
        'description' => 'Cliente',
        'level' => '777',
      ],
      [
        'name' => 'visitante',
        'description' => 'Visitante',
        'level' => '777',
      ],
    ];

    foreach ($roles as $role)
    {
      Role::create($role);
    }
  }
}
