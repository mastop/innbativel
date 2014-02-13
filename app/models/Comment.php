<?php

class Comment extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'comments';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'offer_id' => 'required|integer',
  	'user_id' => 'required|integer',
  	'comment' => 'required',
  );

  public function offer(){
  	return $this->belongsTo('Offer')->with(['destiny']);
  }

  public function user(){
  	return $this->belongsTo('User')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
  }

}
