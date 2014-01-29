<?php

class UserIndication extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'users_indications';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'user_id' => 'required|integer',
  	'email' => 'required|email',
  );

  public function user()
  {
	return $this->belongsTo('User');
  }

}
