<?php

class SuggestATrip extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'suggest_a_trip';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = true;

  public static $rules = array(
  	'destiny' => 'required',
  	'suggestion' => 'required',
  	'name' => 'required',
  	'email' => 'required',
  );

  public function getSuggestionAttribute($value){
    return '<pre>'.$value.'</pre>';
  }

}
