<?php

class OptionalItem extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'optional_itens';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'title' => 'required',
  );

  public function offer(){
    return $this->belongsToMany('Offer', 'offers_optional_itens', 'optional_item_id', 'offer_id');
  }

  public function order(){
    return $this->belongsToMany('Order', 'orders_optional_itens', 'optional_item_id', 'order_id');
  }

}
