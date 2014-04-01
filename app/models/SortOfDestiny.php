<?php

class SortOfDestiny extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'sorties_of_destiny';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  );

  public function destiny(){
  	return $this->belongsToMany('Destiny', 'destinies_sorties_of_destiny', 'sort_of_destiny_id', 'destiny_id');
  }

}
