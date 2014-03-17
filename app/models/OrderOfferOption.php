<?php

class OrderOfferOption extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'orders_offers_options';

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'user_id' => 'required|integer',
  	'offer_option_id' => 'required|integer',
  	'qty' => 'required|integer',
  );

  public function voucher(){
  	return $this->hasMany('Voucher');
  }

  public function order(){
  	return $this->belongsTo('Order');
  }

  public function offer_option(){
  	return $this->belongsTo('OrderOffer', 'order_option_id');
  }

}
