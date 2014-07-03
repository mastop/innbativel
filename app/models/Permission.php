<?php

use Toddish\Verify\Models\Permission as BasePermission;

class Permission extends BasePermission {
	public function role(){
    	return $this->belongsToMany('Role', 'permission_role', 'permission_id', 'role_id');
    }
}
