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
	'title' => 'required',
	'icon' => 'required'
  );

  public function offer()
  {
	  return $this->belongsToMany('Offer');
  }

}
