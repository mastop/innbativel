<?php

class ContractOption extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'contract_options';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array();

  public function contract(){
  	return $this->belongsTo('Contract', 'contract_id');
  }

  /**
   * Formata o valor original, para transformar
   * 1.2345,67 em 12345.76
   *
   * @param $value
   * @return void
   */
  public function setPriceOriginalAttribute($value){
      $v = str_replace(',', '.', str_replace('.', '', $value));
      $this->attributes['price_original'] = $v;
  }

  /**
   * Formata o valor com desconto, para transformar
   * 1.2345,67 em 12345.76
   *
   * @param $value
   * @return void
   */
  public function setPriceWithDiscountAttribute($value){
      $v = str_replace(',', '.', str_replace('.', '', $value));
      $this->attributes['price_with_discount'] = $v;
  }

  /**
   * Formata o valor de repasse ao parceiro, para transformar
   * 1.2345,67 em 12345.76
   *
   * @param $value
   * @return void
   */
  public function setTransferAttribute($value){
      $v = str_replace(',', '.', str_replace('.', '', $value));
      $this->attributes['transfer'] = $v;
  }

  /**
   * Formata o valor original, para transformar
   * 12345.76 em 1.2345,67
   *
   * @param $value
   * @return number_format($value, 2, ',', '.');
   */
  public function getPriceOriginalAttribute($value){
      return number_format($value, 2, ',', '.');
  }

  /**
   * Formata o valor com desconto, para transformar
   * 12345.76 em 1.2345,67
   *
   * @param $value
   * @return number_format($value, 2, ',', '.');
   */
  public function getPriceWithDiscountAttribute($value){
      return number_format($value, 2, ',', '.');
  }

  /**
   * Formata o valor de repasse ao parceiro, para transformar
   * 12345.76 em 1.2345,67
   *
   * @param $value
   * @return number_format($value, 2, ',', '.');
   */
  public function getTransferAttribute($value){
      return number_format($value, 2, ',', '.');
  }

}
