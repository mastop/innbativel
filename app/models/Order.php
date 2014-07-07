<?php

class Order extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'orders';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'user_id' => 'required|integer',
  	'total' => 'required',
  	'cpf' => 'required',
  	'telephone' => 'required',
  );

  public function user(){
    return $this->belongsTo('User', 'user_id')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');
  }

  public function buyer(){
    return $this->belongsTo('User', 'user_id')->with(['profile']);
  }

  public function discount_coupon(){
  	return $this->belongsTo('DiscountCoupon', 'coupon_id')->withTrashed();
  }

  public function voucher(){
    return $this->hasMany('Voucher', 'order_id');
  }

  public function payment(){
    return $this->hasMany('Voucher', 'order_id')->with(['offer_option']);
  }

  public function voucher_offer(){
    return $this->hasMany('Voucher', 'order_id')->with(['offer_option_offer']);
  }

  public function offer(){
    return $this->belongsToMany('OfferOption', 'vouchers', 'order_id', 'offer_option_id')
                ->leftJoin('offers', 'offers_options.offer_id', '=', 'offers.id')
                ->select(['offers.id','offers.title AS offer_title', 'is_product', 'offers.slug AS slug'])
                ->withPivot('id', 'status', 'used', 'display_code', 'name', 'email', 'tracking_code');
  }

  public function offer_option_offer(){
    return $this->belongsToMany('OfferOption', 'vouchers', 'order_id', 'offer_option_id')
                ->with(['offer' => function($query){
                  $query->withTrashed();
                }])
                ->withPivot('id', 'status', 'used', 'display_code', 'name', 'email', 'tracking_code');
  }

  public function optional_item(){
    return $this->belongsToMany('OptionalItem', 'orders_optional_itens', 'order_id', 'optional_item_id');
  }

  public function getDisplayHistoryAttribute(){
    return '<pre>'.$this->history.'</pre>';
  }

}
