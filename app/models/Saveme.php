<?php

class Saveme extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'saveme';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  	'geocode' => 'required|integer',
  );

  public function offer(){
  	return $this->belongsToMany('Offer', 'offers_saveme')->withPivot('priority');
  }

}
