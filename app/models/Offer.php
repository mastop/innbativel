<?php

class Offer extends Eloquent {

	/**
	* The name of the table associated with the model.
	*
	* @var string
	*/
	protected $table = 'offers';

	public static $sluggable = array(
		 'build_from' => 'title',
		 'save_to'    => 'slug',
	 );

	protected $guarded = [];
	protected $fillable = [];

	protected $softDelete = false;
	public $timestamps = true;

	public static $rules = [
		 'partner_id' => 'required|integer',
		 'ngo_id' => 'required|integer',
		 'genre_id' => 'required|integer',
		 'destiny_id' => 'required',
		 'title' => 'required',
		 'starts_on' => 'required',
		 'ends_on' => 'required',
		 'cover_img' => 'required|mimes:jpeg,jpg,png',
	 ];

	public function order(){
		return $this->hasMany('Order');
	}

	public function comment(){
		return $this->hasMany('Comment')->orderBy('display_order', 'asc');
	}

	public function offer_additional(){
		return $this->belongsToMany('OfferOption', 'offers_additional', 'offer_main_id', 'offer_additional_id');
	}

	public function offer_option(){
		return $this->hasMany('OfferOption')->orderBy('display_order', 'asc');
	}

	public function offer_option_home(){
		return $this->hasMany('OfferOption')->orderBy('display_order', 'asc');
	}

	public function category(){
		return $this->belongsTo('Category', 'category_id');
	}

	public function offer_image(){
		return $this->hasMany('OfferImage');
	}

	public function saveme(){
		return $this->belongsToMany('Saveme', 'offers_saveme', 'saveme_id', 'offer_id')->withPivot('priority');
	}

	public function group(){
		return $this->belongsToMany('Group', 'offers_groups', 'offer_id', 'group_id')->withPivot('display_order')->orderBy('display_order', 'asc');
	}

	public function discount_coupon(){
		return $this->hasMany('DiscountCoupon');
	}

	public function ngo(){
		return $this->belongsTo('Ngo');
	}

	public function genre(){
		return $this->belongsTo('Genre');
	}

	public function genre2(){
		return $this->belongsTo('Genre', 'genre2_id');
	}

	public function destiny(){
		return $this->belongsTo('Destiny', 'destiny_id');
	}

	public function partner(){
		return $this->belongsTo('User', 'partner_id')->leftJoin('profiles', 'profiles.user_id', '=', 'users.id');
	}

	public function tell_us(){
		return $this->belongsTo('TellUs', 'tell_us_id');
	}

	public function holiday(){
		return $this->belongsToMany('Holiday', 'offers_holidays', 'offer_id', 'holiday_id');
	}

	public function included(){
		return $this->belongsToMany('Included', 'offers_included', 'offer_id', 'included_id')->withPivot('display_order')->orderBy('display_order', 'asc');
	}

	private function convertImageString($value)
	{
		if (!is_null($value)) {
			$arr = explode(',', $value);
			$result = [];

			foreach ($arr as $key => $value) {
				$array = explode(':', $value);
				$result[$array[0]] = $array[1];
			}

			return $result;
		}

		return '';
	}

	public function getCoverImgAttribute($value)
	{
		return $this->convertImageString($value);
	}

	public function getOfferOldImgAttribute($value)
	{
		return $this->convertImageString($value);
	}

	public function getInstallmentAttribute($value)
	{
		if (!empty($value) &&
			!is_null($value) &&
			!empty($this->offer_option[0]->price_with_discount) &&
			!is_null($this->offer_option[0]->price_with_discount)
		){
			$price = (int) preg_replace('/[^0-9]/', '', $this->offer_option[0]->price_with_discount);
			$value = 12;

			if($price <= 251){
				$value = 3;
			}
			else if($price <= 501){
				$value = 6;
			}
		}

		return $value;
	}

	public function getFullDestinnyAttribute(){
        $destiny = Destiny::find($this->destiny_id);
		//return $destiny->city.'-'.$destiny->state_id;
		return $destiny->name;
	}

}
