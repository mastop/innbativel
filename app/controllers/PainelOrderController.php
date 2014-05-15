<?php

// use SebastianBergmann\Money\Currency;
// use SebastianBerBRLgmann\Money\Money;
// use SebastianBergmann\BRLMoney\IntlFormatter;

class PainelOrderController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $order, $voucher;

	/**
	 * Construct Instance
	 */
	public function __construct(Order $order, Voucher $voucher)
	{
		/*
		 * Enable Sidebar
		 */

		$this->sidebar = true;

		/*
		 * Enable and Set Actions
		 */

		$this->actions = 'painel.order';

		/*
		 * Models Instance
		 */

		$this->order = $order;
		$this->voucher = $voucher;
	}

	public function anyListByOffer(){
		$offersOptions = new OfferOption;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '10';

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['id']) ? Input::get('sort') : 'offer_id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';

    	/*
		 * Search filter
		 */
    	if(Input::has('offer_id')){
    		$offersOptions = $offersOptions->where('offer_id', Input::get('offer_id'));
    	}

		$offersOptions = $offersOptions->with(['qty_sold', 'qty_pending', 'qty_cancelled', 'used_vouchers', 'offer'])
									   ->whereExists(function($query){
							                if (Input::has('starts_on') || Input::has('ends_on')) {
												$query->select(DB::raw(1))
								                      ->from('offers')
													  ->whereRaw('offers.id = offers_options.offer_id');
							                	if (Input::has('starts_on')) {
							                		$query->whereRaw('offers.starts_on >= "'.Input::get('starts_on').'"');
							                	}
							                	if (Input::has('ends_on')) {
							                		$query->whereRaw('offers.ends_on <= "'.Input::get('ends_on').'"');
							                	}
											}
						               })
						               ->whereExists(function($query){
							                $query->select(DB::raw(1))
								                  ->from('offers')
								                  ->whereRaw('offers.id = offers_options.offer_id')
												  ->whereRaw('offers.partner_id = '.Auth::user()->id);
						               })
									   ->orderBy($sort, $order)
									   ->paginate($pag)
									   ->appends([
											'sort' => $sort,
											'order' => $order,
											'offer_id' => Input::get('offer_id'),
											'starts_on' => Input::get('starts_on'),
											'ends_on' => Input::get('ends_on'),
									   ]);

		$this->layout->content = View::make('painel.order.offers', compact('sort', 'order', 'pag', 'offersOptions'));
	}

	public function anyVouchers($offer_option_id = null){
		$vouchers = $this->voucher;

		$offers = Offer::with(['offer_option'])->where('partner_id', Auth::user()->id)->get();

		// Exibe somente vouchers pagos
		$vouchers = $vouchers->where('status', 'pago');

		if($offers->count() < 1){
			// nenhuma oferta
			$error = 'Nenhum voucher (nenhuma venda) para a oferta.';
			return Redirect::route('painel.order.offers')
						   ->withErrors($error);
		}

		// $offersOptions irá preencher o <select> da opção da qual estamos visualizando os vouchers/cupons
		foreach ($offers as $offer) {
			foreach ($offer['offer_option'] as $offer_option) {
				$t = $offer->id.' | '.$offer->title.' | '.$offer_option->title;
				$offersOptions[$offer_option->id] = $t;
			}
		}

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['display_code']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';


		/*
		 * Search filters
		 */
		if (Input::has('offer_option_id')) {
			$offer_option_id = Input::get('offer_option_id');
			$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
		}
		else if(isset($offer_option_id)){
			$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
		}

		if(Input::has('id')){
			$vouchers = $vouchers->where('id', Input::get('id'));
		}

		$vouchers = $vouchers->with(['offer_option_offer'])
							 ->whereExists(function($query){
				 	                $query->select(DB::raw(1))
				 		                  ->from('offers')
				 		                  ->leftJoin('offers_options', 'offers_options.offer_id', '=', 'offers.id')
				 		                  ->whereRaw('vouchers.offer_option_id = offers_options.id')
				 						  ->whereRaw('offers.partner_id = '.Auth::user()->id);
		               	   	 })
							 ->whereExists(function($query){
				 	                $query->select(DB::raw(1))
				 		                  ->from('orders')
				 		                  ->whereRaw('orders.status = "pago"')
				 						  ->whereRaw('orders.id = vouchers.order_id');
		               	   	 })
							 ->orderBy($sort, $order)
							 ->paginate($pag)
							 ->appends([
								 'sort' => $sort,
								 'order' => $order,
								 'offer_option_id' => $offer_option_id,
								 'id' => Input::get('id'),
							 ]);
							 // ->get()->toArray();

							 // print('<pre>');
							 // print_r($vouchers);
							 // print('</pre>'); die();

		$this->layout->content = View::make('painel.order.voucher', compact('sort', 'order', 'pag', 'offer_option_id', 'vouchers', 'offersOptions'));
	}

	public function getSchedule($id, $used){
		$voucher = Voucher::find($id);

		if (is_null($voucher))
		{
			Session::flash('error', 'Voucher com código #'.$id.' invlido.');
			return Redirect::back();
		}

		$voucher->used = ($used == 0)?false:true;
		$voucher->save();

		Session::flash('success', 'Voucher com código #'.$id.' foi '.(($used == 0)?'desagendado':'agendado').' com sucesso.');
		return Redirect::back();
	}

	public function getVoucherExport($offer_option_id = null, $id = null){
		$id = ($id == 'null')?null:$id;
		$offer_option_id = ($offer_option_id == 'null')?null:$offer_option_id;

		$vouchers = $this->voucher;

		$vouchers = $vouchers->where('status', 'pago');

		if(isset($offer_option_id)){
			$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
		}

		if(isset($id)){
			$vouchers = $vouchers->where('id', $id);
		}

		$vouchers = $vouchers->with(['offer_option_offer'])
							 ->whereExists(function($query){
				 	                $query->select(DB::raw(1))
				 		                  ->from('offers')
				 		                  ->leftJoin('offers_options', 'offers_options.offer_id', '=', 'offers.id')
				 		                  ->whereRaw('vouchers.offer_option_id = offers_options.id')
				 						  ->whereRaw('offers.partner_id = '.Auth::user()->id);
	               	   	     })
	               	   	     ->whereExists(function($query){
				 	                $query->select(DB::raw(1))
				 		                  ->from('orders')
				 		                  ->whereRaw('orders.status = "pago"')
				 						  ->whereRaw('orders.id = vouchers.order_id');
		               	   	 })
		 					 ->orderBy('id', 'desc')
		 					 ->get()->toArray();

		// print('<pre>');
		// print_r($vouchers);
		// print('</pre>'); die();

		$spreadsheet = array();
		$spreadsheet[] = array('Cupom', 'ID da oferta', 'Validado?', 'Nome', 'Código de rastreamento');

		foreach ($vouchers as $voucher) {
			$ss = null;
			$ss[] = $voucher['id'].'-'.$voucher['display_code'].'-'.$voucher['offer_option_offer']['offer_id'];
			$ss[] = $voucher['offer_option_offer']['id'];
			$ss[] = ($voucher['used'] == 1)?'Sim':'Não';
			$ss[] = $voucher['name'];
			$ss[] = $voucher['tracking_code'];

			$spreadsheet[] = $ss;
		}

		Excel::create('CuponsINNBativel')
	         ->sheet('CuponsINNBativel')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function getListOffersExport($offer_id, $starts_on, $ends_on){
		$offersOptions = new OfferOption;

		$offer_id = ($offer_id == 'null')?null:$offer_id;
		$starts_on = ($starts_on == 'null')?null:$starts_on;
		$ends_on = ($ends_on == 'null')?null:$ends_on;

		/*
		 * Search filter
		 */
    	if($offer_id){
    		$offersOptions = $offersOptions->where('offer_id', $offer_id);
    	}

		$offersOptions = $offersOptions->with(['qty_sold', 'qty_pending', 'qty_cancelled', 'offer'])
									   ->whereExists(function($query) use($starts_on, $ends_on){
							                if (isset($starts_on) || isset($ends_on)) {
												$query->select(DB::raw(1))
								                      ->from('offers')
													  ->whereRaw('offers.id = offers_options.offer_id');
							                	if (isset($starts_on)) {
							                		$query->whereRaw('offers.starts_on >= "'.$starts_on.'"');
							                	}
							                	if (isset($ends_on)) {
							                		$query->whereRaw('offers.ends_on <= "'.$ends_on.'"');
							                	}
											}

							           })
							           ->whereExists(function($query){
								                $query->select(DB::raw(1))
									                  ->from('offers')
									                  ->whereRaw('offers.id = offers_options.offer_id')
													  ->whereRaw('offers.partner_id = '.Auth::user()->id);
							           })
									   ->orderBy('offer_id', 'desc')
									   ->get();

		$spreadsheet = array();
		$spreadsheet[] = array('ID da oferta', 'Oferta', 'Opção', 'Data início', 'Data fim', 'Valor', 'Cupons usados', 'Máximo', 'Confirmados', 'Pendentes', 'Cancelados', 'Total');

		foreach ($offersOptions as $offerOption) {
			$ss = null;
			$ss[] = $offerOption->offer_id;
			$ss[] = $offerOption['offer']->title;
			$ss[] = $offerOption->title;
			$ss[] = $offerOption['offer']->starts_on;
			$ss[] = $offerOption['offer']->ends_on;
			$ss[] = $offerOption->price_with_discount;
			$ss[] = $offerOption->max_qty;

			$approved = isset($offerOption['qty_sold']{0})?$offerOption['qty_sold']{0}->qty:0;
			$pending = isset($offerOption['qty_pending']{0})?$offerOption['qty_pending']{0}->qty:0;
			$cancelled = isset($offerOption['qty_cancelled']{0})?$offerOption['qty_cancelled']{0}->qty:0;

			$ss[] = $approved;
			$ss[] = $pending;
			$ss[] = $cancelled;
			$ss[] = ($approved + $pending + $cancelled);

			$spreadsheet[] = $ss;
		}

		Excel::create('OfertasINNBativel')
	         ->sheet('OfertasINNBativel')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function postUpdateTrackingCode($id){
		$voucher = Voucher::find($id);

		if (is_null($voucher))
		{
			return Redirect::back();
		}

		// Ideia para quando o usuário comprar uma quantidade N maior que 1 do mesmo item, e que vai gerar N vouchers
		// (e será entregue com o mesmo código de rastreamente para todos): no modal, colocar checkbox: 
		// inserir codigo de rastreamento nos demais vouchers da mesma compra?
		// se estiver checado, basta carregar todos os vouchers da mesma compra do produto com mesmo order_id e offer_option_id

		$tracking_code = Input::get('tracking_code');
		$voucher->tracking_code = $tracking_code;
		$voucher->save();

		Session::flash('success', 'Voucher com código #'.$id.' teve o código de reastreamento atualizado para '.$tracking_code.' com sucesso.');
		return Redirect::back();
	}

}
