<?php

class PermRoleUsersTableSeeder extends DatabaseSeeder
{
	public function run()
	{
		$users = ['cawecoy@gmail.com'];
		$roles = Role::select('id')
					 ->where('name', 'programador')
					 ->orWhere('name', 'administrador')
					 ->orWhere('name', 'parceiro') // Adicionado pois precisamos de ao menos um parceiro
					 ->get('id');

		foreach ($roles as $key) {
			$rolesToSync[] = $key->id;
		}

		foreach ($users as $email) {
			$user = User::where('email', '=', $email)->first();

			if (!is_null($user)) {
				$user->roles()->sync($rolesToSync);
			}
		}

		//////////////////////////////////////////////////////////////////
		// 							Parceiros							//
		//////////////////////////////////////////////////////////////////

		$roles = Role::select('id')
					 ->where('name', 'parceiro')
					 ->get('id');

		unset($rolesToSync);

		foreach ($roles as $key) {
			$rolesToSync[] = $key->id;
		}

		$users = User::where('id', '>', '7000');
		foreach ($users as $user) {
			if (!is_null($user)) {
				$user->roles()->sync($rolesToSync);
			}
		}
	}
}
