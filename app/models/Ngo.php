<?php

class Ngo extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'ngos';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'name' => 'required',
  );

  public function offer(){
  	return $this->belongsTo('Offer');
  }

}
