<?php

class GeoCategory extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'geo_categories';

  public static $sluggable = array(
    'build_from' => 'name',
    'save_to'    => 'slug',
  );

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  	'slug' => 'required',
  );

  public function offer()
  {
      return $this->belongsToMany('Offer', 'offers_geo_categories');
  }

}
