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
    'bank_name' => 'required',
    'bank_number' => 'required',
    'bank_holder' => 'required',
    'bank_agency' => 'required',
    'bank_account' => 'required',
    'bank_cpf_cnpj' => 'required',
    'consultant_id' => 'required',
    'partner_id' => 'required',
  	//consultant side
  	'initial_term' => 'required|date',
    'final_term' => 'required|date',
  	'restriction' => 'required',
  	'n_people' => 'required|integer',
  );

  public function option(){
    return $this->hasMany('ContractOption', 'contract_id');
  }

  public function consultant(){
    return $this->belongsTo('User', 'consultant_id')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

  public function partner(){
  	return $this->belongsTo('User', 'partner_id')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

}
