<?php

class DiscountCoupon extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'discount_coupons';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = true;
  public $timestamps = false;

  public static $rules = array(
  	'display_code' => 'required',
  	'value' => 'required|decimal',
  	'starts_on' => 'required',
  	'ends_on' => 'required',
  );

  public function offer(){
    return $this->belongsTo('Offer')->with(['destiny']);
  }

  public function category(){
  	return $this->belongsTo('Category');
  }

  public function user(){
  	return $this->belongsTo('User')->with(['profile']);
  }

  /**
     * Esta função é necessária para substituir string vazia por NULL.
     * Sem esta função, vai dar erro no SQL por causa da foreign key associada a tell_us_id
     * @param $value
     * @return void
     */
    public function setTellUsIdAttribute($value)
    {
        $this->attributes['tell_us_id'] = $value ?: null;
    }

    /**
     * Formata a data de início, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd HH:ii:ss
     *
     * @param $value
     * @return void
     */
    public function setStartsOnAttribute($value)
    {
        $starts_on = implode("-",array_reverse(explode("/",$value)));
        $starts_on .= ' 00:00:00';
        $this->attributes['starts_on'] = $starts_on;
    }

    /**
     * Formata a data de término, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd HH:ii:ss
     *
     * @param $value
     * @return void
     */
    public function setEndsOnAttribute($value)
    {
        $ends_on = implode("-",array_reverse(explode("/",$value)));
        $ends_on .= ' 23:59:59';
        $this->attributes['ends_on'] = $ends_on;
    }

}
