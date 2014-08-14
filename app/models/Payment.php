<?php

class Payment extends Eloquent {

  /**
   * The name of the table associated with the model.
   *
   * @var string
   */
  protected $table = 'payments';

  protected $guarded = [];
  protected $fillable = [];

  protected $softDelete = false;
  public $timestamps = false;

  public static $rules = array(
  	'sales_from' => 'required',
    'sales_to' => 'required',
  	'date' => 'required',
  );

  public function partner_payment(){
    return $this->hasMany('PaymentPartner', 'payment_id');
  }

  /**
     * Formata a data de início, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd
     *
     * @param $value
     * @return void
     */
    public function setSalesFromAttribute($value)
    {
        $date = implode("-",array_reverse(explode("/",$value)));
        $this->attributes['sales_from'] = $date.' 00:00:00';
    }

    /**
     * Formata a data de início, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd
     *
     * @param $value
     * @return void
     */
    public function setSalesToAttribute($value)
    {
        $date = implode("-",array_reverse(explode("/",$value)));
        $this->attributes['sales_to'] = $date.' 23:59:59';
    }

    /**
     * Formata a data de início, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd
     *
     * @param $value
     * @return void
     */
    public function setDateAttribute($value)
    {
        $date = implode("-",array_reverse(explode("/",$value)));
        $this->attributes['date'] = $date;
    }

    /**
     * Formata a data de início, pegando YYYY-mm-dd
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getEditableSalesFromAttribute()
    {
        return date('d/m/Y', strtotime($this->sales_from));
    }

    /**
     * Formata a data de início, pegando YYYY-mm-dd
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getEditableSalesToAttribute()
    {
        return date('d/m/Y', strtotime($this->sales_to));
    }

    /**
     * Formata a data de início, pegando YYYY-mm-dd
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getEditableDateAttribute()
    {
        return date('d/m/Y', strtotime($this->date));
    }

}
