<?php

class Ngo extends BaseModel {

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
  	'img' => 'required',
  );

  public function offer(){
  	return $this->belongsTo('Offer');
  }

    /**
     * Formata a imagem
     * @param $value
     * @return string
     */
    public function getImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
            return $value;
        return '//'.Configuration::get('s3url').'/ongs/'.$this->id.'/'.$value;
    }

    /**
     * Retorna o thumb da oferta, como $offer->thumb
     * @return string
     */
    public function getThumbAttribute()
    {
        return '//'.Configuration::get('s3url').'/ongs/'.$this->id.'/thumb/'.$this->getOriginal('img');
    }

}
