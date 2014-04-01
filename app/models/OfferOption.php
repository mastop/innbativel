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
		return $this->belongsTo('Offer')->with(['destiny']);
	}

	public function order(){
		return $this->hasMany('OrderOfferOption', 'orders_offers_options', 'offer_option_id');
	}

	public function offer_additional(){
		return $this->belongsToMany('Offer', 'offers_additional', 'offer_additional_id', 'offer_main_id');
	}

	public function qty_sold(){
		return $this->belongsToMany('Order', 'orders_offers_options', 'offer_option_id', 'order_id')->withPivot('qty');
	}

	public function used_vouchers(){
		return $this->belongsToMany('Order', 'vouchers', 'offer_option_id', 'order_id')->where('used', 1)->select(DB::raw('count(vouchers.offer_option_id) as qty'))->groupBy('vouchers.offer_option_id');
	}

	public function included(){
		return $this->belongsToMany('Included', 'offers_options_included', 'offer_option_id', 'included_id')->withPivot('display_home', 'display_order')->where('display_home', 1)->orderBy('display_home', 'asc');
	}

	public function departure_city(){
		return $this->belongsTo('Destiny', 'departure_city_id');
	}

	public function getPriceOriginalAttribute($value)
	{
		// $value = (int) $value;

		// $money = new Money($value, new Currency('BRL'));
		// $inter = new IntlFormatter('pt_BR');

		// return $inter->format($money);

		return substr($value, 0, -2);
	}

	public function getPriceWithDiscountAttribute($value)
	{
		// $value = (int) $value;

		// $money = new Money($value, new Currency('BRL'));
		// $inter = new IntlFormatter('pt_BR');

		// return $inter->format($money);

		return substr($value, 0, -2);
	}
}
