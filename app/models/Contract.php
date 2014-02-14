<?php

class Contract extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'contracts';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	// partner side
  	'company_name' => 'required',
  	'cnpj' => 'required',
  	'trading_name' => 'required',
  	'address' => 'required',
  	'neighborhood' => 'required',
  	'zip' => 'required',
  	'city' => 'required',
  	'state' => 'required',
  	'agent1_name' => 'required',
  	'agent1_cpf' => 'required',
  	'agent1_telephone' => 'required',
  	//consultant side
  	'term' => 'required|date',
  	'restriction' => 'required',
  	'n_people' => 'required|integer',
  );

  public function option(){
  	return $this->hasMany('ContractOption', 'contract_id');
  }

  public function partner(){
  	return $this->belongsTo('User')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

}
