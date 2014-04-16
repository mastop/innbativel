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

  public function payment(){
    return $this->belongsTo('Payment', 'payment_id');
  }

  public function partner(){
    return $this->belongsTo('User', 'partner_id')->leftJoin('profiles', 'users.id', '=', 'profiles.user_id');;
  }

  public function transaction(){
    return $this->belongsToMany('Transaction', 'transactions_vouchers', 'payment_partner_id', 'transaction_id');
  }

  public function voucher(){
    return $this->belongsToMany('Voucher', 'transactions_vouchers', 'payment_partner_id', 'voucher_id')
                ->with(['offer_option'])
                ->withPivot('status');
  }

}
