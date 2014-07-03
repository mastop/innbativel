<?php

class LogsTableSeeder extends DatabaseSeeder
{
  public function run()
  {
    $permissions = [
      [
        'name' => 'admin.log',
        'description' => 'Log',
        'is_menu' => TRUE,
      ],
      [
        'name' => 'admin.log.delete',
        'description' => 'admin.log.delete',
      ],
      [
        'name' => 'admin.log.destroy',
        'description' => 'admin.log.destroy',
      ],
      [
        'name' => 'admin.log.reset',
        'description' => 'admin.log.reset',
      ],
      [
        'name' => 'admin.log.truncate',
        'description' => 'admin.log.truncate',
      ],
    ];

    foreach ($permissions as $permission)
    {
      $id = Permission::create($permission)->id;
      $programmer = Role::where('name', 'programador')->first();
      $programmer->permission()->attach($id);
    }

    // veirifiquei o BD e is_menu era 0 para admin.log, nao sei pq... entao:
    Permission::where('name', 'admin.log')->update(['is_menu' => true]);
  }
}
