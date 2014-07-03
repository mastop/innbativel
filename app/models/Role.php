<?php

use Toddish\Verify\Models\Role as BaseRole;

class Role extends BaseRole {
    /**
     * Users
     *
     * @return object
     */
    public function users()
    {
        return $this->belongsToMany('User')->withTimestamps();
    }

    public function permission(){
    	return $this->belongsToMany('Permission', 'permission_role', 'role_id', 'permission_id');
    }
}
