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

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '10';

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


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

		$orderArray = $orderData->with(['user', 'offer'])
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
					                if (Input::has('name')) {
										$query->select(DB::raw(1))
						                      ->from('profiles')
											  ->whereRaw('profiles.user_id = orders.user_id')
											  ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('name').'%"');
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

		foreach ($orderArray as $key => &$value) {
			if(isset($value['offer'])){
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
								->whereExists(function($query) use($name){
					                if ($name) {
										$query->select(DB::raw(1))
						                      ->from('profiles')
											  ->whereRaw('profiles.user_id = orders.user_id')
											  ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.$name.'%"');
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
												},
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

		$offers = Offer::with(['offer_option'])->get();

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

		$vouchers = $vouchers->with(['offer_option_offer'])
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
						'user',
						'offer_option_offer',
						'discount_coupon',
					  ])
					  ->where('id', $id)
					  ->first();
		// print('<pre>');
		// print_r($order);
		// print('</pre>'); die();

		$transaction = Transaction::where('order_id', $id)->get();

		$this->layout->content = View::make('admin.order.view', compact('order', 'transaction'));
	}

	public function getVoucherCancel(){
		$voucher = Voucher::where('id', Input::get('id'))->first();
		if($voucher->status == 'pago'){
			$voucher->status = (Input::get('convert_credits') == 0)?'cancelado_parcial':'convercao_creditos_parcial';
			$voucher->save();

			$order = $this->order->where('id', Input::get('order_id'))->first();
			$order->history .= "<br/>" . date('d/m/Y H:i:s') . " - Cancelamento parcial de cupom (" . Input::get('comment') . " por " . Auth::user()->email . ")";
			$order->save();

			return Redirect::back()->with('success', 'Voucher '.$voucher->id.'-'.$voucher->display_code.' cancelado com sucesso.');
		}

		return Redirect::back()->with('error', 'Voucher '.$voucher->id.'-'.$voucher->display_code.' não pôde ser cancelado pois já estava cancelado.');
	}

	private function sendTransactionalEmail($order, $new_status){
		$ids = array();
		$qties = array();
		$products_email = '';

		$vouchers = Voucher::with(['offer_option'])->get();

		foreach ($vouchers as $voucher) {
			$products_email .= '<a href="' . route('oferta', $voucher->offer_option->slug) . '">' . $voucher->offer_option->offer_title . ' | ' . $voucher->offer_option->title . '</a><br/>';
		}

		// Removendo o último </br>
		$products_email = substr($products_email, 0, -5);

		$user = User::find($order->user_id)->with('profile');

        $data = array('name' => $user->profile->first_name, 'products' => $products_email);

        if($new_status == 'pago'){
        	Mail::send('emails.order.order_approved', $data, function($message){
				$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra aprovada');
			});
        }
        else{ // $new_status = 'cancelado'
        	Mail::send('emails.order.order_rejected', $data, function($message){
				$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Pagamento não aprovado');
			});
        }

	}

	private function updateOrder($order, $new_status, $comment){
		$old_status = $order->status;
		$order->status = $new_status;
		$order->history .= "<br/>" . date('d/m/Y H:i:s') . " - Status alterado para " . $new_status . " (" . $comment . " por " . Auth::user()->email . ")";
		$order->save();

		Voucher::where('order_id', $order->id)->where('status', $old_status)->update(['status' => $new_status]);

		// inserir creditos por indicação
		$credit_ind_user = UserCredit::where('new_user_id', '=', $order->user_id)->first();

		if($credit_ind_user){
			$indicator_user = Profile::where('user_id', '=', $credit_ind_user->user_id)->first();
			$indicator_user->credit += $credit_ind_user->value;
			$indicator_user->save();

			$credit_ind_user->delete();
		}
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

	public function postBraspagReturn(){
		$server_addr = array(
		  '10.144.84.94',
		  '209.134.48.121',
		  '209.235.236.174',
		  '209.134.53.179',
		  '209.235.236.162',
		  '209.134.48.120',
		  '209.235.236.164',
		  '209.134.48.122',
		  '209.134.48.211',
		  '209.134.48.69',
		  '209.134.53.185',
		  '209.235.206.3',
		  '209.134.53.180',
		  '209.134.48.123',
		  '209.235.236.161',
		);

		if (
		  empty($_SERVER['HTTP_X_FORWARDED_FOR']) ||
		  !in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $server_addr) ||
		  // empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		  // !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
		  !isset($_POST) ||
		  empty($_POST)
		) {
		  return Response::make('<status>Acesso Negado</status>', 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$braspag_order_id = $_POST['NumPedido'];
		// $codpagamento = $_POST['CODPAGAMENTO'];

		$status = ($_POST['Status'] == '0')?'pago':'cancelado';

		$order = $this->order->where('braspag_order_id', $braspag_order_id)->get();

		$user_id = $order->user_id;
		$order_id = $order->id;

		$order->historico .= '<br/>'.date('d/m/Y H:i:s')." - Status alterado para ".$status.", atualizado pelo retorno da Braspag";
		$order->status = $status;
		$order->save();

		Voucher::where('order_id', $order_id)->update(array('status' => $status));

		$this->sendTransactionalEmail($order, $status);

		return Response::make('<status>OK</status>', 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
	}

	private function validateDiscountCoupon($display_code, $offers_options_ids){
		$offers = OfferOption::whereIn('id', $offers_options_ids)->get(['offer_id']);
		$offer_ids = [];
		
		foreach ($offers as $o) {
			$offer_ids[] = $o->offer_id;
		}

		$discount_coupon = DiscountCoupon::where('display_code', '=', $display_code)
										  ->where( function ( $query ) use ( $offer_ids )
												   {
												        $query->whereIn('offer_id', $offer_ids)
												            ->orWhereNull('offer_id');
												   })
										  ->where( function ( $query )
												   {
												        $query->where('user_id', '=', Auth::user()->id)
												            ->orWhereNull('user_id');
												   })
										  ->where('starts_on', '<=', date('Y-m-d H:i:s'))
										  ->where('ends_on', '>=', date('Y-m-d H:i:s'))
										  ->get(['id', 'value', 'qty_used', 'qty'])
										  ->first()
											;
		if(isset($discount_coupon) && $discount_coupon->qty_used < $discount_coupon->qty){
			return $discount_coupon;
		}
		else{
			return NULL;
		}
	}

	public function teste(){
		$offers_options = OfferOption::with(['offer', 'used_vouchers'])
									->get(['id', 'offer_id', 'price_with_discount', 'title', 'subtitle', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'price_with_discount', 'min_qty', 'max_qty', 'max_qty_per_buyer'])
									->toArray();
		
		print('<pre>');
		print_r($offers_options);
		print('</pre>'); die();
	}

	public function doOrder(){
		// INPUTs:

		// payment_type: credit_card or boletus
		// flag: visa, master, etc
		// number, month, year, cod, name, cpf_cnpj, telephone, installment
		// reference_code
		// donation
		// offer_option_qty[id]
		// discount_coupon_code

		//get all user input
		$inputs = Input::all();

		$rules = [
			'payment_type' => 'required',
        	'reference_code' => 'required',
        	'donation' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

	    // validate user input
		if ($validation->passes()){
			// as vezes houve uma tentativa de compra com o braspag order id que teve erros, 
			// mas o usuario permanece na mesma página (com o mesmo braspag order id), tal compra
			// deve ser deletada, para uma nova (sem erros) ser criada em seguida
			Order::where('braspag_order_id', $braspag_order_id)->delete();

			//organize some of the user inputs
			$user_id = Auth::user()->id;
			$braspag_order_id = $inputs['reference_code'];
			$donation = $inputs['donation'];
			$discount_coupon_code = $inputs['discount_coupon_code'];
			$total = 0;
			$qty_total = 0;
			$history = date('d/m/Y h:i:s').' - Transação iniciada.';
			$status = 'pendente';

			$order = New Order;

			$order->user_id = $user_id;
			$order->braspag_order_id = $braspag_order_id;
			$order->donation = $donation;
			$order->history = $history;

			$order->save();

			$order_id = $order->id;

			$ids = array();
			$qties = array();
			$products = array();
			$vouchers = array();

			// get id and quantity of product user just ordered
			foreach ($inputs['offer_option_qty'] as $id => $qty) {
				$ids[] = $id;
				$qties[] = $qty;
			}

			$offers_options = OfferOption::whereIn('id', $ids)->with(['offer', 'qty_sold'])->get(['id', 'offer_id', 'price_with_discount', 'title', 'subtitle', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'price_with_discount', 'min_qty', 'max_qty', 'max_qty_per_buyer']);

			// save the items the user ordered and calculate total
			foreach ($offers_options as $offer_option) {
				$qty_ordered = array_shift($qties); // pega o primeiro elemento de $qties e joga no final do próprio array $qties, além de obter o valor manipulado em si, claro
				$qty_sold = isset($offer_option->qty_sold{0})?$offer_option->qty_sold{0}->qty:0;
				$max_qty_allowed = min($offer_option->max_qty_per_buyer, ($offer_option->max_qty - $offer_option->min_qty - $qty_sold));

				if($qty_ordered > $max_qty_allowed){
					// ERRO: a quantidade comprada é maior que a quantidade permitida ou maior que a quantidade em estoque
					$error = 'A quantidade selecionada para a oferta ' . $offer_option->offer->title . ' é maior do que a quantidade em estoque.';

					return Redirect::back()
								   ->withInput()
								   ->withErrors($error);
				}
				else{
					$products[] = '<a href="' . route('oferta', $offer_option->offer->slug) . '">' . $qty_ordered . ' x ' . $offer_option->offer->title . ' | ' . $offer_option->title . '</a>';

					// save each ordered item now to create vouchers later (case the order go successfully)
					for ($i = 0; $i < $qty_ordered; $i++) {
						$voucher['offer_option_id'] = $offer_option->id;
						$voucher['order_id'] = $order_id;
						$voucher['display_code'] = $braspag_order_id . $offer_option->offer_id;
						$vouchers[] = $voucher;
					}

					// sum the total
					$total += ($qty_ordered * $offer_option->price_with_discount);
					$qty_total += $qty_ordered;
				}
			}

			$discount_coupon_value = 0;

			// if user have entered a discount coupon code
			if($discount_coupon_code){
				$discount = $this->validateDiscountCoupon($ids, $discount_coupon_code);
				if($discount){
					$discount_coupon_id = $discount['id'];
					$discount_coupon_value = $discount['value'];
				}
			}

			// subtrate discounts and user credit from the total, calculating the total left
			if($discount_coupon_value < $total){
				$user_profile = Profile::where('user_id', $user_id)->get('credit');
				$user_credit = $user_profile->credit;

				$total_left = $total - $discount_coupon_value;

				$total_left = ($total_left > $user_credit) ? $total_left - $user_credit : 0 ;
			}
			// if the discount coupon value cover the product price
			else{
				$total_left = 0;
			}

			//*********************//
			//*********************//
			// paying for the order//
			//*********************//
			//*********************//

			////////////////////////////////////////////////////////////////////////////
			// paying via user credits and/or discount coupon
			////////////////////////////////////////////////////////////////////////////
			if($total_left <= 0){
				$order->status = 'pago';
				$order->coupon_id = $discount_coupon_id;
				$order->total = 0.00;
				$order->credit_discount = $total - $discount_coupon_value;
				$order->payment_terms = 'Créditos e/ou cupom de disconto';
				$order->history .= '<br/>'.date('d/m/Y h:i:s').' - Pagamento feito completamente com créditos do usuário e/ou cupom de disconto';

				$order->save();
			}

			////////////////////////////////////////////////////////////////////////////
			// paying via credti card
			////////////////////////////////////////////////////////////////////////////
			else if($inputs['payment_type'] == 'credit_card'){
				$inputs['cpf_cnpj'] = preg_replace('/[^0-9]/', '', $inputs['cpf_cnpj']);
				$inputs['telephone'] = preg_replace('/[^0-9]/', '', $inputs['telephone']);
				$inputs['number'] = preg_replace('/\D/', '', $inputs['number']);

				$rules = [
					'cpf_cnpj' => 'required|digitsbetween:10,22',
        			'telephone' => 'required|digitsbetween:10,20',
					'flag' => 'required',
		        	'number' => 'required|digits:16',
		        	'month' => 'required|digits:2',
		        	'year' => 'required|digits:4',
		        	'cod' => 'required|digitsbetween:3,4',
		        	'name' => 'required',
		        	'installment' => 'required',
				];

			    $validation = Validator::make($inputs, $rules);

			    if (!$validation->passes()){
			    	return Redirect::back()
									->withInput()
									->withErrors($validation);
			    }

			    $profile_info = Profile::where('user_id', $user_id)->get('first_name', 'last_name', 'state', 'telephone')->first();

				$first_name = $profile->first_name;
				$last_name = $profile->last_name;
				$state = $profile->state;
				$email = Auth::user()->email;
				$passenger_telephone = $profile->telephone;
				$flag = $inputs['flag'];
				$number = $inputs['number'];
				$month = $inputs['month'];
				$year = $inputs['year'];
				$cod = $inputs['cod'];
				$cpf_cnpj = $inputs['cpf_cnpj'];
				$telephone = $inputs['telephone'];
				list($holder_fname, $holder_surname) = explode(" ", $inputs['name'], 2);
				$installment = $inputs['installment'];

				if($installment == 1){
					$interest_rate = 0;
					$card_boletus_rate = Configuration::get('card-tax-1x');
					$antecipation_rate = Configuration::get('antecipation-tax-1x');
				}
				else if($installment == 3){
					$interest_rate = Configuration::get('interest-rate-3x');
					$card_boletus_rate = Configuration::get('card-tax-3x');
					$antecipation_rate = Configuration::get('antecipation-tax-3x');
					$total_left = $total_left + ($total_left * $interest_rate);
				}
				else if($installment == 6){
					$interest_rate = Configuration::get('interest-rate-6x');
					$card_boletus_rate = Configuration::get('card-tax-6x');
					$antecipation_rate = Configuration::get('antecipation-tax-6x');
					$total_left = $total_left + ($total_left * $interest_rate);
				}
				else if($installment == 10){
					$interest_rate = Configuration::get('interest-rate-10x');
					$card_boletus_rate = Configuration::get('card-tax-10x');
					$antecipation_rate = Configuration::get('antecipation-tax-10x');
					$total_left = $total_left + ($total_left * $interest_rate);
				}
				else{
					$error = 'Número de parcelas inválido.';
					return Redirect::back()
								   ->withInput()
								   ->withErrors($error);
				}

				$order->total = $total_left;
				$order->credit_discount = $total - $total_left - $discount_coupon_value;
				$order->interest_rate = $interest_rate;
				$order->card_boletus_rate = $card_boletus_rate;
				$order->antecipation_rate = $antecipation_rate;
				$order->holder_card = $inputs['name'];
				$order->first_digits_card = substr($number, 0, 4);
				$order->cpf = $cpf_cnpj;
				$order->telephone = $telephone;
				$order->payment_terms = 'Cartão de crédito - ' . $flag . ' - ' . $installment . 'x';

				$order->save();

				/////////////////////////////////////
				/////////////////////////////////////
				require_once app_path().'/braspag/vars.php';
				/////////////////////////////////////
				/////////////////////////////////////

				// if(validateInstallment($installment, $total, $donation) == false){
				// 	$error = 'Número de parcelas inválido.';
				// 	return Redirect::back()
				// 				   ->withInput()
				// 				   ->withErrors($error);
				// }

				/////////////////////////////////////////////
				/////////////////////////////////////////////
		        require_once app_path().'/braspag/antifraud.php';
		        /////////////////////////////////////////////
		        /////////////////////////////////////////////

	            $SoapClient = new AntiFraud($url_antifraud);
	            $antifraude = new FraudAnalysis();
	            $request = new FraudAnalysisRequest();
	            $document = new AntiFraudDocumentData();
	            $request->AntiFraudRequest = new AntiFraudRequest();
	            $request->AntiFraudRequest->CardData = new CardData();
	            $MerchantDefinedData = new MerchantDefinedData();
	            $PurchaseTotalsData = new PurchaseTotalsData();
	            $billToData = new BillToData();
	            $itemData = new ItemData();
	            $itemData->ProductData = new ProductData();
	            $itemData->PassengerData = new PassengerData();

	            $request->MerchantId = $MerchantIdAF;

	            if(strlen($cpf_cnpj) == 11) $document->Cpf = $cpf_cnpj;
	            else $document->Cnpj = $cpf_cnpj;

	            $request->DocumentData = $document;

	            $request->RequestId = getGUID_semchave();
	            $request->AccessKey = getGUID_semchave();
	            $request->AntiFraudSequenceType = "AnalyseOnly";

	            $request->AntiFraudRequest->MerchantReferenceCode = $braspag_order_id;

	            $request->AntiFraudRequest->CardData->AccountNumber = $number;
	            $request->AntiFraudRequest->CardData->Bin = '';
	            $request->AntiFraudRequest->CardData->Card = $flag;
	            $request->AntiFraudRequest->CardData->ExpirationMonth = $month;
	            $request->AntiFraudRequest->CardData->ExpirationYear = $year;

	            $MerchantDefinedData->Field1 = $offers_options{0}->offer_id;
	            $MerchantDefinedData->Field2 = $offers_options{0}->id;
	            $MerchantDefinedData->Field3 = $offers_options{0}->voucher_validity_start;
	            $MerchantDefinedData->Field4 = $offers_options{0}->voucher_validity_end;
	            $MerchantDefinedData->Field5 = $offers_options{0}->price_with_discount;
	            $MerchantDefinedData->Field6 = $offers_options{0}->title;
	            $MerchantDefinedData->Field7 = $offers_options{0}->subtitle;
	            $MerchantDefinedData->Field8 = $offers_options{0}->percent_off;

	            $request->AntiFraudRequest->MerchantDefinedData = $MerchantDefinedData;

	            $PurchaseTotalsData->Currency = 'BRL';
	            $PurchaseTotalsData->GrandTotalAmount = $total_left;

	            $request->AntiFraudRequest->PurchaseTotalsData = $PurchaseTotalsData;

	            // Instancia o objeto que conter? os dados de cobran?a do cliente.
	            $billToData->City = "Mountain View";
	            $billToData->Country = "US";
	            $billToData->Email = 'null@cybersource.com';
	            $billToData->PhoneNumber = $telephone;
	            $billToData->FirstName = $holder_fname;
	            $billToData->LastName = $holder_surname;
	            $billToData->State = "CA";
	            $billToData->Street1 = "1295 Charleston Road";
	            $billToData->PostalCode = "94043";
	            // $billToData->HttpBrowserCookiesAccepted = false;
	            $billToData->IpAddress = get_real_ip();
	            $request->AntiFraudRequest->BillToData = $billToData;

	            $itemData->GiftCategory = "Off";
	            $itemData->HostHedge = "Low";
	            $itemData->NonSensicalHedge = "Off";
	            $itemData->ObscenitiesHedge = "Off";
	            $itemData->PhoneHedge = "Low";
	            $itemData->TimeHedge = "Off";
	            $itemData->VelocityHedge = "Off";
	            $itemData->PassengerData->FirstName = $first_name;
	            $itemData->PassengerData->LastName = $last_name;
	            $itemData->PassengerData->PassengerId = $user_id;
	            $itemData->PassengerData->Passenger = "Adult";
	            $itemData->PassengerData->Email = $email;
	            $itemData->PassengerData->Phone = $passenger_telephone;
	            $itemData->ProductData->Code = "Default";
	            $itemData->ProductData->Name = $offers_options{0}->title;
	            $itemData->ProductData->Risk = "Low";
	            $itemData->ProductData->Sku = $braspag_order_id;
	            $itemData->ProductData->Quantity = $qty_ordered;
	            $itemData->ProductData->UnitPrice = number_format($offers_options{0}->price_with_discount, 0, '', '');
	            $itemDataCollection = array($itemData);

	            $request->AntiFraudRequest->ItemDataCollection->ItemData = $itemData;

	            $antifraude->request = $request;

	            $AntiFraudResponse = $SoapClient->FraudAnalysis($antifraude);

	            $pagador = 'n';
	            $status = antifraud_status_code_2_string($AntiFraudResponse->FraudAnalysisResult->TransactionStatusCode);

	            switch ($AntiFraudResponse->FraudAnalysisResult->AntiFraudResponse->ReasonCode) {
	              case '100':
	              case '231':
	                // $return = 'Operação bem sucedida.';
	                $returnBD = 'Operação bem sucedida.';
	                $pagador = 'y';
	                // vai pro pagadaor com auto-captura
	                $pagadorTransactionType = 2; //BraspagCreditCardModel::TRANSACTION_TYPE_AUTOCAPTURE;
	                break;
	              case '480':
	                // $return = 'O pedido foi marcado para revisão pelo Gerenciador de Decisão.';
	                $returnBD = 'O pedido foi marcado para revisão pelo Gerenciador de Decisão.';
	                $pagador = 'y';
	                // vai pro pagador apenas para autorizar a transacao (como foi para revisão, não podemos captura-la)
	                // observação: por que prossegue para o pagador? porque o pagador grava todos os dados da compra, só esperando uma confirmação nossa (aprova ou rejeita)
	                $pagadorTransactionType = 1; //BraspagCreditCardModel::TRANSACTION_TYPE_AUTHORIZE;
	                break;
	              case '400':
	                // $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito (CÓD: 045).';
	                $returnBD = 'A pontuação de fraude ultrapassa o seu limite.';
	                $pagador = 'y';
	                // vai pro pagador apenas para autorizar a transacao (como foi para revisão, não podemos captura-la)
	                // observação: por que prossegue para o pagador? porque o pagador grava todos os dados da compra, só esperando uma confirmação nossa (aprova ou rejeita)
	                $pagadorTransactionType = 1; //BraspagCreditCardModel::TRANSACTION_TYPE_AUTHORIZE;
	                break;
	              case '101':
	                $return = 'Por favor, preencha todos os campos corretamente.';
	                $returnBD = 'O pedido está faltando um ou mais campos necessários.';
	                break;
	              case '102':
	                $return = 'Por favor, preencha todos os campos corretamente.';
	                $returnBD = 'Um ou mais campos do pedido contêm dados inválidos.';
	                break;
	              case '150':
	                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 009). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
	                $returnBD = 'Falha no sistema geral.';
	                break;
	              case '151':
	                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 010). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
	                $returnBD = 'O pedido foi recebido, mas ocorreu time-out no servidor. Este erro não inclui time-out entre o cliente e o servidor.';
	                break;
	              case '152':
	                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 011). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
	                $returnBD = 'O pedido foi recebido, mas ocorreu time-out.';
	                break;
	              case '202':
	                $return = 'Cartão expirado ou data de validade incorreta.';
	                $returnBD = 'CyberSource recusou o pedido porque o cartão expirou. Você também pode receber este código se a data de validade não coincidir com a data em arquivo do banco emissor.';
	                break;
	              case '231':
	                $return = 'Número da conta inválido.';
	                $returnBD = 'O número da conta é inválido.';
	                break;
	              case '234':
	                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 012). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
	                $returnBD = 'Há um problema com a configuração do comerciante na CyberSource.';
	                break;
	              case '481':
	                $pagador = 'y';
	                $pagadorTransactionType = 1; //BraspagCreditCardModel::TRANSACTION_TYPE_AUTHORIZE;
	                //$return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito (CÓD: 046).';
	                $returnBD = 'O pedido foi rejeitado pelo Gerenciador de Decisão.';
	                break;
	              case '901':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 047).';;
	                $returnBD = 'Algum parâmetro está indevidamente nulo ou vazio.';
	                break;
	              case '902':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 048).';
	                $returnBD = 'O tamanho de algum parâmetro está inválido.';
	                break;
	              case '903':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 049).';
	                $returnBD = 'O valor de algum parêmtro está inválido.';
	                break;
	              case '904':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 050).';
	                $returnBD = 'Apenas valores numéricos são permitidos.';
	                break;
	              case '905':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 051).';
	                $returnBD = 'Algum parâmetro não estava no formato correto.';
	                break;
	              case '906':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 052).';
	                $returnBD = 'Apenas valores númericos são permitidos e/ou o tamanho de algum parâmetro está inválido.';
	                break;
	              case '907':
	                $return = 'Por favor, preencha todos os campos corretamente (CÓD: 053).';
	                $returnBD = 'Algum parâmetro é inválido.';
	                break;
	              default:
	                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 013). Este erro pode ocorrer devido a um navegador desatualizado ou a uma conexão de internet lenta. Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
	                $returnBD = 'Ocorreu um erro na solicitação.';
	                break;
	            }

	            if ($pagador === 'n') {
					// As vezes ocorreu algum erro, mas o antifraud retornou "aprovado" (ACCEPT). Nesse caso, salva no BD como "abortado".
					$status = ($status === 'pago') ? 'cancelado' : $status;

					$order->status = $status;
					$order->antifraud_id = $AntiFraudResponse->FraudAnalysisResult->AntiFraudTransactionId;
					$order->history .= date('d/m/Y H:i:s') . " - Antifraud: ".$returnBD." (ReasonCode = ".$AntiFraudResponse->FraudAnalysisResult->AntiFraudResponse->ReasonCode.")";

					$order->save();

					return Redirect::back()
								   ->withInput()
								   ->withErrors($return);
	            }
	            else{
					// $order->status = 'pago';
					// $order->status = 'pendente';
					$order->history .= date('d/m/Y H:i:s') . " - Antifraud: ".$returnBD." (".$status.")";

					$order->save();
	            }

	            /////////////////////////////////////////////////
	            /////////////////////////////////////////////////
		        require_once app_path().'/braspag/pagador/Braspag.php';
		        /////////////////////////////////////////////////
		        /////////////////////////////////////////////////

		        $Braspag = new Braspag($ambiente_pagador);

		        ///////////////
		        //Customer
		        ///////////////
		        $Customer = new BraspagCustomerData();
		        $Customer->setName($first_name . ' ' . $last_name);
		        $Customer->setID($user_id);
		        $Customer->setEmail($email);

		        //Customer address (optional)
		        $AddressData = new BraspagAddressData();
		        // $AddressData->Street = 'Blvd. 28 de Setembro';
		        // $AddressData->Number = '389';
		        // $AddressData->Complement = 'Sala 512';
		        // $AddressData->District = 'Vila Isabel';
		        // $AddressData->City = 'Rio de Janeiro';
		        $AddressData->State = $state;
		        // $AddressData->ZipCode = '20551030';
		        $AddressData->Country = 'BR';

		        //Set address data is optional
		        $Customer->setAddressData($AddressData);
		        $Customer->setDeliveryAddressData($AddressData);

		        ///////////////
		        // Credit card
		        ///////////////
		        $CreditCard = new BraspagCreditCardModel();

		        //Capture transaction after authorization
		        $CreditCard->setTransactionType($pagadorTransactionType);

		        //Testing
		        $CreditCard->setMethod(card_type_2_code($card_type));

		        //Order and payment info
		        $CreditCard->setOrderId($braspag_order_id);
		        $CreditCard->setCardNumber($number);
		        $CreditCard->setCardHolder($holder_fname . ' ' . $holder_surname);
		        $CreditCard->setCardExpirationDate($month, $year);
		        $CreditCard->setCardSecurityCode($code);
		        $CreditCard->setCurrency('BRL');
		        $CreditCard->setCountry('BRA');
		        $CreditCard->setAmount(($total_left*100));
		        $CreditCard->setPaymentPlan( (($installment == 1) ? 0 : 1) );
		        $CreditCard->setNumberOfPayments($installment);
		        $CreditCard->setSaveCreditCard(false);

		        //Execute transaction
		        $response = $Braspag->authorizeCreditCardTransaction($CreditCard, $Customer);

		        $braspag_id = $response->PaymentDataCollection->PaymentDataResponse->BraspagTransactionId;

		        $pagador = 'n';

		        if($response->PaymentDataCollection->PaymentDataResponse->Status != 0 && $response->PaymentDataCollection->PaymentDataResponse->Status != 1){
		        // if($response->PaymentDataCollection->PaymentDataResponse->Status != 1){
		            switch ($response->PaymentDataCollection->PaymentDataResponse->ReturnCode) {
		              case '1':
		              case '2':
		                $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Transação negada. Referida.';
		                break;
		              case '3':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 016). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Transação negada. Estabelecimento inválido.';
		                break;
		              case '4':
		              case '5':
		              case '7':
		              case '41':
		              case '43':
		              case '51':
		              case '54':
		              case '55':
		              case '61':
		              case '62':
		              case '63':
		              case '65':
		              case '75':
		              case '82':
		              case '93':
		              case '94':
		                $return = 'Pagamento não autorizado. Por favor, verifique se todos os campos estão preenchidos corretamente. Se o erro persistir, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Transação negada.';
		                break;
		              case '6':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 017). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Problemas ocorridos na transação eletrônica.';
		                break;
		              case '12':
		              case '13':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 018). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Transação inválida.';
		                break;
		              case '14':
		                $return = 'Oops, parece que alguma informação do cartão está digitada errada. Por favor, verifique todas as informações e tente novamente.';
		                $returnBD = 'Cartão inválido.';
		                break;
		              case '15':
		              case '91':
		              case '98':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 019). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Emissor sem comunicação.';
		                break;
		              case '19':
		              case '86':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 020). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Refaça a transação.';
		                break;
		              case '21':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 021). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Transação não localizada.';
		                break;
		              case '22':
		                $return = 'Número de parcelas inválidas.';
		                $returnBD = 'Parcelamento inválido.';
		                break;
		              case '25':
		                $return = 'Número da conta inválido.';
		                $returnBD = 'Número do cartão não foi enviado.';
		                break;
		              case '28':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 022). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Arquivo indisponível.';
		                break;
		              case '52':
		                $return = 'Por favor, preencha todos os campos corretamente.';
		                $returnBD = 'Cartão com dígito de controle inválido.';
		                break;
		              case '53':
		                $return = 'Por favor, preencha todos os campos corretamente.';
		                $returnBD = 'Cartão inválido para essa operação.';
		                break;
		              case '57':
		                $return = 'Pagamento não autorizado. Por favor, verifique se todos os campos estão preenchidos corretamente. Se o erro persistir, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Transação não permitida.';
		                break;
		              case '76':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 023). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Problemas com número de referência da transação.';
		                break;
		              case '77':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 024). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Dados não conferem com mensagem original.';
		                break;
		              case '80':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 025). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Data inválida.';
		                break;
		              case '81':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 026). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Erro de criptografia.';
		                break;
		              case '83':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 027). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Erro no sistema de senhas.';
		                break;
		              case '85':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 044). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Erro métodos de criptografia.';
		                break;
		              case '96':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 028). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Falha no sistema.';
		                break;
		              case '99':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 029). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Emissor sem comunicação. SITEF. Ou divergência cadastral (Ex: liberação de parcelado).';
		                break;
		              case '05':
		              case '51':
		              case '57':
		                $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Mensagem Bancaria.';
		                break;
		              case '08':
		                $return = 'Código de segurança inválido.';
		                $returnBD = 'Cód de Seg Invalido.';
		                break;
		              case '54':
		                $return = 'Cartão expirado.';
		                $returnBD = 'Cartão Vencido.';
		                break;
		              case '78':
		                $return = 'Cartão bloqueado devido ao seu primeiro uso.';
		                $returnBD = 'Cartão Bloqueado 1º USO.';
		                break;
		              case '170':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 030). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Autenticação do Banco Bradesco -Cliente deve digitar agencia, conta e senha do internet Bank.';
		                break;
		              case '99':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 031). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Parcelamento loja não esta liberado.';
		                break;
		              case '96':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 032). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Venda abaixo de  R$ 1,00.';
		                break;
		              case '13':
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 033). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Valor da parcela inferior a R$ 5,00 (parcelado loja).';
		                break;
		              case '57':
		                $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Mensagem Bancaria- Oriente o cliente a entrar em contato com o banco.';
		                break;
		              case '5115':
		              case '5117':
		                $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
		                $returnBD = 'Falha de autenticação - caso não possua a liberaçao de vendas internacionais contate a Visanet se possuir entre em contato com Banco emissor do cartão.';
		                break;
		              default:
		                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 034). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
		                $returnBD = 'Ocorreu um erro na solicitação.';
		                break;
		            }

		            $order->status = $status = 'cancelado';
		            $order->history .= $history = date('d/m/Y H:i:s') . " - Pagador: " . $returnBD . " (ReturnCode = " . $response->PaymentDataCollection->PaymentDataResponse->ReturnCode . " e Status =  " . $response->PaymentDataCollection->PaymentDataResponse->Status . ")";
		            $order->braspag_id = $response->PaymentDataCollection->PaymentDataResponse->BraspagTransactionId;

		            $order->save();

		            // ERRO, NAO APROVADO, ETC...
					return Redirect::back()
								   ->withInput()
								   ->withErrors($return);
		        }
		        else{
		            if($pagadorTransactionType == 1){
		                $order->status = 'revisao';
		                $order->history .= date('d/m/Y H:i:s') . " - Pagador: Transação autorizada, aguardando revisão";
		                $order->braspag_id = $response->PaymentDataCollection->PaymentDataResponse->BraspagTransactionId;

		            	$order->save();
		            }
		            else{
		                $order->status = 'pago';
		                $order->history .= date('d/m/Y H:i:s') . " - Pagador: Transação capturada";

		                $order->save();
		            }
		        }
			}

			////////////////////////////////////////////////////////////////////////////
			// paying via boletus
			////////////////////////////////////////////////////////////////////////////
			else{
				//////////////////////////////////////
				require_once app_path().'/braspag/vars.php';
				//////////////////////////////////////

		        ////////////////////////////////////////
		        require_once app_path().'/braspag/nusoap.php';
		        ////////////////////////////////////////

		        $profile_info = Profile::where('user_id', $user_id)->get('first_name', 'last_name')->first();

				$name = $profile->first_name . ' ' . $profile->last_name;

		        $client = new nusoap_client($url_boleto, 'wsdl', '', '', '', '');
		        $client->soap_defencoding = 'UTF-8';
		        $client->decode_utf8 = false;

		        $err = $client->getError();

		        $param = array(
		          'merchantId'   => $MerchantId,
		          'customerName'   => $name,
		          'orderId'   => $order_id,
		          'amount'   => number_format($total_left, 2, ',', ''),
		          'expirationDate' => date('d/m/y', strtotime('+1 day')),
		          'paymentMethod'   => '06',
		          'instructions' => 'Este boleto pode ser pago até o dia '.date('d/m/y', strtotime('+1 day')).'. Assim que o pagamento for efetuado e aprovado, seu cupom será liberado em sua conta. Obrigado por comprar no INNBatível!',
		          'emails' => Auth::user()->email,
		        );

		        $result = $client->call('CreateBoleto', array('parameters' => $param), '', '', false, true);

		        if ($client->fault) {
		        	$error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 039). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
					return Redirect::back()
								   ->withInput()
								   ->withErrors($error);
		        } else {
		          $err = $client->getError();
		          if ($err) {
		            $error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 040). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
					return Redirect::back()
									->withInput()
								    ->withErrors($error);
		          } else {
		            if($result['CreateBoletoResult']['status'] == NULL){
		                $error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 041). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
						return Redirect::back()
									   ->withInput()
									   ->withErrors($error);
		            }
		          }
		        }

		        $boletus_url = $result['CreateBoletoResult']['url'];

		        $order->total = $total_left;
		        $order->card_boletus_rate = Configuration::get('boletus-value');
		        $order->braspag_id = $result['CreateBoletoResult']['boletoNumber'];
		        $order->boleto = $boletus_url;
		        $order->payment_terms = "Boleto";
		        $order->credit_discount = $total - $total_left - $discount_coupon_value;
		        $order->history .= date('d/m/Y H:i:s') . " - Boleto emitido";

		        $order->save();
			}

			// status final
			$status = $order->status;

			// atualizar quantidade de discount_cupons usados, caso $discount != NULL, ou seja, caso o usuário tenha entrado com um cupom de desconto e ele tenha sido válido
			if($discount){
				$discount->qty_used++;
				$discount->save();
			}

			foreach ($vouchers as $voucher) {
				// criar vouchers (remover o código da criação de vouchers antes de passar pelo antifraud/pagador)
				$voucher['status'] = $status;
				Voucher::create($voucher);
			}

			// atualizar creditos do usuario
			if($user_profile){
				$user_new_credit = ($user_credit - ($total - $discount_coupon_value));
				$user_new_credit = ($user_new_credit > 0) ? $user_new_credit : 0;

				$user_profile->credit = $user_new_credit;
				$user_profile->save();
			}

			// caso a venda tenha sido concretizada
			if($status == 'pago'){

				foreach ($products as $product) {
		        	$products_email .= $product . '<br/>';
		        }

		        $products_email = substr($products_email, 0, -5);

		        $data = array('name' => $profile->first_name, 'products' => $products_email);

		        Mail::send('emails.order.order_approved', $data, function($message){
					$message->to(Auth::user()->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra finalizada com sucesso');
				});

				return Redirect::route('public.success', array('status' => $status));
			}
			else if($status == 'pendente' AND isset($boletus_url)){
				foreach ($products as $product) {
		        	$products_email .= $product . '<br/>';
		        }

		        $products_email = substr($products_email, 0, -5);

		        $data = array('name' => $profile->first_name, 'products' => $products_email, 'boletus_url' => $boletus_url);

		        Mail::send('emails.order.order.order_boletus', $data, function($message){
					$message->to(Auth::user()->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra finalizada com sucesso');
				});

				return Redirect::route('public.success', array('status' => $status, 'boletus_url' => $boletus_url));
			}
			else{
				return Redirect::route('public.success', array('status' => $status));
			}
		}
		else{
			// ERRO: algum dado invalido
			return Redirect::back()
						   ->withInput()
						   ->withErrors($validation);
		}
	}

}
