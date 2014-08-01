<?php

class OfferOption extends BaseModel {

	/**
	* The name of the table associated with the model.
	*
	* @var string
	*/
	protected $table = 'offers_options';

	protected $guarded = [];
    protected $fillable = [
        'offer_id', // ID da Oferta
        'title', // Título
        'subtitle', // SubTítulo
        'price_original', // Preço Original
        'price_with_discount', // Preço Com Desconto
        'transfer', // Repasse ao Parceiro
        'min_qty', // Estoque Mínimo
        'max_qty', // Estoque Máximo
        'percent_off', // %OFF
        'voucher_validity_start', // Início Validade Cupom
        'voucher_validity_end', // Fim Validade Cupom
        'display_order', // Ordem
        'is_active', // Ativa
    ];

	protected $softDelete = true;
	public $timestamps = false;

	public static $rules = array(
	 'title' => 'required',
	 //'subtitle' => 'required',
	 'price_with_discount' => 'required',
	 'min_qty' => 'required|integer',
	 'max_qty' => 'required|integer',
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

    public function qty_sold_boletus(){
        return $this->hasMany('Voucher', 'offer_option_id')
                    ->where('vouchers.status', 'pago')
                    ->whereExists(function($query){
                        $query->select(DB::raw(1))
                              ->from('orders')
                              ->whereRaw('orders.id = vouchers.order_id')
                              ->whereRaw('orders.payment_terms = "Boleto"');
                    })
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
					->whereIn('vouchers.status', ['cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial'])
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
	}

	public function used_vouchers(){
		return $this->hasMany('Voucher', 'offer_option_id')
					->where('vouchers.used', true)
					->select([DB::raw('COUNT(vouchers.id) AS qty'), 'vouchers.offer_option_id'])
					->groupBy('vouchers.offer_option_id');
	}

	public function departure_city(){
		return $this->belongsTo('Destiny', 'departure_city_id');
	}

    /**
     * Formata a data de Início Validade Cupom, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd HH:ii:ss
     *
     * @param $value
     * @return void
     */
    public function setVoucherValidityStartAttribute($value)
    {
        $starts_on = implode("-",array_reverse(explode("/",$value)));
        $starts_on .= ' 00:00:00';
        $this->attributes['voucher_validity_start'] = $starts_on;
    }

    /**
     * Formata a data de Fim Validade Cupom, pegando dd/mm/YYYY
     * e transformando em YYYY-mm-dd HH:ii:ss
     *
     * @param $value
     * @return void
     */
    public function setVoucherValidityEndAttribute($value)
    {
        $ends_on = implode("-",array_reverse(explode("/",$value)));
        $ends_on .= ' 23:59:59';
        $this->attributes['voucher_validity_end'] = $ends_on;
    }

    /**
     * Formata o valor original, para transformar
     * 1.2345,67 em 12345.76
     *
     * @param $value
     * @return void
     */
    public function setPriceOriginalAttribute($value){
        $v = str_replace(',', '.', str_replace('.', '', $value));
        $this->attributes['price_original'] = $v;
    }

    /**
     * Formata o valor com desconto, para transformar
     * 1.2345,67 em 12345.76
     *
     * @param $value
     * @return void
     */
    public function setPriceWithDiscountAttribute($value){
        $v = str_replace(',', '.', str_replace('.', '', $value));
        $this->attributes['price_with_discount'] = $v;
    }

    /**
     * Formata o valor de repasse ao parceiro, para transformar
     * 1.2345,67 em 12345.76
     *
     * @param $value
     * @return void
     */
    public function setTransferAttribute($value){
        $v = str_replace(',', '.', str_replace('.', '', $value));
        $this->attributes['transfer'] = $v;
    }


    /**
     * Formata a data de Início Validade Cupom, pegando YYYY-mm-dd HH:ii:ss
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getVoucherValidityStartAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Formata a data de Fim Validade Cupom, pegando YYYY-mm-dd HH:ii:ss
     * e transformando em dd/mm/YYYY
     *
     * @param $value
     * @return string
     */
    public function getVoucherValidityEndAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    public function getIsExpiredAttribute(){
        return (time() > strtotime($this->getOriginal('voucher_validity_end'))) ? true : false;
    }
}
