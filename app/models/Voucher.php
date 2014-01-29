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

  public function order_offer_option()
  {
	return $this->belongsTo('OrderOfferOption','orders_offers_options', 'order_offer_id');
  }

}
