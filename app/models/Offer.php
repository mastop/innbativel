<?php

class Offer extends BaseModel {

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
    protected $fillable = [
        'partner_id', // Id do Parceiro
        'category_id', // Id da Categoria
        'genre_id', // Id do Gênero
        'genre2_id', // Id do Gênero 2
        'destiny_id', // Id do Destino
        'ngo_id', // Id da ONG
        'tell_us_id', // Id do depoimento do cliente
        'title', // Título
        'subtitle', // SubTítulo
        'subsubtitle', // SubTítulo 2
        'price_original', // Preço Original
        'price_with_discount', // Preço Com Desconto
        'percent_off', // %OFF
        'rules', // Regras
        'features', // Destaques
        'saveme_title', // Título Saveme
        'starts_on', // Data de Início
        'ends_on', // Data de Término
        'cover_img', // Imagem Principal
        'offer_old_img', // Imagem Pré-Reservas
        'newsletter_img', // Imagem Newsletters
        'saveme_img', // Imagem Saveme
        // 'video', // TODO: remover este campo da tabela
        'display_map', // Exibir mapa?
        'is_product', // Será publicada?
        'is_active', // Oferta ativa?
    ];

	protected $softDelete = false;
	public $timestamps = true;

	public static $rules = [
        'title' => 'required',
        'destiny_id' => 'required|integer',
        'partner_id' => 'required|integer',
        'ngo_id' => 'required|integer',
        'starts_on' => 'required',
        'ends_on' => 'required',
        'rules' => 'required',
        'category_id' => 'required|integer',
        'genre_id' => 'required|integer',
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
		return $this->belongsToMany('Saveme', 'offers_saveme', 'offer_id', 'saveme_id')->withPivot('priority');
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

    public function tag(){
        return $this->belongsToMany('Tag', 'offers_tags', 'offer_id', 'tag_id');
    }

	public function getFullDestinnyAttribute(){
        $destiny = Destiny::find($this->destiny_id);
		//return $destiny->city.'-'.$destiny->state_id;
		return $destiny->name;
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
