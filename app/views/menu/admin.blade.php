<?php
$permissions = Permission::whereExists(function($query){
                              $query->select(DB::raw(1))
                                    ->from('permission_role')
                                    ->join('role_user', 'role_user.role_id', '=', 'permission_role.role_id')
                                    ->whereRaw('permissions.id = permission_role.permission_id')
                                    ->whereRaw('role_user.user_id = '.Auth::user()->id);
                          })
                          ->where('is_menu', true)
                          ->orderBy('display_order', 'asc')
                          ->select(['name', 'description'])
                          ->get();
$menu[] = [Navigation::HEADER, 'Menu Administrativo', false, false, null, 'tasks'];
foreach ($permissions as $permission) {
    $menu[] = [$permission->description, route($permission->name), false, false, null, 'tasks'];
}
?>

{{ Navigation::lists(
    Navigation::links($menu)
) }}