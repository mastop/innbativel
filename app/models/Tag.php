<?php

class Tag extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'tags';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  );

  public function offer(){
  	return $this->belongsToMany('Offer', 'offers_tags', 'tag_id', 'offer_id');
  }

}
