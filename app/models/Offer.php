<?php

class Offer extends BaseModel {

	/**
	* The name of the table associated with the model.
	*
	* @var string
	*/
	protected $table = 'offers';

	public static $sluggable = array(
		 'build_from' => 'short_title',
		 'save_to'    => 'slug',
	 );

	protected $guarded = [];
    protected $fillable = [
        'partner_id', // Id do Parceiro
        'category_id', // Id da Categoria
        'genre_id', // Id do Gênero
        'genre2_id', // Id do Gênero 2
        'destiny_id', // Id do Destino
        'ngo_id', // Id da ONG
        'tell_us_id', // Id do depoimento do cliente
        'title', // Título
        'short_title', // Título Curto
        'subtitle', // SubTítulo
        'price_original', // Preço Original
        'price_with_discount', // Preço Com Desconto
        'percent_off', // %OFF
        'rules', // Regras
        'features', // Destaques
        'popup_features', // Destaques Popup
        'starts_on', // Data de Início
        'ends_on', // Data de Término
        'cover_img', // Imagem Principal
        'newsletter_img', // Imagem Newsletters
        'is_product', // Será publicada?
        'is_active', // Oferta ativa?
        'sold', // Itens Vendidos
    ];

	protected $softDelete = true;
	public $timestamps = true;

	public static $rules = [
        'title' => 'required',
        'short_title' => 'required',
        'destiny_id' => 'required|integer|min:1',
        'partner_id' => 'required|integer|min:1',
        'ngo_id' => 'required|integer',
        'starts_on' => 'required',
        'ends_on' => 'required',
        'rules' => 'required',
        'category_id' => 'required|integer|min:1',
        'genre_id' => 'required|integer',
	 ];

    public static function query()
    {
        $now = date('Y-m-d H:i:s');
        $query = parent::query();
        $query->where('offers.starts_on','<', $now)
                ->where('offers.ends_on','>', $now)
                ->where('offers.is_available','=', 1)
                ->where('offers.is_active','=', 1);
        return $query;
    }

	public function order(){
		return $this->hasMany('Order');
	}

	public function comment(){
		return $this->hasMany('Comment')->orderBy('display_order', 'asc');
	}

	public function offer_additional(){
        return $this->belongsToMany('OfferOption', 'offers_additional', 'offer_main_id', 'offer_additional_id')->withPivot('display_order')->orderBy('offers_additional.display_order', 'asc');
    }

    public function offer_additional_offer(){
        return $this->belongsToMany('OfferOption', 'offers_additional', 'offer_main_id', 'offer_additional_id')->withPivot('display_order')->with(['offer'])->orderBy('offers_additional.display_order', 'asc');
    }

	public function offer_option(){
		return $this->hasMany('OfferOption')->orderBy('display_order', 'asc');
	}

	public function category(){
		return $this->belongsTo('Category', 'category_id');
	}

	public function offer_image(){
		return $this->hasMany('OfferImage');
	}

	public function group(){
		return $this->belongsToMany('Group', 'offers_groups', 'offer_id', 'group_id')->withPivot('display_order')->orderBy('offers_groups.display_order', 'asc');
	}

	public function discount_coupon(){
		return $this->hasMany('DiscountCoupon', 'coupon_id')->withTrashed();
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
		return $this->belongsTo('User', 'partner_id')->with(['profile']);
	}

