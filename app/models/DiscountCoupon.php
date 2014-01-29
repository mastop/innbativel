<?php

class DiscountCoupon extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'discount_coupons';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'display_code' => 'required',
  	'value' => 'required',
  );

  public function offer(){
  	return $this->belongsTo('Offer');
  }

  public function user(){
  	return $this->belongsTo('User');
  }

}
