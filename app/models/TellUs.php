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
	'destiny' => 'required',
	'parner_name' => 'required',
	'travel_date' => 'required',
	'depoiment' => 'required',
	'img' => 'required',
  );

  public function __toString(){
      return $this->destiny.' | '.$this->name.' | '.substr($this->depoiment, 0, 60).(isset($this->depoiment{61}) ? '...' : null);
  }

  /**
     * Formata a data de início, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd
     *
     * @param $value
     * @return void
     */
    public function setTravelDateAttribute($value)
    {
        $travel_date = implode("-",array_reverse(explode("/",$value)));
        $this->attributes['travel_date'] = $travel_date;
    }

    /**
     * Formata a data de início, pegando YYYY-mm-dd
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getTravelDateAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
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
        return '//'.Configuration::get('s3url').'/conte_pra_gente/'.$this->id.'/'.$value;
    }

    public function getApprovedAttribute($value)
    {
        return $value == true ? 'Sim' : 'Não';
    }

}
