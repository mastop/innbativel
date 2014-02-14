<?php

class ContractOption extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'contract_options';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	//'name' => 'required',
  );

  public function contract(){
  	return $this->belongsTo('Contract');
  }

}
