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
  	//'name' => 'required',
  );

  public function option(){
  	return $this->hasMany('ContractOption');
  }

}
