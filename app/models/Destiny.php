<?php

class Destiny extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'destinies';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'name' => 'required',
  );

  public function offer(){
    return $this->belongsTo('Offer', 'destiny_id');
  }

  public function offer_option(){
    return $this->belongsTo('OfferOption', 'departure_city_id');
  }

  public function sort_of_destiny(){
    return $this->belongsToMany('SortyOfDestiny', 'destinies_sorties_of_destiny', 'destiny_id', 'sort_of_destiny_id');
  }

}
