<?php

class Group extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'groups';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
	'title' => 'required',
  );

  public function offer(){
	return $this->belongsToMany('Offer', 'offers_groups', 'group_id', 'offer_id');
  }

}
