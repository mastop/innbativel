<?php

// use SebastianBergmann\Money\Currency;
// use SebastianBerBRLgmann\Money\Money;
// use SebastianBergmann\BRLMoney\IntlFormatter;

class AdminOrderController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $order;

	/**
	 * Information Restriction
	 *
	 * @var comercial_restriction
	 */
	protected $comercial_restriction;

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

		$this->actions = 'admin.order';

		/*
		 * Comercial role can't see offers by Tourin (partner_id = 999999999), additional SQL
		 */
		$this->comercial_restriction = Auth::user()->is('comercial') ? 'offers.partner_id != 70080' : NULL;

		/*
		 * Models Instance
		 */

		$this->order = $order;
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$orderData = $this->order;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';


		/*
		 * Search filters
		 */
		if (Input::has('status') AND Input::get('status') != '') {
			if(Input::get('status') == 'cancelado'){
				$orderData = $orderData->whereIn('status', ['cancelado', 'convercao_creditos', 'cancelado_parcial']);
			}
			else {
				$orderData = $orderData->where('status', '=', Input::get('status'));
			}
		}

		if (Input::has('terms') AND Input::get('terms') != '') {
			$orderData = $orderData->where('payment_terms', 'like', '%'. Input::get('terms') .'%');
		}

		if (Input::has('braspag_order_id')) {
			$orderData = $orderData->where('braspag_order_id', 'like', '%'. Input::get('braspag_order_id') .'%');
		}

		if (Input::has('date_start')) {
			$orderData = $orderData->where('created_at', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$orderData = $orderData->where('created_at', '<=', Input::get('date_end'));
		}

		$orderArray = $orderData->with(['buyer', 'offer_option_offer'])
								->whereExists(function($query){
					                if (Input::has('offer_id')) {
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
						                      ->whereRaw('vouchers.order_id = orders.id')
						                      ->whereRaw('offers_options.offer_id = '.Input::get('offer_id'));
									}

					            })
					            ->whereExists(function($query){
					                if (isset($this->comercial_restriction)) {
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
											  ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
						                      ->whereRaw('vouchers.order_id = orders.id')
						                      ->whereRaw($this->comercial_restriction);
									}

					            })
								->whereExists(function($query){
					                if (Input::has('name')) {
										$query->select(DB::raw(1))
						                      ->from('profiles')
											  ->whereRaw('profiles.user_id = orders.user_id')
											  ->whereRaw('CONCAT(COALESCE(profiles.first_name, ""), " ", COALESCE(profiles.last_name, "")) LIKE "%'.Input::get('name').'%"');
									}

					            })
					            ->whereExists(function($query){
					                if (Input::has('email')) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->whereRaw('users.id = orders.user_id')
											  ->whereRaw('users.email LIKE "%'.Input::get('email').'%"');
									}

					            })
								->orderBy($sort, $order)
								->paginate($pag)
								->appends([
									'sort' => $sort,
									'order' => $order,
									'pag' => $pag,
									'status' => Input::get('status'),
									'terms' => Input::get('terms'),
									'date_start' => Input::get('date_start'),
									'date_end' => Input::get('date_end'),
									'offer_id' => Input::get('offer_id'),
									'name' => Input::get('name'),
									'email' => Input::get('email'),
								]);
								// ->limit(25)->get(); print('<pre>'); print_r($orderArray->toArray()); print('</pre>'); die();

		foreach ($orderArray as $key => &$value) {
			if(isset($value['offer_option_offer'])){
				$braspag_order_id = $value->braspag_order_id;
				$id = $value->id;

				$value->braspag_order_id = link_to_route('admin.order.view', $braspag_order_id, ['id' => $id], ['title' => 'Ver detalhes']);
				$value->braspag_order_id_string = $braspag_order_id;

				// $m = new Money($value->total, new Currency('BRL'));
				// $f = new IntlFormatter('pt_BR');
				// $value->total = $f->format($m);

				// $orderArray[] = $value;
			}
		}

		$this->layout->content = View::make('admin.order.list', compact('sort', 'order', 'pag', 'orderArray'));
	}

	public function anyListByOffer(){
		$offersOptions = new OfferOption;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

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

		$offersOptions = $offersOptions->with(['qty_sold', 'qty_pending', 'qty_cancelled', 'used_vouchers', 'offer' => function($query){ $query->withTrashed(); }])
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
							                if (isset($this->comercial_restriction)) {
												$query->select(DB::raw(1))
								                      ->from('offers')
								                      ->whereRaw('offers.id = offers_options.offer_id')
								                      ->whereRaw($this->comercial_restriction);
											}

							            })
									   ->orderBy($sort, $order)
									   ->paginate($pag)
									   ->appends([
											'sort' => $sort,
											'order' => $order,
											'pag' => $pag,
											'offer_id' => Input::get('offer_id'),
											'starts_on' => Input::get('starts_on'),
											'ends_on' => Input::get('ends_on'),
									   ]);

		$this->layout->content = View::make('admin.order.offers', compact('sort', 'order', 'pag', 'offersOptions'));
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
								                if (isset($this->comercial_restriction)) {
													$query->select(DB::raw(1))
									                      ->from('offers')
									                      ->whereRaw('offers.id = offers_options.offer_id')
									                      ->whereRaw($this->comercial_restriction);
												}

								            })
											->orderBy('offer_id', 'desc')
											->get();

		$spreadsheet = array();
		$spreadsheet[] = array('ID da oferta', 'Oferta', 'Opção', 'Data início', 'Data fim', 'Valor', 'Máximo', 'Confirmados', 'Pendentes', 'Cancelados', 'Total');

		foreach ($offersOptions as $offerOption) {
			$ss = null;
			$ss[] = $offerOption->offer_id;
			$ss[] = $offerOption['offer']['destiny']->name;
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

		Excel::create('PagamentosOfertas')
	         ->sheet('PagamentosOfertas')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function getListPaymExport($status, $terms, $name, $email, $braspag_order_id, $offer_id, $date_start, $date_end){
		$status = ($status == 'null')?null:$status;
		$terms = ($terms == 'null')?null:$terms;
		$name = ($name == 'null')?null:$name;
		$email = ($email == 'null')?null:$email;
		$braspag_order_id = ($braspag_order_id == 'null')?null:$braspag_order_id;
		$offer_id = ($offer_id == 'null')?null:$offer_id;
		$date_start = ($date_start == 'null')?null:$date_start;
		$date_end = ($date_end == 'null')?null:$date_end;

		/*
		 * Obj
		 */
		$orderData = $this->order;


		/*
		 * Search filters
		 */
		if ($status) {
			$orderData = $orderData->where('status', $status);
		}

		if ($terms) {
			$orderData = $orderData->where('payment_terms', 'like', '%'. $terms .'%');
		}

		if ($braspag_order_id) {
			$orderData = $orderData->where('braspag_order_id', 'like', '%'. $braspag_order_id .'%');
		}

		if ($date_start) {
			$orderData = $orderData->where('created_at', '>=', $date_start);
		}

		if ($date_end) {
			$orderData = $orderData->where('created_at', '<=', $date_end);
		}

		$orderArray = $orderData->with(['user', 'voucher_offer'])
								->whereExists(function($query) use($offer_id){
					                if ($offer_id) {
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
						                      ->whereRaw('vouchers.order_id = orders.id')
						                      ->whereRaw('offers_options.offer_id = '.$offer_id);
									}

					            })
					            ->whereExists(function($query){
					                if (isset($this->comercial_restriction)) {
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
											  ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
						                      ->whereRaw('vouchers.order_id = orders.id')
						                      ->whereRaw($this->comercial_restriction);
									}

					            })
								->whereExists(function($query) use($name){
					                if ($name) {
										$query->select(DB::raw(1))
						                      ->from('profiles')
											  ->whereRaw('profiles.user_id = orders.user_id')
											  ->whereRaw('CONCAT(COALESCE(profiles.first_name, ""), " ", COALESCE(profiles.last_name, "")) LIKE "%'.$name.'%"');
									}

					            })
					            ->whereExists(function($query) use($email){
					                if ($email) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->whereRaw('users.id = orders.user_id')
											  ->whereRaw('users.email LIKE "%'.$email.'%"');
									}

					            })
								->orderBy('id', 'desc')
								->get();

		// print('<pre>');
		// print_r($orderArray->toArray());
		// print('</pre>'); die();

		$spreadsheet = array();
		$spreadsheet[] = array('ID', 'Status', 'Valor pago', 'Itens comprados', 'Forma de pagamento', 'Data e hora', 'Cliente');

		foreach ($orderArray as $order) {
			$ss = null;
			$ss[] = $order->id;
			$ss[] = $order->status;
			$ss[] = $order->total;

			$itens = '';

			foreach ($order->voucher_offer as $voucher) {
				if(isset($voucher->offer_option_offer)) $itens .= 'R$ '.number_format($voucher->offer_option_offer->price_with_discount, '2', ',', '.').' ('.$voucher->status.') #'.$voucher->offer_option_offer->offer->id.' '.$voucher->offer_option_offer->offer->title.' ('.$voucher->offer_option_offer->title.') | ';
			}

			$ss[] = substr($itens, 0, -3);

			$ss[] = $order->payment_terms;
			$ss[] = date('d/m/Y H:i:s', strtotime($order->created_at));
			$ss[] = $order['user']->first_name.' '.$order['user']->last_name.' | '.$order['user']->email;

			$spreadsheet[] = $ss;
		}

		Excel::create('Pagamentos')
	         ->sheet('Pagamentos')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function getOffersExport($offer_option_id, $status = NULL){
		$ordersObj = $this->order;
		
		$ordersData = $ordersObj->with([
										'user',
										'discount_coupon',
										'offer_option_offer' => function($query) use($offer_option_id){
												   $query->where('offers_options.id', $offer_option_id);
											  	},
										'voucher' => function($query) use($offer_option_id, $status){
													if(isset($status)){
														if($status == 'cancelado'){
															$query->where('vouchers.offer_option_id', $offer_option_id)->whereIn('vouchers.status', ['cancelado', 'cancelado_parcial', 'convercao_creditos', 'convercao_creditos_parcial']);
														}
														else{
															$query->where('vouchers.offer_option_id', $offer_option_id)->where('vouchers.status', $status);
														}
													}
													else{
														$query->where('vouchers.offer_option_id', $offer_option_id);
													}
												}
								])
								->whereExists(function($query) use($offer_option_id, $status){
									if(isset($status)){
										if($status == 'cancelado'){
											$query->select(DB::raw(1))
							                      ->from('vouchers')
												  ->whereRaw('vouchers.order_id = orders.id')
												  ->whereRaw('vouchers.offer_option_id = "'.$offer_option_id.'"')
												  ->whereRaw('vouchers.status IN ("cancelado", "cancelado_parcial", "convercao_creditos", "convercao_creditos_parcial")');
										}
										else{
											$query->select(DB::raw(1))
							                      ->from('vouchers')
												  ->whereRaw('vouchers.order_id = orders.id')
												  ->whereRaw('vouchers.offer_option_id = "'.$offer_option_id.'"')
												  ->whereRaw('vouchers.status = "'.$status.'"');
										}
									}
									else{
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->whereRaw('vouchers.order_id = orders.id')
											  ->whereRaw('vouchers.offer_option_id = "'.$offer_option_id.'"');
									}
					            })
								->whereExists(function($query){
					                if (isset($this->comercial_restriction)) {
										$query->select(DB::raw(1))
						                      ->from('vouchers')
											  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
											  ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
						                      ->whereRaw('vouchers.order_id = orders.id')
						                      ->whereRaw($this->comercial_restriction);
									}

					            })
								->get();

		$spreadsheet = array();
		$spreadsheet[] = array('Número do pedido', 'status', 'ID da oferta', 'Oferta', 'Opção', 'Preço', 'Quantidade', 'Usuário INN', 'E-mail', 'Forma de pagamento', 'Titular do cartão', 'Telefone', 'Desconto via cupom', 'Desconto via créditos', 'Data de início', 'Data da captura da transação', 'Última atualização');

		foreach ($ordersData as $order) {
			$ss = null;
			$ss[] = $order->braspag_order_id;
			$ss[] = $order->status;
			$ss[] = $order->offer_option_offer{0}->offer_id;
			$ss[] = $order->offer_option_offer{0}->offer->title;
			$ss[] = $order->offer_option_offer{0}->title;
			$ss[] = $order->offer_option_offer{0}->price_with_discount;
			$ss[] = count($order->voucher);
			$ss[] = $order['user']->first_name.' '.$order['user']->last_name;
			$ss[] = $order['user']->email;
			$ss[] = $order->payment_terms;
			$ss[] = $order->holder_card;
			$ss[] = $order->telephone;
			$ss[] = isset($order['discount_coupon'])?$order['discount_coupon']->value:'--';
			$ss[] = $order->credit_discount;
			$ss[] = date('d/m/Y H:i:s', strtotime($order->created_at));
			$ss[] = date('d/m/Y H:i:s', strtotime($order->updated_at));
			$ss[] = date('d/m/Y H:i:s', strtotime($order->capture_date));

			$spreadsheet[] = $ss;
		}
		$title = 'Ofertas'.(isset($status)?'_'.$status:'');
		Excel::create($title)
	         ->sheet($title)
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function anyVouchers($offer_option_id = null){
		$vouchers = new Voucher;

		// Exibe somente vouchers pagos
		$vouchers = $vouchers->where('status', 'pago');

		$offers = new Offer;

		if(isset($this->comercial_restriction)){
			$offers = $offers->whereRaw($this->comercial_restriction);
		}

		$offers = $offers->with(['offer_option'])->orderBy('id', 'desc')->get();

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

        $pag = Input::get('pag', 50);

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
				 		                  ->from('orders')
				 		                  ->whereRaw('orders.status = "pago"')
				 						  ->whereRaw('orders.id = vouchers.order_id');
		               	   	 })
		               	   	 ->whereExists(function($query){
				                if (isset($this->comercial_restriction)) {
									$query->select(DB::raw(1))
					                      ->from('offers_options')
										  ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
					                      ->whereRaw('offers_options.id = vouchers.offer_option_id')
					                      ->whereRaw($this->comercial_restriction);
								}

				             })
							 ->orderBy($sort, $order)
							 ->paginate($pag)
							 ->appends([
								 'sort' => $sort,
								 'order' => $order,
								 'pag' => $pag,
								 'offer_option_id' => $offer_option_id,
								 'id' => Input::get('id'),
							 ]);
							 // ->get()->toArray();

							 // print('<pre>');
							 // print_r($vouchers);
							 // print('</pre>'); die();

		$this->layout->content = View::make('admin.order.voucher', compact('sort', 'order', 'pag', 'offer_option_id', 'vouchers', 'offersOptions'));
	}

	public function getVoucherExport($offer_option_id = null, $id = null){
		$id = ($id == 'null')?null:$id;
		$offer_option_id = ($offer_option_id == 'null')?null:$offer_option_id;

		$vouchers = new Voucher;

		$vouchers = $vouchers->where('status', 'pago');

		if(isset($offer_option_id)){
			$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
		}

		if(isset($id)){
			$vouchers = $vouchers->where('id', $id);
		}

		$vouchers = $vouchers->with(['order_customer', 'offer_option_offer'])
	               	   	     ->whereExists(function($query){
				 	                $query->select(DB::raw(1))
				 		                  ->from('orders')
				 		                  ->whereRaw('orders.status = "pago"')
				 						  ->whereRaw('orders.id = vouchers.order_id');
		               	   	 })
		               	   	 ->whereExists(function($query){
				                if (isset($this->comercial_restriction)) {
									$query->select(DB::raw(1))
					                      ->from('offers_options')
										  ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
					                      ->whereRaw('offers_options.id = vouchers.offer_option_id')
					                      ->whereRaw($this->comercial_restriction);
								}

				             })
		 					 ->orderBy('id', 'asc')
		 					 ->get();

		$spreadsheet = array();
		$spreadsheet[] = array('ID da oferta', 'Cupom', 'Validado?', 'Nome', 'E-mail', 'Código de rastreamento');

		foreach ($vouchers as $voucher) {
			$ss = null;
			$ss[] = $voucher->offer_option_offer->offer->id;
			$ss[] = $voucher->id.'-'.$voucher->display_code.'-'.$voucher->offer_option_offer->offer->id;
			$ss[] = ($voucher->used == 1)?'Sim':'Não';
			$ss[] = $voucher->order_customer->user['first_name'].' '.$voucher->order_customer->user['last_name'];
			$ss[] = $voucher->order_customer->user['email'];
			$ss[] = $voucher->tracking_code;

			$spreadsheet[] = $ss;
		}

		Excel::create('Vouchers')
	         ->sheet('Vouchers')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function getView($id)
	{
		$order = $this->order
					  ->findOrFail($id)
					  ->with([
						'buyer',
						'offer_option_offer',
						'discount_coupon',
					  ])
					  ->where('id', $id)
					  ->first();
		// print('<pre>');
		// print_r($order);
		// print('</pre>'); die();

		$transaction = Transaction::where('order_id', $id)->get();

		return View::make('admin.order.view', compact('order', 'transaction'));
	}

	public function getVoucherCancel(){
		$voucher = Voucher::where('id', Input::get('id'))->first();
		if($voucher->status == 'pago'){
			$voucher->status = (Input::get('convert_credits') == 0)?'cancelado_parcial':'convercao_creditos_parcial';
			$voucher->save();

			$order = $this->order->where('id', Input::get('order_id'))->first();
			$order->history .= date('d/m/Y H:i:s') . " - Cancelamento parcial de cupom (\"" . Input::get('comment') . "\" por " . Auth::user()->email . ")"."\r\n";
			$order->save();

			return Redirect::back()->with('success', 'Voucher '.$voucher->id.'-'.$voucher->display_code.' cancelado com sucesso.');
		}

		return Redirect::back()->with('error', 'Voucher '.$voucher->id.'-'.$voucher->display_code.' não pôde ser cancelado pois já estava cancelado.');
	}

	public function sendTransactionalEmail($order, $new_status){
		$ids = array();
		$qties = array();
		$products_email = '';

		$vouchers = Voucher::with(['offer_option_offer'])->where('order_id', $order->id)->get();

		foreach ($vouchers as $voucher) {
			$products_email .= '<a href="' . route('oferta', $voucher->offer_option_offer->offer->slug) . '">' . (isset($voucher->offer_option_offer->offer->destiny)?$voucher->offer_option_offer->offer->destiny->name:$voucher->offer_option_offer->offer->title) . ' | ' . $voucher->offer_option_offer->title . '</a><br/>';
		}

		// Removendo o último </br>
		$products_email = substr($products_email, 0, -5);

		$user = User::where('id',$order->user_id)->with(['profile'])->first();

        $data = array('name' => $user->profile->first_name, 'products' => $products_email);

        if($new_status == 'pago'){
        	Mail::send('emails.order.order_approved', $data, function($message) use ($user){
				$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra aprovada');
			});
        }
        else{ // $new_status = 'cancelado'
        	Mail::send('emails.order.order_rejected', $data, function($message) use ($user){
				$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Pagamento não aprovado');
			});
        }

	}

	public function getUpdateStatus($id, $status, $comment){
        if($status != 'pago' && $status != 'cancelado'){
            Session::flash('error', 'O status deve ser "pago" ou "cancelado"');
            return Redirect::back();
        }

        $order = Order::where('id', $id)->first();

        $this->updateOrder($order, $status, $comment);
        $this->sendTransactionalEmail($order, $status);

        return Redirect::route('admin.order', ['braspag_order_id' => $order->braspag_order_id])->with('success', 'O pagamento '.$order->braspag_order_id.' foi marcado como pago.');
    }

	private function updateOrder($order, $new_status, $comment){
		$old_status = $order->status;
		$order->status = $new_status;
		$order->history .= date('d/m/Y H:i:s') . " - Status alterado para " . $new_status . " (\"" . $comment . "\" por " . Auth::user()->email . ")"."\r\n";
		$order->save();

		Voucher::where('order_id', $order->id)->where('status', $old_status)->update(['status' => $new_status]);

		// inserir creditos por indicação
		// $credit_ind_user = UserCredit::where('new_user_id', '=', $order->user_id)->first();

		// if($credit_ind_user){
		// 	$indicator_user = Profile::where('user_id', '=', $credit_ind_user->user_id)->first();
		// 	$indicator_user->credit += $credit_ind_user->value;
		// 	$indicator_user->save();

		// 	$credit_ind_user->delete();
		// }
	}

	// public function getVoid($id, $braspag_order_id, $comment){
	// 	$order = Order::find($id);
	// 	if($order->braspag_order_id != $braspag_order_id){
	// 		$error = 'Erro #1';
	// 		return Redirect::back()
	// 			->withErrors($error);
	// 	}

	// 	//////////////////////////////////////
	// 	// require_once(app_path().'/braspag/nusoap.php');
	//  	// require_once(app_path().'/braspag/vars.php');
	// 	//////////////////////////////////////

	//     $url_transacao = 'https://pagador.com.br/webservice/pagadorTransaction.asmx?WSDL';

	//     $client = new nusoap_client($url_transacao, 'wsdl', '', '', '', '');

	//     $err = $client->getError();

	//     if ($err) {
	// 		$error = 'Erro #2';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     }

	//     $param = array(
	//       'request' => array(
	//         'MerchantId'   => $MerchantId,
	//         'RequestId'   => getGUID(),
	//         'Version' => '1.0',
	//         'TransactionDataCollection' => array(
	//           'TransactionDataRequest' => array(
	//             'BraspagTransactionId' => '{'.$order->braspag_id.'}',
	//             'Amount' => $order->total,
	//           ),
	//         ),
	//       ),
	//     );

	//     // print("<pre>");
	//     // print_r($param);
	//     // print("</pre>");

	//     $result = $client->call('RefundCreditCardTransaction', array('parameters' => $param), '', '', false, true);

	//     // print("<pre>");
	//     // print_r($result);
	//     // print("</pre>");

	//     if ($client->fault || !$result) {
	// 		$error = 'Erro #3';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     } else {
	//       $err = $client->getError();
	//       if ($err) {
	//         $error = 'Erro #4';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//       } else {
	//         // print("<pre>");
	//         // print_r($result);
	//         // print("</pre>");
	//         if($result['RefundCreditCardTransactionResult']['Success'] == true){
	//         	$new_status = 'cancelado';
	//         	$this->updateOrder($order, $new_status, $comment);
	//         }
	//         else{
	//         	$error = 'Erro #5';
	// 			return Redirect::back()
	// 				->withErrors($error);
	//         }
	//       }
	//     }

	//     return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' estornado com sucesso.');
	// }

	// public function getCancel($id, $braspag_order_id, $comment){
	// 	$order = Order::find($id);
	// 	if($order->braspag_order_id != $braspag_order_id){
	// 		$error = 'Erro #6';
	// 		return Redirect::back()
	// 			->withErrors($error);
	// 	}

	// 	//////////////////////////////////////
	// 	// require_once(app_path().'/braspag/nusoap.php');
	//     // require_once(app_path().'/braspag/vars.php');
	//     //////////////////////////////////////
	//     $url_transacao = 'https://pagador.com.br/webservice/pagadorTransaction.asmx?WSDL';

	//     $client = new nusoap_client($url_transacao, 'wsdl', '', '', '', '');

	//     $err = $client->getError();

	//     if ($err) {
	//       	$error = 'Erro #7';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     }

	//     $param = array(
	//       'request' => array(
	//         'MerchantId'   => $MerchantId,
	//         'RequestId'   => getGUID(),
	//         'Version' => '1.0',
	//         'TransactionDataCollection' => array(
	//           'TransactionDataRequest' => array(
	//             'BraspagTransactionId' => '{'.$order->braspag_id.'}',
	//             'Amount' => $order->total,
	//           ),
	//         ),
	//       ),
	//     );

	//     // print("<pre>");
	//     // print_r($param);
	//     // print("</pre>");

	//     $result = $client->call('VoidCreditCardTransaction', array('parameters' => $param), '', '', false, true);

	//     // print("<pre>");
	//     // print_r($result);
	//     // print("</pre>");

	//     if ($client->fault || !$result) {
	//       	$error = 'Erro #8';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     } else {
	//       $err = $client->getError();
	//       if ($err) {
	//         $error = 'Erro #9';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//       } else {
	//         // print("<pre>");
	//         // print_r($result);
	//         // print("</pre>");
	//         if($result['VoidCreditCardTransactionResult']['Success'] == true){
	//         	$new_status = 'cancelado';
	//         	$this->updateOrder($order, $new_status, $comment);
	//         }
	//         else{
	//         	$error = 'Erro #10';
	// 			return Redirect::back()
	// 				->withErrors($error);
	//         }
	//       }
	//     }

	//     return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' cancelado com sucesso.');
	// }

	public function getCancel($id, $braspag_order_id, $comment){
		$order = Order::find($id);
		if($order->braspag_order_id != $braspag_order_id){
			$error = 'Erro #26';
			return Redirect::back()
				->withErrors($error);
		}

		$new_status = 'cancelado';

		$this->updateOrder($order, $new_status, $comment);

		return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' via boleto cancelado com sucesso. IMPORTANTE: ainda é necessário reembolsar o cliente.');
	}

	// public function getReject($id, $braspag_order_id, $comment){
	// 	$order = Order::find($id);
	// 	if($order->braspag_order_id != $braspag_order_id){
	// 		$error = 'Erro #11';
	// 		return Redirect::back()
	// 			->withErrors($error);
	// 	}

	// 	//////////////////////////////////////
	// 	// require_once(app_path().'/braspag/nusoap.php');
	//     // require_once(app_path().'/braspag/vars.php');
	//     //////////////////////////////////////

	//     $url_antifraud = 'https://antifraude.braspag.com.br/AntiFraudeWS/AntiFraud.asmx?WSDL';

	//     $client = new nusoap_client($url_antifraud, 'wsdl', '', '', '', '');

	//     $err = $client->getError();

	//     if ($err) {
	//       	$error = 'Erro #12';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     }

	//     $param = array(
	//       'updateStatusRequest' => array(
	//         'MerchantId'   => $MerchantId,
	//         'RequestId'   => getGUID(),
	//         'Version'   => '1.0',
	//         'AntiFraudTransactionId' => '{'.$order->antifraud_id.'}',
	//         'NewStatus' => 'REJECT',
	//         'Comment' => $comment,
	//       ),
	//     );

	//     // print("<pre>");
	//     // print_r($param);
	//     // print("</pre>");

	//     $result = $client->call('UpdateStatus', array('parameters' => $param), '', '', false, true);

	//     // print("<pre>");
	//     // print_r($result);
	//     // print("</pre>");

	//     if ($client->fault || !$result) {
	//       	$error = 'Erro #13';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//     } else {
	//       $err = $client->getError();
	//       if ($err) {
	//         $error = 'Erro #14';
	// 		return Redirect::back()
	// 			->withErrors($error);
	//       } else {
	//         // print("<pre>");
	//         // print_r($result);
	//         // print("</pre>");

	//         if($result['UpdateStatusResult']['Success'] == true){
	//         	$new_status = 'cancelado';
	//         	$this->updateOrder($order, $new_status, $comment);
	//         	$this->sendTransactionalEmail($order, $new_status);
	//         }
	//         else{
	//         	$error = 'Erro #15';
	// 			return Redirect::back()
	// 				->withErrors($error);
	//         }
	//       }
	//     }

	//     return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' rejeitado com sucesso.');
	// }

	public function getApprove($id, $braspag_order_id, $comment){
		$order = Order::where('id', $id)->first();
		if($order->braspag_order_id != $braspag_order_id){
			$error = 'Erro #16';
			return Redirect::back()
				->withErrors($error);
		}

		//////////////////////////////////////
		require_once(app_path().'/braspag/nusoap.php');
	    require_once(app_path().'/braspag/vars.php');
	    //////////////////////////////////////

	    $url_antifraud = 'https://antifraude.braspag.com.br/AntiFraudeWS/AntiFraud.asmx?WSDL';

	    $client = new nusoap_client($url_antifraud, 'wsdl', '', '', '', '');

	    $err = $client->getError();

	    if ($err) {
	      	$error = 'Erro #17';
			return Redirect::back()
				->withErrors($error);
	    }

	    $param = array(
	      'updateStatusRequest' => array(
	        'MerchantId'   => $MerchantId,
	        'RequestId'   => getGUID(),
	        'Version'   => '1.0',
	        'AntiFraudTransactionId' => '{'.$order->antifraud_id.'}',
	        'NewStatus' => 'ACCEPT',
	        'Comment' => $comment,
	      ),
	    );

	    // print("<pre>");
	    // print_r($param);
	    // print("</pre>");

	    // echo "<br/><br/>";
	    // $array = (array) $param;
	    // $json = json_encode($array);
	    // print_r($json);

	    $result = $client->call('UpdateStatus', array('parameters' => $param), '', '', false, true);

	    // echo "<br/><br/>";
	    // print("<pre>");
	    // print_r($result);
	    // print("</pre>");

	    // echo "<br/><br/>";
	    // $array = (array) $result;
	    // $json = json_encode($array);
	    // print_r($json);

	    if ($client->fault || !$result) {
	      	$error = 'Erro #18';
			return Redirect::back()
				->withErrors($error);
	    } else {
	      $err = $client->getError();
	      if ($err) {
	        $error = 'Erro #19';
			return Redirect::back()
				->withErrors($error);
	      } else {
	        // print("<pre>");
	        // print_r($result);
	        // print("</pre>");
	        if($result['UpdateStatusResult']['Success'] != true){
	        	$error = 'Erro #20';
				return Redirect::back()
					->withErrors($error);
	        }
	      }
	    }


	    ///////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////
	    //// CAPTURA - PAGADOR
	    ///////////////////////////////////////////////////////////////////////////////////
	    ///////////////////////////////////////////////////////////////////////////////////

	    $url_transacao = 'https://pagador.com.br/webservice/pagadorTransaction.asmx?WSDL';

	    $client_pagador = new nusoap_client($url_transacao, 'wsdl', '', '', '', '');

	    $err = $client_pagador->getError();

	    if ($err) {
	      	$error = 'Erro #21';
			return Redirect::back()
				->withErrors($error);
	    }

	    $param = array(
	      'request' => array(
	        'MerchantId'   => $MerchantId,
	        'RequestId'   => getGUID(),
	        'Version' => '1.0',
	        'TransactionDataCollection' => array(
	          'TransactionDataRequest' => array(
	            'BraspagTransactionId' => $braspag_id,
	            'Amount' => str_replace('.','',($valor_total*100)),
	          ),
	        ),
	      ),
	    );

	    // print("<pre>");
	    // print_r($param);
	    // print("</pre>");

	    // echo "<br/><br/>";
	    // $array = (array) $param;
	    // $json = json_encode($array);
	    // print_r($json);

	    unset($result);
	    $result = $client_pagador->call('CaptureCreditCardTransaction', array('parameters' => $param), '', '', false, true);

	    // print("<pre>");
	    // print_r($result);
	    // print("</pre>");

	    // echo "<br/><br/>";
	    // $array = (array) $result;
	    // $json = json_encode($array);
	    // print_r($json);

	    // exit();

	    if ($client_pagador->fault || !$result) {
	    	$error = 'Erro #22';
			return Redirect::back()
				->withErrors($error);
	    } else {
	      $err = $client_pagador->getError();
	      if ($err) {
	        $error = 'Erro #23';
			return Redirect::back()
				->withErrors($error);
	      } else {
	        // print("<pre>");
	        // print_r($result);
	        // print("</pre>");
	        if($result['CaptureCreditCardTransactionResult']['Success'] == true){
	        	$new_status = 'pago';
	        	$this->updateOrder($order, $new_status, $comment);
	        	$this->sendTransactionalEmail($order, $new_status);
	        }
	        else{
	        	$error = 'Erro #24';
				return Redirect::back()
							   ->withErrors($error);
	        }
	      }
	    }

	    return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' aprovado com sucesso.');
	}

	public function getConvertValue2Credit($id, $braspag_order_id, $comment){
		$order = Order::find($id);
		if($order->braspag_order_id != $braspag_order_id){
			$error = 'Erro #25';
			return Redirect::back()
				->withErrors($error);
		}

		$new_status = 'convercao_creditos';
		$total = $order->total;

		$this->updateOrder($order, $new_status, $comment);

		// PS: o crédito é passado ao cliente pelo Trigger, por isso comentei a linha abaixo
		// $profile = Profile::where('user_id', '=', $order->user_id)->first();
		// $profile->credit += $total;
		// $profile->save();

		return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' convertido em créditos ao usuário com sucesso.');
	}

	// public function getCancelBoletus($id, $braspag_order_id, $comment){
	// 	$order = Order::find($id);
	// 	if($order->braspag_order_id != $braspag_order_id){
	// 		$error = 'Erro #26';
	// 		return Redirect::back()
	// 			->withErrors($error);
	// 	}

	// 	$new_status = 'cancelado';

	// 	$this->updateOrder($order, $new_status, $comment);

	// 	return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' via boleto cancelado com sucesso. Ainda é necessário reembolsar o cliente.');
	// }

	// public function getCancelPaidByCredit($id, $braspag_order_id, $comment){
	// 	$order = Order::find($id);
	// 	if($order->braspag_order_id != $braspag_order_id){
	// 		$error = 'Erro #26';
	// 		return Redirect::back()
	// 			->withErrors($error);
	// 	}

	// 	$new_status = 'cancelado';

	// 	$this->updateOrder($order, $new_status, $comment);

	// 	return Redirect::back()->with('success', 'Pagamento '.$order->braspag_order_id.' via boleto cancelado com sucesso. Ainda é necessário reembolsar o cliente.');
	// }

	public function teste(){
		$offers_options = OfferOption::with(['offer', 'used_vouchers'])
									->get(['id', 'offer_id', 'price_with_discount', 'title', 'subtitle', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'price_with_discount', 'min_qty', 'max_qty'])
									->toArray();
		
		print('<pre>');
		print_r($offers_options);
		print('</pre>'); die();
	}

	public function doOrder(){
		
	}

}
