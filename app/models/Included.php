<?php

class Included extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'included';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  	'description' => 'required',
  	'icon' => 'required',
  );

  public function offer(){
  	return $this->belongsToMany('OfferOption', 'offers_options_included', 'included_id', 'offer_option_id')->withPivot('display_home', 'display_order');
  }

}
