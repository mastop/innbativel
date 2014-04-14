<?php

class Payment extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'payments';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'sales_from' => 'required|date',
    'sales_to' => 'required|date'
  	'date' => 'required|date'
  );

  public function partner_payment(){
    return $this->hasMany('PaymentPartner', 'payment_id');
  }

}
