<?php

class Genre extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'genres';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'name' => 'required',
  	'icon_url' => 'required'
  );

  public function offer()
  {
      return $this->belongsToMany('Offer', 'offer_category');
  }

}
