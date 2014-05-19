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
	 'price_with_discount' => 'required',
	 'min_qty' => 'required|integer',
	 'max_qty' => 'required|integer',
	 'max_qty_per_buyer' => 'required|integer',
	 'percent_off' => 'integer|max:100',
	 'voucher_validity_start' => 'required',
	 'voucher_validity_end' => 'required',
	 );

	public function offer(){
		return $this->belongsTo('Offer')->with(['destiny']);
	}

	public function order(){
		return $this->belongsToMany('Voucher', 'vouchers', 'offer_option_id', 'order_id');
	}

	public function offer_additional(){
		return $this->belongsToMany('Offer', 'offers_additional', 'offer_additional_id', 'offer_main_id');
	}

	public function qty_sold(){
		return $this->hasMany('Voucher', 'offer_option_id')
					->where('vouchers.status', 'pago')
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
	}

	public function qty_pending(){
		return $this->hasMany('Voucher', 'offer_option_id')
					->whereIn('vouchers.status', ['pendente', 'revisao'])
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
	}

	public function qty_cancelled(){
		return $this->hasMany('Voucher', 'offer_option_id')
					->where('vouchers.status', 'cancelado')
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
	}

	public function used_vouchers(){
		return $this->hasMany('Voucher', 'offer_option_id')
					->where('vouchers.used', 1)
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
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
