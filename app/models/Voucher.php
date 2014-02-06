<?php

class Voucher extends Eloquent {

  /**
   * The name of the table associated with the Eloquent.
   *
   * @var string
   */
  protected $table = 'vouchers';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'order_offer_id' => 'required|integer',
  	'display_code' => 'required',
  	'name' => 'required',
  	'email' => 'required|email',
  );

  public function order(){
  	return $this->belongsTo('Order')->leftJoin('users', 'users.id', '=', 'orders.user_id')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

  public function offer_option(){
  	return $this->belongsTo('OfferOption', 'offer_option_id');
  }
}
