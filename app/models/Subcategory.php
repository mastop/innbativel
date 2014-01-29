<?php

class Subcategory extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'subcategories';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'category_id' => 'required',
  	'title' => 'required'
  );

  public function offer()
  {
      return $this->belongsToMany('Offer', 'offers_subcategories');
  }

  public function category()
  {
      return $this->belongsTo('Category', 'categories');
  }

}
