<?php

use Toddish\Verify\Models\User as BaseUser;

/**
 * Classe dos usuários
 *
 * @author Saulo Lima <saulolimajf@gmail.com>
 * @createdAt 25/03/14
 * @version 1.0
 * @copyright Mastop
 * @link http://www.mastop.com.br
 *
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 *
 * Model base, Toddish\Verify\Models\User, encontra-se em:
 * https://github.com/Toddish/Verify-L4/blob/master/src/Toddish/Verify/Models/User.php
 * */

class User extends BaseUser {

    /**
     * Sobrecarga para adicionar o atributo "api_key" na classe
     *
     */
    public function __construct (array $attributes = array()) {
        $this->fillable = array_merge ($this->fillable, array(
            'api_key'
        ));
        parent::__construct($attributes);
    }

    /**
     * Retorna o Nome completo
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return isset($this->profile) ? $this->profile->first_name . ' ' . $this->profile->last_name : $this->username;
    }

    public function getFullAddressAttribute(){
        // RUA, NUMERO, COMPLEMENTO, BAIRRO, CIDADE, ESTADO
        if(isset($this->profile)){
            $street = (isset($this->profile->street) && $this->profile->street != '' && $this->profile->street != 'NULL') ? $this->profile->street : '';
            $number = (isset($this->profile->number) && $this->profile->number != '' && $this->profile->number != 'NULL') ? ', ' . $this->profile->number : '';
            $complement = (isset($this->profile->complement) && $this->profile->complement != '' && $this->profile->complement != 'NULL') ? ', ' . $this->profile->complement : '';
            $neighborhood = (isset($this->profile->neighborhood) && $this->profile->neighborhood != '' && $this->profile->neighborhood != 'NULL') ? ', ' . $this->profile->neighborhood : '';
            $city = (isset($this->profile->city) && $this->profile->city != '' && $this->profile->city != 'NULL') ? ', ' . $this->profile->city : '';
            $state = (isset($this->profile->state) && $this->profile->state != '' && $this->profile->state != 'NULL') ? ', ' . $this->profile->state : '';

            return $street . $number . $complement . $neighborhood . $city . $state;
        }
        else{
            return '';
        }
    }

	public function profile()
	{
		return $this->hasOne('Profile', 'user_id');
	}

    public function facebook()
    {
        return $this->hasMany('FacebookOA');
    }

    public static function getAllByRole($roleName){

        $users = Role::where('name', '=', $roleName)->first()->users()->get();
        $users->load('profile');
        $ret = array();
        if(!empty($users)){
            foreach($users as $u){
                $ret[$u->id] = $u->fullName;
            }
        }
        return $ret;
    }
}
