<?php

class TransactionVoucher extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'transactions_vouchers';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  );

  public function payment_partner(){
    return $this->belongsTo('PaymentPartner', 'payment_partner_id');
  }

  public function voucher(){
    return $this->belongsTo('Voucher', 'voucher_id');
  }

  public function transaction(){
    return $this->belongsTo('Transaction', 'transaction_id')->with(['order']);
  }

}
