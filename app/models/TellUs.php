<?php

class TellUs extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'tell_us';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'name' => 'required',
	'destiny' => 'required',
	'parner_name' => 'required',
	'travel_date' => 'required',
	'depoiment' => 'required',
	'img' => 'required',
  );

}
