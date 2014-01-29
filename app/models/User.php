<?php

use Toddish\Verify\Models\User as BaseUser;

class User extends BaseUser {

	public function profile()
	{
		return $this->hasOne('Profile');
	}

    public function facebook()
    {
        return $this->hasMany('FacebookOA');
    }

}
