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
}
