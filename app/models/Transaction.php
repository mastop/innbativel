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
  public $timestamps = false;

  public static $rules = array(
  );

  public function payment_partner(){
    return $this->belongsTo('PaymentPartner', 'payment_partner_id')->with(['payment', 'partner']);
  }

  public function transaction_voucher(){
    return $this->hasMany('TransactionVoucher', 'transaction_voucher_id');
  }

  public function order(){
    return $this->belongsTo('Order', 'order_id');
  }

}
