<?php

// use SebastianBergmann\Money\Currency;
// use SebastianBerBRLgmann\Money\Money;
// use SebastianBergmann\BRLMoney\IntlFormatter;

use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;

class PainelOrderController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $order;

	/**
	 * Construct Instance
	 */
	public function __construct(Order $order)
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
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

    	/*
		 * Search filter
		 */
    	if(Input::has('offer_id')){
    		$offersOptions = $offersOptions->where('offer_id', Input::get('offer_id'));
    	}

		$offersOptions = $offersOptions->with(['qty_sold', 'offer', 'used_vouchers'])
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
		$vouchers = new Voucher;

		$offers = Offer::with(['offer_option'])->where('partner_id', Auth::user()->id)->get();

		if($offers->count() < 1){
			// nenhuma oferta
			$error = 'Nenhum voucher (nenhuma venda) para a oferta.';
			return Redirect::route('paienl.order.offers')
						   ->withErrors($error);
		}

		// $offersOptions irá preencher o <select> da opção da qual estamos visualizando os vouchers/cupons
		foreach ($offers as $offer) {
			foreach ($offer['offer_option'] as $offer_option) {
				$t = $offer->id.' | '.$offer->destiny.' | '.$offer_option->title;
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
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


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

		$vouchers = $vouchers->with(['order'])
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
				 		                  ->whereRaw('orders.status IN ("aprovado", "pago")')
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

	public function getSchedule($id, $used, $offer_option_id = null){
		$voucher = Voucher::find($id);

		if (is_null($voucher))
		{
			return Redirect::route('painel.order.voucher', ['offer_option_id' => $offer_option_id]);
		}

		$voucher->used = ($used == 0)?0:1;
		$voucher->save();

		return Redirect::route('painel.order.voucher', ['offer_option_id' => $offer_option_id]);
	}

	public function getVoucherExport($offer_option_id = null, $id = null){
		$id = ($id == 'null')?null:$id;
		$offer_option_id = ($offer_option_id == 'null')?null:$offer_option_id;

		$vouchers = new Voucher;

		if(isset($offer_option_id)){
			$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
		}

		if(isset($id)){
			$vouchers = $vouchers->where('id', $id);
		}

		$vouchers = $vouchers->with(['order', 'offer_option'])
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
				 		                  ->whereRaw('orders.status IN ("aprovado", "pago")')
				 						  ->whereRaw('orders.id = vouchers.order_id');
		               	   	 })
		 					 ->orderBy('id', 'asc')
		 					 ->get();

		$spreadsheet = array();
		$spreadsheet[] = array('ID da oferta', 'Cupom', 'Agendado?', 'Nome', 'E-mail');

		foreach ($vouchers as $voucher) {
			$ss = null;
			$ss[] = $voucher['offer_option']->offer_id;
			$ss[] = $voucher->id.'-'.$voucher->display_code;
			$ss[] = ($voucher->used == 1)?'Sim':'Não';
			$ss[] = $voucher['order']->first_name.' '.$voucher['order']->last_name;
			$ss[] = $voucher['order']->email;

			$spreadsheet[] = $ss;
		}

		print('<pre>');
		print_r($spreadsheet);
		print('</pre>');

		// $config = new ExporterConfig();
		// $exporter = new Exporter($config);

		// $exporter->export('php://output', $spreadsheet);
	}

	public function getListOffersExport($offer_id, $starts_on, $ends_on){
		$offersOptions = new OfferOption;

		$offer_id = ($offer_id == 'null')?null:$offer_id;
		$starts_on = ($starts_on == 'null')?null:$starts_on;
		$ends_on = ($ends_on == 'null')?null:$ends_on;

		/*
		 * Search filter
		 */
    	if(Input::has('offer_id')){
    		$offersOptions = $offersOptions->where('offer_id', Input::get('offer_id'));
    	}

		$offersOptions = $offersOptions->with(['qty_sold', 'offer', 'used_vouchers'])
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
			$ss[] = isset($offerOption['used_vouchers']{0})?$offerOption['used_vouchers']{0}->qty:'0';
			$ss[] = $offerOption->max_qty;

			$approved = 0;
			$pending = 0;
			$cancelled = 0;

			foreach ($offerOption['qty_sold'] as $qty_sold) {
				if(in_array($qty_sold->status, array('aprovado', 'pago'))){
					$approved += $qty_sold['pivot']->qty;
				}
				else if(in_array($qty_sold->status, array('iniciado', 'revisao', 'pendente'))){
					$pending += $qty_sold['pivot']->qty;
				}
				else{
					$cancelled += $qty_sold['pivot']->qty;
				}
			}

			$ss[] = $approved;
			$ss[] = $pending;
			$ss[] = $cancelled;
			$ss[] = ($approved + $pending + $cancelled);

			$spreadsheet[] = $ss;
		}

		print('<pre>');
		print_r($spreadsheet);
		print('</pre>');

		// $config = new ExporterConfig();
		// $exporter = new Exporter($config);

		// $exporter->export('php://output', $spreadsheet);
	}

}
