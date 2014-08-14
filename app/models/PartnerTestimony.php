<?php

class PartnerTestimony extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'partners_testimonies';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'partner_id' => 'required|integer',
  	'name' => 'required',
  	'destiny' => 'required',
  	'sponsor' => 'required',
  	'testimony' => 'required',
  	'img' => 'required',
  );

  public function user(){
  	return $this->belongsTo('User');
  }

  /**
     * Formata a imagem principal
     * @param $value
     * @return string
     */
    public function getImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
        return $value;
        return '//'.Configuration::get('s3url').'/depoimentos_parceiros/'.$this->id.'/'.$value;
    }

}
