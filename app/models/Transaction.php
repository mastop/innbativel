<?php

class Transaction extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'transactions';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  );

  public function voucher(){
    return $this->belongsToMany('Voucher', 'transactions_vouchers', 'transaction_id', 'voucher_id')
                ->with(['offer_option']);
  }

  public function order(){
    return $this->belongsTo('Order', 'order_id')->with(['buyer', 'voucher_offer']);
  }

  public function customer(){
    return $this->belongsTo('User', 'changer_id')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');
  }

}
