<?php

class UserCredit extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'users_credits';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'reciever_id' => 'required',
  	'sender_id' => 'required',
  	'value' => 'required',
  );

  public function user()
  {
	return $this->belongsTo('User');
  }

}
