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
  	return $this->belongsTo('Order', 'order_id')
                ->leftJoin('users', 'users.id', '=', 'orders.user_id')
                ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

  public function order_customer(){
    return $this->belongsTo('Order', 'order_id')
                ->with(['user']);
  }

  public function offer_option_offer(){
    return $this->belongsTo('OfferOption', 'offer_option_id')
                ->with('offer');
  }

  public function offer_option(){
  	return $this->belongsTo('OfferOption', 'offer_option_id')
                ->leftJoin('offers', 'offers_options.offer_id', '=', 'offers.id')
                ->select(['offers.id', 'offers_options.offer_id', 'offers.title AS offer_title', 'offers_options.title', 'slug', 'is_product', 'offers_options.price_with_discount', 'offers_options.transfer']);
  }

}
