<?php

class PermissionsTableSeeder extends DatabaseSeeder
{
	public function run()
	{
		$permissions = [

			// admin
			['name' => 'admin', 'description' => 'Acessar a página geral de administração.'],

			// Users
			// Profiles
			['name' => 'admin.user', 'description' => 'Acessar a página geral de administração de usuários.'],
			['name' => 'admin.user.view', 'description' => 'Visualizar o perfil de um usuário.'],
			['name' => 'admin.user.create', 'description' => 'Criar um usuário.'],
			['name' => 'admin.user.edit', 'description' => 'Editar um usuário.'],
			['name' => 'admin.user.delete', 'description' => 'Excluir um usuário.'],

			// Roles
			['name' => 'admin.role', 'description' => 'Acessar a página geral de administração de papéis de usuário.'],
			['name' => 'admin.role.create', 'description' => 'Criar um papéis de usuário.'],
			['name' => 'admin.role.edit', 'description' => 'Editar um papéis de usuário.'],
			['name' => 'admin.role.delete', 'description' => 'Excluir um papéis de usuário.'],

			// Permissions
			['name' => 'admin.perm', 'description' => 'Acessar a página geral de administração de permissões.'],
			['name' => 'admin.perm.create', 'description' => 'Criar uma permissão.'],
			['name' => 'admin.perm.edit', 'description' => 'Editar uma permissão.'],
			['name' => 'admin.perm.delete', 'description' => 'Excluir uma permissão.'],

		];

		foreach ($permissions as $permission)
		{
			Permission::create($permission);
		}
	}
}
