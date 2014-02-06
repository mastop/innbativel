<?php

use SebastianBergmann\Money\Money;
use SebastianBergmann\Money\Currency;
use SebastianBergmann\Money\IntlFormatter;

class OfferOption extends Eloquent {

	/**
	* The name of the table associated with the model.
	*
	* @var string
	*/
	protected $table = 'offers_options';

	protected $guarded = [];
	protected $fillable = [];

	protected $softDelete = false;
	public $timestamps = false;

	public static $rules = array(
     'offer_id' => 'required|integer',
     'title' => 'required',
     'subtitle' => 'required',
     'price_original' => 'required',
     'price_with_discount' => 'required',
     'min_qty' => 'required|integer',
     'max_qty' => 'required|integer',
     'max_qty_per_buyer' => 'required|integer',
     'percent_off' => 'required|integer|max:100',
     'voucher_validity_start' => 'required',
     'voucher_validity_end' => 'required',
     );

	public function offer(){
		return $this->belongsTo('Offer');
	}

	public function order(){
		return $this->hasMany('OrderOfferOption', 'orders_offers_options', 'offer_option_id');
	}

	public function offer_additional(){
		return $this->belongsToMany('Offer', 'offers_additional', 'offer_additional_id', 'offer_main_id');
	}

	public function getPriceOriginalAttribute($value)
	{
        $value = (int) $value;

		$money = new Money($value, new Currency('BRL'));
		$inter = new IntlFormatter('pt_BR');

		return $inter->format($money);
	}

	public function getPriceWithDiscountAttribute($value)
	{
        $value = (int) $value;

        $money = new Money($value, new Currency('BRL'));
        $inter = new IntlFormatter('pt_BR');

        return $inter->format($money);
	}
}
