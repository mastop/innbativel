<?php

class Newsletter extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'newsletters';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'name' => 'required',
  	'email' => 'Required|Max:255|Email|Unique:email'
  );
}
