<?php

class PaymentPartnerVoucher extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'payments_partners_vouchers';

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
    return $this->hasMany('Voucher', 'voucher_id');
  }

}