    public function partner2(){
        return $this->belongsTo('User', 'partner_id')->with(['profile']);
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

    public function tag(){
        return $this->belongsToMany('Tag', 'offers_tags', 'offer_id', 'tag_id');
    }

    /**
     * Retorna a URL da oferta, como $offer->url
     * @return string
     */
    public function getUrlAttribute(){
        return route('oferta', $this->slug);
    }

    /**
     * Retorna a descrição da oferta formatada, como $offer->format_features
     * @return string
     */
    public function getFormatFeaturesAttribute(){
        if($this->features == ''){
            return;
        }
        $search = array(
            'Regulamento da Oferta',
            'Regras',
            'Reagendamento/Cancelamento',
            'Fale Conosco',
            'mapa'
        );
        $replace = array(
            '<a href="#regulation" class="tooltip" data-tip="Veja o Regulamento da Oferta" data-toggle="modal">Regulamento da Oferta</a>',
            '<a href="#regulation" class="tooltip" data-tip="Veja o Regulamento da Oferta" data-toggle="modal">Regras</a>',
            '<a href="#regulation" class="tooltip" data-tip="Veja a Política de Reagendamento/Cancelamento" data-toggle="modal">Reagendamento/Cancelamento</a>',
            '<a href="#contact" class="tooltip" data-tip="Entre em contato" data-toggle="modal">Fale Conosco</a>',
            '<a href="#map" class="tooltip" data-tip="Veja a localização" data-toggle="modal">Mapa</a>'
        );
        return str_ireplace($search, $replace, $this->features);
    }

    /**
     * Esta função é necessária para substituir string vazia por NULL.
     * Sem esta função, vai dar erro no SQL por causa da foreign key associada a genre2_id
     * @param $value
     * @return void
     */
    public function setGenre2IdAttribute($value)
    {
        $this->attributes['genre2_id'] = $value ?: null;
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

    /**
     * Formata a data de início, pegando YYYY-mm-dd HH:ii:ss
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getStartsOnAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Formata a data de término, pegando YYYY-mm-dd HH:ii:ss
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getEndsOnAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Formata a imagem principal
     * @param $value
     * @return string
     */
    public function getCoverImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
        return $value;
        return '//'.Configuration::get('s3url').'/ofertas/'.$this->id.'/'.$value;
    }

    /**
     * Formata a imagem de pré-reserva
     * @param $value
     * @return string
     */
    public function getOfferOldImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
        return $value;
        return '//'.Configuration::get('s3url').'/ofertas/'.$this->id.'/'.$value;
    }

    /**
     * Formata a imagem de Newsletters
     * @param $value
     * @return string
     */
    public function getNewsletterImgAttribute($value)
    {
        if(empty($value) || substr($value, 0, 4) == 'http')
        return $value;
        return '//'.Configuration::get('s3url').'/ofertas/'.$this->id.'/'.$value;
    }

    /**
     * Retorna o thumb da oferta, como $offer->thumb
     * @return string
     */
    public function getThumbAttribute()
    {
        return '//'.Configuration::get('s3url').'/ofertas/'.$this->id.'/thumb/'.$this->getOriginal('cover_img');
    }
    /**
     * Retorna a data mínima para o uso da oferta, como $offer->min_date
     * @return string
     */
    public function getMinDateAttribute(){
        $dateMin = $this->offer_option->lists('voucher_validity_start');
        $dateStart = strtotime('+1 year');
        array_walk($dateMin, function($value) use(&$dateStart){
            $voucher_validity_start = strtotime(str_replace('/', '-', $value));
            if($voucher_validity_start <= $dateStart) $dateStart = $voucher_validity_start;
        });
        return $dateStart;
    }
    /**
     * Retorna a data limite para o uso da oferta, como $offer->max_date
     * @return string
     */
    public function getMaxDateAttribute(){
        $dateMax = $this->offer_option->lists('voucher_validity_end');
        $dateEnd = time();
        array_walk($dateMax, function($value) use(&$dateEnd){
            $voucher_validity_end = strtotime(str_replace('/', '-', $value));
            if($voucher_validity_end >= $dateEnd) $dateEnd = $voucher_validity_end;
        });
        return $dateEnd;
    }
    /**
     * Retorna true se pode vender e false se não
     * como $offer->can_sell
     * @return string
     */
    public function getCanSellAttribute(){
        $now = date('Y-m-d H:i:s');
        return ($this->getOriginal('starts_on') < $now && $this->getOriginal('ends_on') > $now && $this->is_active && $this->is_available);
    }

    /**
     * Retorna o número de cupons vendidos
     * como $offer->sold_paid
     * @return string
     */
    public function getSoldPaidAttribute(){
        return Voucher::whereIn('offer_option_id', $this->offer_option->lists('id'))->where('status', 'pago')->count();
    }

    /**
     * Retorna o número de cupons vendidos
     * como $offer->sold_paid
     * @return string
     */
    public function getSoldTotalAttribute(){
        return $this->sold + Voucher::whereIn('offer_option_id', $this->offer_option->lists('id'))->count();
    }

    /**
     * Formata o popup_features, de forma que
     * se estiver vazio, retorna os features
     *
     * @param $value
     * @return void
     */
    public function getPopupFeaturesAttribute($value)
    {
        return (empty($value)) ? $this->features : $value;
    }
}
