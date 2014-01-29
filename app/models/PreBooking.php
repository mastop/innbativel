<?php

class PreBooking extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'pre_bookings';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'offer_id' => 'required|integer',
  	'user_id' => 'required|integer',
  	'email' => 'required',
  	'name' => 'required',
  );

  public function user(){
  	return $this->belongsTo('User');
  }

  public function offer(){
  	return $this->belongsTo('Offer');
  }

}
