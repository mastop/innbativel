<?php

class OfferImage extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'offers_images';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'offer_id' => 'required|integer',
  	'url' => 'required|url',
  );

  public function offer(){
  	return $this->belongsTo('Offer');
  }

}
