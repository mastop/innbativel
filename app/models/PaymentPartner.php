<?php

class PaymentPartner extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'payments_partners';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  );

  public function payment_partner_voucher(){
    return $this->hasMany('PaymentPartnerVoucher', 'payment_partner_id');
  }

  public function payment(){
    return $this->belongsTo('Payment', 'payment_id');
  }

  public function partner(){
    return $this->belongsTo('User', 'partner_id')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');;
  }

}
