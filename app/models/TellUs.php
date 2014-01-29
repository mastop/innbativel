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
  	'email' => 'required',
  	'depoiment' => 'required',
  	'img' => 'required',
  );

}
