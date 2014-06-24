<?php

// use SebastianBergmann\Money\Currency;
// use SebastianBerBRLgmann\Money\Money;
// use SebastianBergmann\BRLMoney\IntlFormatter;

class AdminPaymentController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $payment, $payment_partner, $transaction_voucher, $cron_command;

	/**
	 * Construct Instance
	 */
	public function __construct(Payment $payment, PaymentPartner $payment_partner, TransactionVoucher $transaction_voucher)
	{
		/*
		 * Enable Sidebar
		 */

		$this->sidebar = true;

		/*
		 * Enable and Set Actions
		 */

		$this->actions = 'admin.payment';

		/*
		 * Models Instance
		 */

		$this->payment = $payment;
		$this->payment_partner = $payment_partner;
		$this->transaction_voucher = $transaction_voucher;
		$this->cron_command = $cronjob = ' php /var/app/current/artisan fechamento '; // exemplo de uso: 00 00 16 05 * php /Applications/MAMP/htdocs/innbativel/artisan fechamento 1
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
		$payment_partner = $this->payment_partner;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 100);

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

		if (Input::has('id')) {
			$payment_partner = $payment_partner->where('id', Input::get('id'));
		}

		if (Input::has('payment_id') AND Input::get('payment_id') == 'atual') {
			$payment_partner = $payment_partner->where('payment_id', Input::get('payment_id'));
		}

		$paymentPartnerData = $payment_partner->with(['payment', 'partner'])
											  ->whereExists(function($query){
									                if (Input::has('partner_name')) {
														$query->select(DB::raw(1))
										                      ->from('profiles')
															  ->whereRaw('payments_partners.partner_id = profiles.user_id')
															  ->whereRaw('profiles.first_name LIKE \'%'.Input::get('partner_name').'%\'');
													}
										      })
											  ->orderBy($sort, $order)
											  ->paginate($pag)
											  ->appends([
													'sort' => $sort,
													'order' => $order,
													'pag' => $pag,
													'id' => Input::get('id'),
													'partner_name' => Input::get('partner_name'),
													'payment_id' => Input::get('payment_id'),
											  ]);

		$totals = [];
		$totals['transfer'] = 0;

		foreach ($paymentPartnerData as $paymentPartner) {
			$totals['transfer'] += $paymentPartner->total;
		}

		// print('<pre>');
		// print_r($paymentPartnerData->toArray());
		// print('</pre>'); die();

		$ps = Payment::where('sales_to', '<', date('Y-m-d H:i:s'))->orderBy('id', 'asc')->get();
		$paymData = array();

		foreach ($ps as $p) {
			$paymData[$p->id] = date("d/m/Y H:i:s", strtotime($p->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($p->sales_to)).' (dia a pagar: '.date("d/m/Y", strtotime($p->date)).')';
		}

		$this->layout->content = View::make('admin.payment.list', compact('sort', 'order', 'pag', 'paymentPartnerData', 'paymData', 'totals'));
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyVoucher()
	{
		/*
		 * Obj
		 */
		$transaction_voucher = $this->transaction_voucher;

		if (Input::has('payment_id') AND Input::get('payment_id') == 'atual') {
			$transaction_voucher = $transaction_voucher->whereNull('payment_partner_id');
		}

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 100);

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


		$transactionVoucherData = $transaction_voucher->with(['voucher' => function($query){ 
																	$query->with(['offer_option_offer', 'order_customer'])
																		  ->whereExists(function($query){ 
																			if (Input::has('partner_name')) {
																				$query->select(DB::raw(1))
																                      ->from('offers_options')
																                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																                      ->join('profiles', 'profiles.user_id', '=', 'offers.partner_id')
																					  ->whereRaw('offers_options.id = vouchers.offer_option_id')
																					  ->whereRaw('profiles.first_name LIKE \'%'.Input::get('partner_name').'%\'');
																			}
												 					}); 
															  }])
													  ->whereExists(function($query){
											                if (Input::has('partner_name')) {
																$query->select(DB::raw(1))
												                      ->from('vouchers')
												                      ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
												                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
												                      ->join('profiles', 'profiles.user_id', '=', 'offers.partner_id')
																	  ->whereRaw('vouchers.id = transactions_vouchers.voucher_id')
																	  ->whereRaw('profiles.first_name LIKE \'%'.Input::get('partner_name').'%\'');
															}
										              })
										              ->whereExists(function($query){
											                if (Input::has('payment_id')) {
											                	if (Input::get('payment_id') != 'atual') {
																	$query->select(DB::raw(1))
													                      ->from('payments_partners')
																		  ->whereRaw('payments_partners.id = transactions_vouchers.payment_partner_id')
																		  ->whereRaw('payments_partners.payment_id = '.Input::get('payment_id'));
																}
															}
										              })
										              ->whereRaw('transactions_vouchers.voucher_id NOT IN (
													  				SELECT tv1.voucher_id 
													  				FROM transactions_vouchers tv1 
													  				WHERE tv1.status = \'cancelamento\' 
													  				AND tv1.voucher_id IN ( 
													  					SELECT tv2.voucher_id 
													  					FROM transactions_vouchers tv2 
													  					WHERE tv2.status = \'pagamento\' AND 
													  						(tv2.payment_partner_id = tv1.payment_partner_id OR 
													  						(tv2.payment_partner_id IS NULL AND tv1.payment_partner_id IS NULL))
													  				)
													  )')
													  ->orderBy($sort, $order)
													  ->paginate($pag)
													  ->appends([
															'sort' => $sort,
															'order' => $order,
															'pag' => $pag,
															'partner_name' => Input::get('partner_name'),
															'payment_id' => Input::get('payment_id'),
													  ]);
													  // ->get()->toArray(); print('<pre>'); print_r($transactionVoucherData); print('</pre>'); die();

		$totals = [];
		$totals['transfer'] = 0;
		$totals['voucher_price'] = 0;

		foreach ($transactionVoucherData as $transactionVoucher) {
			$totals['transfer'] += ($transactionVoucher->voucher->offer_option_offer->transfer * ($transactionVoucher->status == 'pagamento'?1:-1));
			$totals['voucher_price'] += ($transactionVoucher->voucher->offer_option_offer->price_with_discount * ($transactionVoucher->status == 'pagamento'?1:-1));
		}

		// print('<pre>');
		// print_r($total);
		// print('</pre>'); die();

		$ps = Payment::where('sales_to', '<', date('Y-m-d H:i:s'))->orderBy('id', 'asc')->get();
		$paymData = array();

		foreach ($ps as $p) {
			$paymData[$p->id] = date("d/m/Y H:i:s", strtotime($p->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($p->sales_to)).' (dia a pagar: '.date("d/m/Y", strtotime($p->date)).')';
		}

		$paymData['atual'] = 'Atual';

		$this->layout->content = View::make('admin.payment.voucher', compact('sort', 'order', 'pag', 'transactionVoucherData', 'paymData', 'totals'));
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyPeriod()
	{
		/*
		 * Obj
		 */
		$payment = $this->payment;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 100);

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

    	if (Input::has('id')) {
			$payment = $payment->where('id', Input::get('id'));
		}
		
		$paymentData = $payment->orderBy($sort, $order)
							   ->paginate($pag)
							   ->appends([
									'sort' => $sort,
									'order' => $order,
									'pag' => $pag,
									'id' => Input::get('id'),
							   ]);

		// print('<pre>');
		// print_r($paymentData->toArray());
		// print('</pre>'); die();

		$ps = Payment::orderBy('id', 'asc')->get();
		$paymData = array();

		foreach ($ps as $p) {
			$paymData[$p->id] = date("d/m/Y H:i:s", strtotime($p->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($p->sales_to)).' (dia a pagar: '.date("d/m/Y", strtotime($p->date)).')';
		}

		$this->layout->content = View::make('admin.payment.period', compact('sort', 'order', 'pag', 'paymentData', 'paymData'));
	}

	public function getVoucherExport($partner_name, $payment_id){
		$partner_name = ($partner_name == 'null')?null:$partner_name;
		$payment_id = ($payment_id == 'null')?null:$payment_id;

		/*
		 * Obj
		 */
		$transaction_voucher = $this->transaction_voucher;

		if ($payment_id == 'atual') {
			$transaction_voucher = $transaction_voucher->whereNull('payment_partner_id');
		}

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


		$transactionVoucherData = $transaction_voucher->with(['voucher' => function($query) use ($partner_name){ 
																	$query->with(['offer_option_offer', 'order_customer'])
																		  ->whereExists(function($query) use ($partner_name){ 
																			if (isset($partner_name)) {
																				$query->select(DB::raw(1))
																                      ->from('offers_options')
																                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																                      ->join('profiles', 'profiles.user_id', '=', 'offers.partner_id')
																					  ->whereRaw('offers_options.id = vouchers.offer_option_id')
																					  ->whereRaw('profiles.first_name LIKE \'%'.$partner_name.'%\'');
																			}
												 					}); 
															  }])
													  ->whereExists(function($query) use ($partner_name){
											                if (isset($partner_name)) {
																$query->select(DB::raw(1))
												                      ->from('vouchers')
												                      ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
												                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
												                      ->join('profiles', 'profiles.user_id', '=', 'offers.partner_id')
																	  ->whereRaw('vouchers.id = transactions_vouchers.voucher_id')
																	  ->whereRaw('profiles.first_name LIKE \'%'.$partner_name.'%\'');
															}
										              })
										              ->whereExists(function($query) use ($payment_id){
											                if (isset($payment_id)) {
											                	if ($payment_id != 'atual') {
																	$query->select(DB::raw(1))
													                      ->from('payments_partners')
																		  ->whereRaw('payments_partners.id = transactions_vouchers.payment_partner_id')
																		  ->whereRaw('payments_partners.payment_id = '.$payment_id);
																}
															}
										              })
										              ->whereRaw('transactions_vouchers.voucher_id NOT IN (
													  				SELECT tv1.voucher_id 
													  				FROM transactions_vouchers tv1 
													  				WHERE tv1.status = \'cancelamento\' 
													  				AND tv1.voucher_id IN ( 
													  					SELECT tv2.voucher_id 
													  					FROM transactions_vouchers tv2 
													  					WHERE tv2.status = \'pagamento\' AND 
													  						(tv2.payment_partner_id = tv1.payment_partner_id OR 
													  						(tv2.payment_partner_id IS NULL AND tv1.payment_partner_id IS NULL))
													  				)
													  )')
													  ->orderBy($sort, $order)
													  ->get();

		$spreadsheet = array();
		$spreadsheet[] = array('Data', 'Número do Pedido', 'Cliente', 'Código do Cupom', 'Oferta e Opção Escolhida', 'Status', 'Valor do Cupom (R$)', 'Valor Parceiro (R$)');

		$voucher_price = 0;
		$transfer = 0;

		foreach ($transactionVoucherData as $transactionVoucher) {
			$ss = null;

			$coefficient = ( $transactionVoucher->status == 'pagamento' ? 1 : -1 );

			$ss[] = date("d/m/Y H:i:s", strtotime($transactionVoucher->created_at));
			$ss[] = $transactionVoucher->voucher->order_customer->braspag_order_id;
			$ss[] = $transactionVoucher->voucher->order->user->first_name.' '.$transactionVoucher->voucher->order->user->last_name;
			$ss[] = $transactionVoucher->voucher->id.'-'.$transactionVoucher->voucher->display_code.'-'.$transactionVoucher->voucher->offer_option_offer->offer->id;
			$ss[] = $transactionVoucher->voucher->offer_option_offer->offer->id.' | '.$transactionVoucher->voucher->offer_option_offer->offer->title.' ('.$transactionVoucher->voucher->offer_option_offer->title.')';
			$ss[] = $transactionVoucher->status;
			$ss[] = number_format($transactionVoucher->voucher->offer_option_offer->price_with_discount * $coefficient, 2, ',', '.');
			$ss[] = number_format($transactionVoucher->voucher->offer_option_offer->transfer * $coefficient, 2, ',', '.');

			$spreadsheet[] = $ss;

			$voucher_price += ($transactionVoucher->voucher->offer_option_offer->price_with_discount * $coefficient);
			$transfer += ($transactionVoucher->voucher->offer_option_offer->transfer * $coefficient);
		}

		$spreadsheet[] = array('Total', '', '', '', '', '', number_format($voucher_price, 2, ',', '.'), number_format($transfer, 2, ',', '.'));

		Excel::create('TransacoesDeVouchers')
	         ->sheet('TransacoesDeVouchers')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	// convert from d/m/Y H:i:s to Y-m-d H:i:s
	private function convertDatetime($datetime){
		$dt = explode(' ', $datetime);
		$d = explode('/', $dt[0]);
		return $d[2].'-'.$d[1].'-'.$d[0].' '.$dt[1];
	}

	// convert from d/m/Y to Y-m-d
	private function convertDate($date){
		$d = explode('/', $date);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}

	public function getCreate()
	{
		$this->layout->content = View::make('admin.payment.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
			'sales_from' => 'required|date_format:Y-m-d H:i:s',
			'sales_to' => 'required|date_format:Y-m-d H:i:s',
			'date' => 'required|date_format:Y-m-d|after:'.date('Y-m-d'),
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$id = $this->payment->create($inputs)->id;

			$script_date = date('Y-m-d H:i:s', strtotime($inputs['sales_to'])+1);
			$cron_date = Crontab::date2cron($script_date);
			$cronjob = $cron_date . $this->cron_command . $id;

			Crontab::addJob($cronjob);

			$this->payment->where('id', $id)->update(['cronjob' => $cronjob]);

			return Redirect::route('admin.payment.period');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.payment.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$payment = $this->payment->find($id);

		if (is_null($payment))
		{
			Session::flash('error', 'Período inválido para edição.');
			return Redirect::route('admin.payment.period');
		}

		$this->layout->content = View::make('admin.payment.edit', compact('payment'));
	}

	public function postEdit($id)
	{
		/*
		 * Faq
		 */
		$inputs = Input::all();

		$rules = [
			'sales_from' => 'required|date_format:Y-m-d H:i:s',
			'sales_to' => 'required|date_format:Y-m-d H:i:s',
			'date' => 'required|date_format:Y-m-d|after:'.date('Y-m-d'),
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$payment = $this->payment->find($id);

			if ($payment)
			{
				$script_date = date('Y-m-d H:i:s', strtotime($inputs['sales_to'])+1);
				$cron_date = Crontab::date2cron($script_date);
				$cronjob = $cron_date . $this->cron_command . $id;

				Crontab::removeJob($payment->cronjob); //remove atual cron job do crontab
				Crontab::addJob($cronjob); // insere novo cron job (com data atualizada) no crontab

				$inputs['cronjob'] = $cronjob;

				$payment->update($inputs);
			}

			return Redirect::route('admin.payment.period');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.payment.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$payment = $this->payment->find($id);

		if (is_null($payment))
		{
			Session::flash('error', 'Período que deseja excluir não existe.');
			return Redirect::route('admin.payment.period');
		}

		$rules = [
			'date' => 'required|after:'.date('Y-m-d'),
		];

	    $validation = Validator::make($payment->toArray(), $rules);

		if (!$validation->passes())
		{
			Session::flash('error', 'Período inválido para exclusão.');
			return Redirect::route('admin.payment.period');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este período de pagamento? Esta operação não poderá ser desfeita.');

		$data['paymentData'] = $payment->toArray();
		$data['paymentArray'] = null;

		foreach ($data['paymentData'] as $key => $value) {
			$data['paymentArray'][Lang::get('payment'. $key)] = $value;
		}

		$this->layout->content = View::make('admin.payment.delete', $data);
	}

	public function postDelete($id)
	{
		$payment = $this->payment->find($id);
		$payment->delete();

		Crontab::removeJob($payment->cronjob); //remove cron job do crontab

		Session::flash('success', 'Período de pagamento excluída com sucesso.');

		return Redirect::route('admin.payment.period');
	}

	/**
	 * Update approved attribute of comment.
	 *
	 * @return Response
	 */
	public function getUpdateStatus($id, $date = NULL){
		$payment_partner = $this->payment_partner->find($id);
		
		if($date == NULL){
			$payment_partner->paid_on = NULL;
			$payment_partner->save();
			Session::flash('success', 'Pagamento #'.$id.' alterado para "não pago" com sucesso.');
		}
		else{
			$date = str_replace('-', '/', $date);
			$payment_partner->paid_on = $this->convertDate($date);
			$payment_partner->save();

			$partner = User::where('id', $payment_partner->partner_id)->with('profile')->first();
			$payment = Payment::where('id', $payment_partner->payment_id)->first();

			$data = array(
				'name' => $partner->profile->first_name, 
				'sales_from' => date('d/m/Y', strtotime($payment->sales_from)), 
				'sales_to' => date('d/m/Y', strtotime($payment->sales_to)), 
				'total' => number_format($payment_partner->total, 2, ',', '.'), 
				'url' => route('painel.payment', ['id' => $payment_partner->id])
			);

			$email = $partner->email;

        	Mail::send('emails.payment.paid', $data, function($message) use($email){
				$message->to($email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Pagamento efetuado');
			});

			Session::flash('success', 'Pagamento #'.$id.' alterado para "pago em '.$date.'" com sucesso.');
		}

		return Redirect::back();
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyIndexTRANSACTIONS()
	{
		/*
		 * Obj
		 */
		$transactionObj = $this->transaction;

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
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


		/*
		 * Search filters
		 */
		if (Input::has('status') AND Input::get('status') != '') {
			$ppvoucher = $ppvoucher->where('status', '=', Input::get('status'));
		}

		if (Input::has('terms') AND Input::get('terms') != '') {
			$ppvoucher = $ppvoucher->where('payment_terms', 'like', '%'. Input::get('terms') .'%');
		}

		if (Input::has('braspag_order_id')) {
			$ppvoucher = $ppvoucher->where('braspag_order_id', 'like', '%'. Input::get('braspag_order_id') .'%');
		}

		if (Input::has('date_start')) {
			$ppvoucher = $ppvoucher->where('created_at', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$ppvoucher = $ppvoucher->where('created_at', '<=', Input::get('date_end'));
		}

		$transactionData = $transactionObj->with(['changer', 
												  'order',
												  'voucher' => function($query){ 
														$query->with(['offer_option'])
															  ->whereExists(function($query){ 
																if (Input::has('partner_id')) {
																	$query->select(DB::raw(1))
													                      ->from('offers_options')
													                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																		  ->whereRaw('offers_options.id = vouchers.offer_option_id')
																		  ->whereRaw('offers.partner_id = '.Input::get('partner_id'));
																}
									 					}); 
												  }])
										  ->whereExists(function($query){
								                if (Input::has('partner_id')) {
													$query->select(DB::raw(1))
									                      ->from('transactions_vouchers')
									                      ->join('vouchers', 'vouchers.id', '=', 'transactions_vouchers.voucher_id')
									                      ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
									                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
														  ->whereRaw('transactions_vouchers.transaction_id = transactions.id')
														  ->whereRaw('offers.partner_id = '.Input::get('partner_id'));
												}
							              })
							              ->whereExists(function($query){
								                if (Input::has('payment_id')) {
													$query->select(DB::raw(1))
									                      ->from('transactions_vouchers')
									                      ->join('payments_partners', 'payments_partners.id', '=', 'transactions_vouchers.payment_partner_id')
														  ->whereRaw('transactions.id = transactions_vouchers.transaction_id')
														  ->whereRaw('payments_partners.payment_id = '.Input::get('payment_id'));
												}
							              })
							              ->whereExists(function($query){
								                if (Input::has('is_paid')) {
													$$query->select(DB::raw(1))
									                      ->from('transactions_vouchers')
									                      ->join('payments_partners', 'payments_partners.id', '=', 'transactions_vouchers.payment_partner_id')
														  ->whereRaw('transactions.id = transactions_vouchers.transaction_id')
														  ->whereRaw('payments_partners.paid_on IS NOT NULL ');
												}
							              })
										  // ->orderBy($sort, $order)
										  // ->paginate($pag)
										  // ->appends([
												// 'sort' => $sort,
												// 'order' => $order,
												// 'status' => Input::get('status'),
												// 'terms' => Input::get('terms'),
												// 'date_start' => Input::get('date_start'),
												// 'date_end' => Input::get('date_end'),
												// 'offer_id' => Input::get('offer_id'),
												// 'name' => Input::get('name'),
												// 'email' => Input::get('email'),
										  // ]);
										  ->get();
		print('<pre>');
		print_r($transactionData->toArray());
		print('</pre>'); die();

		// foreach ($orderData as $key => &$order) {
		// 	$v = '';
		// 	foreach ($order->payment as $key2 => &$voucher) {
		// 		$v_valido = false;
		// 		$in_period = false;
		// 		foreach ($voucher->payment_partner_voucher as $key3 => $paym) {
		// 			if(isset($paym->payment_partner)){
		// 				$v_valido = true;
		// 				if(check_in_period($order->created_at, $paym->payment_partner->payment->sales_from, $paym->payment_partner->payment->sales_to)){
		// 					$in_period = true;
		// 				}
		// 			}
		// 		}

		// 		if($v_valido == true){
		// 			$v .= $voucher->id."\n";
		// 		}
		// 	}
		// 	$order->vouchers = ($v != '')?substr($v, 0, -1):'';
		// }

		// print('<pre>');
		// print_r($orderData->toArray());
		// print('</pre>'); die();

		$ps = Payment::orderBy('id', 'desc')->get();
		$paymData['options'] = array();
		$selected = false;

		foreach ($ps as $p) {
			if(!$selected && $p->date >= date("Y-m-d")){
				$selected == true;
				$paymData['selected'] = $p->id;
			}
			$paymData['options'][$p->id] = date("d/m/Y H:i:s", strtotime($p->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($p->sales_to)).' (dia a pagar: '.date("d/m/Y", strtotime($p->date)).')';
		}

		$this->layout->content = View::make('admin.payment.list', compact('sort', 'order', 'pag', 'transactionData', 'paymData'));
	}

	private function check_in_period($order_date, $start_date, $end_date)
	{
	// Convert to timestamp
		$start_ts = strtotime($start_date);
		$end_ts = strtotime($end_date);
		$order_ts = strtotime($order_date);

		// Check that user date is between start & end
		return (($order_ts >= $start_ts) && ($order_ts <= $end_ts));
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function anyIndexPAINEL()
	{
		/*
		 * Obj
		 */
		$ppvoucher = $this->ppvoucher;

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
    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';


		/*
		 * Search filters
		 */
		if (Input::has('status') AND Input::get('status') != '') {
			$ppvoucher = $ppvoucher->where('status', '=', Input::get('status'));
		}

		if (Input::has('terms') AND Input::get('terms') != '') {
			$ppvoucher = $ppvoucher->where('payment_terms', 'like', '%'. Input::get('terms') .'%');
		}

		if (Input::has('braspag_order_id')) {
			$ppvoucher = $ppvoucher->where('braspag_order_id', 'like', '%'. Input::get('braspag_order_id') .'%');
		}

		if (Input::has('date_start')) {
			$ppvoucher = $ppvoucher->where('created_at', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$ppvoucher = $ppvoucher->where('created_at', '<=', Input::get('date_end'));
		}

		$ppvoucherData = $ppvoucher->with(['voucher_offer_order', 'payment_partner'])
								// ->whereExists(function($query){
					   //              if (Input::has('offer_id')) {
								// 		$query->select(DB::raw(1))
						  //                     ->from('vouchers')
								// 			  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
						  //                     ->whereRaw('vouchers.order_id = orders.id')
						  //                     ->whereRaw('offers_options.offer_id = '.Input::get('offer_id'));
								// 	}

					   //          })
								// ->whereExists(function($query){
					   //              if (Input::has('name')) {
								// 		$query->select(DB::raw(1))
						  //                     ->from('profiles')
								// 			  ->whereRaw('profiles.user_id = orders.user_id')
								// 			  ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('name').'%"');
								// 	}

					   //          })
					   //          ->whereExists(function($query){
					   //              if (Input::has('email')) {
								// 		$query->select(DB::raw(1))
						  //                     ->from('users')
								// 			  ->whereRaw('users.id = orders.user_id')
								// 			  ->whereRaw('users.email LIKE "%'.Input::get('email').'%"');
								// 	}

					   //          })
								// ->orderBy($sort, $payment)
								// ->paginate($pag)
								// ->appends([
								// 	'sort' => $sort,
								// 	'order' => $order,
								// 	'status' => Input::get('status'),
								// 	'terms' => Input::get('terms'),
								// 	'date_start' => Input::get('date_start'),
								// 	'date_end' => Input::get('date_end'),
								// 	'offer_id' => Input::get('offer_id'),
								// 	'name' => Input::get('name'),
								// 	'email' => Input::get('email'),
								// ]);
								->get();

		// print('<pre>');
		// print_r($ppvoucherData->toArray());
		// print('</pre>'); die();

		$ps = Payment::orderBy('id', 'desc')->get();
		$pData['options'] = array();
		$selected = false;

		foreach ($ps as $p) {
			if(!$selected && $p->date >= date("Y-m-d")){
				$selected == true;
				$pData['selected'] = $p->id;
			}
			$pData['options'][$p->id] = date("d/m/Y H:i:s", strtotime($p->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($p->sales_to)).' (dia a pagar: '.date("d/m/Y", strtotime($p->date)).')';
		}

		$this->layout->content = View::make('admin.payment.list', compact('sort', 'order', 'pag', 'ppvoucherData', 'pData'));
	}

	// public function anyListByOffer(){
	// 	$offersOptions = new OfferOption;

	// 	/*
	// 	 * Paginate
	// 	 */

 //    	$pag = Input::get('pag', 50);

	// 	/*
	// 	 * Sort filter
	// 	 */
	// 	$sort = in_array(Input::get('sort'), ['id']) ? Input::get('sort') : 'offer_id';

	// 	/*
	// 	 * Order filter
	// 	 */
 //    	$payment = Input::get('order') === 'desc' ? 'desc' : 'asc';

 //    	/*
	// 	 * Search filter
	// 	 */
 //    	if(Input::has('offer_id')){
 //    		$offersOptions = $offersOptions->where('offer_id', Input::get('offer_id'));
 //    	}

	// 	$offersOptions = $offersOptions->with(['qty_sold', 'qty_pending', 'qty_cancelled', 'used_vouchers', 'offer'])
	// 								   ->whereExists(function($query){
	// 						                if (Input::has('starts_on') || Input::has('ends_on')) {
	// 											$query->select(DB::raw(1))
	// 							                      ->from('offers')
	// 												  ->whereRaw('offers.id = offers_options.offer_id');
	// 						                	if (Input::has('starts_on')) {
	// 						                		$query->whereRaw('offers.starts_on >= "'.Input::get('starts_on').'"');
	// 						                	}
	// 						                	if (Input::has('ends_on')) {
	// 						                		$query->whereRaw('offers.ends_on <= "'.Input::get('ends_on').'"');
	// 						                	}
	// 										}

	// 						           })
	// 								   ->orderBy($sort, $payment)
	// 								   ->paginate($pag)
	// 								   ->appends([
	// 										'sort' => $sort,
	// 										'order' => $payment,
	// 										'offer_id' => Input::get('offer_id'),
	// 										'starts_on' => Input::get('starts_on'),
	// 										'ends_on' => Input::get('ends_on'),
	// 								   ]);

	// 	$this->layout->content = View::make('admin.payment.offers', compact('sort', 'order', 'pag', 'offersOptions'));
	// }

	// public function getListOffersExport($offer_id, $starts_on, $ends_on){
	// 	$offersOptions = new OfferOption;

	// 	$offer_id = ($offer_id == 'null')?null:$offer_id;
	// 	$starts_on = ($starts_on == 'null')?null:$starts_on;
	// 	$ends_on = ($ends_on == 'null')?null:$ends_on;

	// 	/*
	// 	 * Search filter
	// 	 */
 //    	if($offer_id){
 //    		$offersOptions = $offersOptions->where('offer_id', $offer_id);
 //    	}

	// 	$offersOptions = $offersOptions->with(['qty_sold', 'qty_pending', 'qty_cancelled', 'offer'])
	// 										->whereExists(function($query) use($starts_on, $ends_on){
	// 							                if (isset($starts_on) || isset($ends_on)) {
	// 												$query->select(DB::raw(1))
	// 								                      ->from('offers')
	// 													  ->whereRaw('offers.id = offers_options.offer_id');
	// 							                	if (isset($starts_on)) {
	// 							                		$query->whereRaw('offers.starts_on >= "'.$starts_on.'"');
	// 							                	}
	// 							                	if (isset($ends_on)) {
	// 							                		$query->whereRaw('offers.ends_on <= "'.$ends_on.'"');
	// 							                	}
	// 											}

	// 							            })
	// 										->orderBy('offer_id', 'desc')
	// 										->get();

	// 	$spreadsheet = array();
	// 	$spreadsheet[] = array('ID da oferta', 'Oferta', 'Opção', 'Data início', 'Data fim', 'Valor', 'Máximo', 'Confirmados', 'Pendentes', 'Cancelados', 'Total');

	// 	foreach ($offersOptions as $offerOption) {
	// 		$ss = null;
	// 		$ss[] = $offerOption->offer_id;
	// 		$ss[] = $offerOption['offer']->title;
	// 		$ss[] = $offerOption->title;
	// 		$ss[] = $offerOption['offer']->starts_on;
	// 		$ss[] = $offerOption['offer']->ends_on;
	// 		$ss[] = $offerOption->price_with_discount;
	// 		$ss[] = $offerOption->max_qty;

	// 		$approved = isset($offerOption['qty_sold']{0})?$offerOption['qty_sold']{0}->qty:0;
	// 		$pending = isset($offerOption['qty_pending']{0})?$offerOption['qty_pending']{0}->qty:0;
	// 		$cancelled = isset($offerOption['qty_cancelled']{0})?$offerOption['qty_cancelled']{0}->qty:0;

	// 		$ss[] = $approved;
	// 		$ss[] = $pending;
	// 		$ss[] = $cancelled;
	// 		$ss[] = ($approved + $pending + $cancelled);

	// 		$spreadsheet[] = $ss;
	// 	}

	// 	print('<pre>');
	// 	print_r($spreadsheet);
	// 	print('</pre>'); die();

	// 	// $config = new ExporterConfig();
	// 	// $exporter = new Exporter($config);

	// 	// $exporter->export('php://output', $spreadsheet);
	// }

	// public function getListPaymExport($status, $terms, $name, $email, $braspag_order_id, $offer_id, $date_start, $date_end){
	// 	$status = ($status == 'null')?null:$status;
	// 	$terms = ($terms == 'null')?null:$terms;
	// 	$name = ($name == 'null')?null:$name;
	// 	$email = ($email == 'null')?null:$email;
	// 	$braspag_order_id = ($braspag_order_id == 'null')?null:$braspag_order_id;
	// 	$offer_id = ($offer_id == 'null')?null:$offer_id;
	// 	$date_start = ($date_start == 'null')?null:$date_start;
	// 	$date_end = ($date_end == 'null')?null:$date_end;

	// 	/*
	// 	 * Obj
	// 	 */
	// 	$paymentData = $this->payment;


	// 	/*
	// 	 * Search filters
	// 	 */
	// 	if ($status) {
	// 		$paymentData = $paymentData->where('status', $status);
	// 	}

	// 	if ($terms) {
	// 		$paymentData = $paymentData->where('payment_terms', 'like', '%'. $terms .'%');
	// 	}

	// 	if ($braspag_order_id) {
	// 		$paymentData = $paymentData->where('braspag_order_id', 'like', '%'. $braspag_order_id .'%');
	// 	}

	// 	if ($date_start) {
	// 		$paymentData = $paymentData->where('created_at', '>=', $date_start);
	// 	}

	// 	if ($date_end) {
	// 		$paymentData = $paymentData->where('created_at', '<=', $date_end);
	// 	}

	// 	$paymentArray = $paymentData->with(['user', 'voucher_offer'])
	// 							->whereExists(function($query) use($offer_id){
	// 				                if ($offer_id) {
	// 									$query->select(DB::raw(1))
	// 					                      ->from('vouchers')
	// 										  ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
	// 					                      ->whereRaw('vouchers.order_id = orders.id')
	// 					                      ->whereRaw('offers_options.offer_id = '.$offer_id);
	// 								}

	// 				            })
	// 							->whereExists(function($query) use($name){
	// 				                if ($name) {
	// 									$query->select(DB::raw(1))
	// 					                      ->from('profiles')
	// 										  ->whereRaw('profiles.user_id = orders.user_id')
	// 										  ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.$name.'%"');
	// 								}

	// 				            })
	// 				            ->whereExists(function($query) use($email){
	// 				                if ($email) {
	// 									$query->select(DB::raw(1))
	// 					                      ->from('users')
	// 										  ->whereRaw('users.id = orders.user_id')
	// 										  ->whereRaw('users.email LIKE "%'.$email.'%"');
	// 								}

	// 				            })
	// 							->orderBy('id', 'desc')
	// 							->get();

	// 	// print('<pre>');
	// 	// print_r($paymentArray->toArray());
	// 	// print('</pre>'); die();

	// 	$spreadsheet = array();
	// 	$spreadsheet[] = array('ID', 'Status', 'Valor pago', 'Itens comprados', 'Forma de pagamento', 'Data e hora', 'Cliente');

	// 	foreach ($paymentArray as $payment) {
	// 		$ss = null;
	// 		$ss[] = $payment->id;
	// 		$ss[] = $payment->status;
	// 		$ss[] = $payment->total;

	// 		$itens = '';

	// 		foreach ($payment->voucher_offer as $voucher) {
	// 			$itens .= 'R$ '.$voucher->offer_option->price_with_discount.' ('.$voucher->status.') | #'.$voucher->offer_option->offer_id.' '.$voucher->offer_option->offer_title.' ('.$voucher->offer_option->title.')'."\n";
	// 		}

	// 		$ss[] = substr($itens, 0, -1);

	// 		$ss[] = $payment->payment_terms;
	// 		$ss[] = $payment->created_at;
	// 		$ss[] = $payment['user']->first_name.' '.$payment['user']->last_name.' | '.$payment['user']->email;

	// 		$spreadsheet[] = $ss;
	// 	}

	// 	print('<pre>');
	// 	print_r($spreadsheet);
	// 	print('</pre>');

	// 	// $config = new ExporterConfig();
	// 	// $exporter = new Exporter($config);

	// 	// $exporter->export('php://output', $spreadsheet);
	// }

	// public function getOffersExport($offer_option_id, $status){
	// 	$offer_option_id = $offer_option_id;
	// 	$paymentsObj = $this->payment;

	// 	$paymentsObj = $paymentsObj->where('status', $status);

	// 	$paymentsData = $paymentsObj->with([
	// 									'user',
	// 									'discount_coupon',
	// 									'offer' => function($query) use($offer_option_id){
	// 											   $query->where('offers_options.id', $offer_option_id);
	// 										  	},
	// 									'voucher' => function($query) use($offer_option_id, $status){
	// 												$query->where('vouchers.offer_option_id', $offer_option_id)->where('vouchers.status', $status);
	// 											},
	// 								   ])
	// 							->whereExists(function($query) use($offer_option_id, $status){
	// 								$query->select(DB::raw(1))
	// 				                      ->from('vouchers')
	// 									  ->whereRaw('vouchers.order_id = orders.id')
	// 									  ->whereRaw('vouchers.offer_option_id = "'.$offer_option_id.'"')
	// 									  ->whereRaw('vouchers.status = "'.$status.'"');
	// 				            })
	// 							->get();

	// 	$spreadsheet = array();
	// 	$spreadsheet[] = array('Número do pedido', 'status', 'ID da oferta', 'Oferta', 'Opção', 'Preço', 'Quantidade', 'Total', 'Usuário INN', 'E-mail', 'Forma de pagamento', 'Titular do cartão', 'Telefone', 'Desconto via cupom', 'Desconto via créditos', 'Data de início', 'Data da captura da transação', 'Última atualização');

	// 	foreach ($paymentsData as $payment) {
	// 		$ss = null;
	// 		$ss[] = $payment->braspag_order_id;
	// 		$ss[] = $payment->status;
	// 		$ss[] = $payment['offer']{0}->offer_id;
	// 		$ss[] = $payment['offer']{0}->offer_title;
	// 		$ss[] = $payment['offer']{0}->title;
	// 		$ss[] = $payment['offer']{0}->price_with_discount;
	// 		$ss[] = count($payment['voucher']);
	// 		$ss[] = $payment->total;
	// 		$ss[] = $payment['user']->first_name.' '.$payment['user']->last_name;
	// 		$ss[] = $payment['user']->email;
	// 		$ss[] = $payment->payment_terms;
	// 		$ss[] = $payment->holder_card;
	// 		$ss[] = $payment->telephone;
	// 		$ss[] = isset($payment['discount_coupon'])?$payment['discount_coupon']->value:'--';
	// 		$ss[] = $payment->credit_discount;
	// 		$ss[] = $payment->created_at;
	// 		$ss[] = $payment->updated_at;
	// 		$ss[] = $payment->capture_date;

	// 		$spreadsheet[] = $ss;
	// 	}

	// 	print('<pre>');
	// 	print_r($spreadsheet);
	// 	print('</pre>');

	// 	// $config = new ExporterConfig();
	// 	// $exporter = new Exporter($config);

	// 	// $exporter->export('php://output', $spreadsheet);
	// }

	// public function anyVouchers($offer_option_id = null){
	// 	$vouchers = new Voucher;

	// 	// Exibe somente vouchers pagos
	// 	$vouchers = $vouchers->where('status', 'pago');

	// 	$offers = Offer::with(['offer_option'])->get();

	// 	// $offersOptions irá preencher o <select> da opção da qual estamos visualizando os vouchers/cupons
	// 	foreach ($offers as $offer) {
	// 		foreach ($offer['offer_option'] as $offer_option) {
	// 			$t = $offer->id.' | '.$offer->title.' | '.$offer_option->title;
	// 			$offersOptions[$offer_option->id] = $t;
	// 		}
	// 	}

	// 	/*
	// 	 * Paginate
	// 	 */

 //    	$pag = Input::get('pag', 50);

	// 	/*
	// 	 * Sort filter
	// 	 */
	// 	$sort = in_array(Input::get('sort'), ['display_code']) ? Input::get('sort') : 'id';

	// 	/*
	// 	 * Order filter
	// 	 */
 //    	$payment = Input::get('order') === 'desc' ? 'desc' : 'asc';


	// 	/*
	// 	 * Search filters
	// 	 */
	// 	if (Input::has('offer_option_id')) {
	// 		$offer_option_id = Input::get('offer_option_id');
	// 		$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
	// 	}
	// 	else if(isset($offer_option_id)){
	// 		$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
	// 	}

	// 	if(Input::has('id')){
	// 		$vouchers = $vouchers->where('id', Input::get('id'));
	// 	}

	// 	$vouchers = $vouchers->with(['order', 'offer_option'])
	// 						 ->whereExists(function($query){
	// 			 	                $query->select(DB::raw(1))
	// 			 		                  ->from('orders')
	// 			 		                  ->whereRaw('orders.status = "pago"')
	// 			 						  ->whereRaw('orders.id = vouchers.order_id');
	// 	               	   	 })
	// 						 ->orderBy($sort, $payment)
	// 						 ->paginate($pag)
	// 						 ->appends([
	// 							 'sort' => $sort,
	// 							 'order' => $payment,
	// 							 'offer_option_id' => $offer_option_id,
	// 							 'id' => Input::get('id'),
	// 						 ]);
	// 						 // ->get()->toArray();

	// 						 // print('<pre>');
	// 						 // print_r($vouchers);
	// 						 // print('</pre>'); die();

	// 	$this->layout->content = View::make('admin.payment.voucher', compact('sort', 'order', 'pag', 'offer_option_id', 'vouchers', 'offersOptions'));
	// }

	// public function getVoucherExport($offer_option_id = null, $id = null){
	// 	$id = ($id == 'null')?null:$id;
	// 	$offer_option_id = ($offer_option_id == 'null')?null:$offer_option_id;

	// 	$vouchers = new Voucher;

	// 	$vouchers = $vouchers->where('status', 'pago');

	// 	if(isset($offer_option_id)){
	// 		$vouchers = $vouchers->where('offer_option_id', $offer_option_id);
	// 	}

	// 	if(isset($id)){
	// 		$vouchers = $vouchers->where('id', $id);
	// 	}

	// 	$vouchers = $vouchers->with(['order', 'offer_option'])
	//                	   	     ->whereExists(function($query){
	// 			 	                $query->select(DB::raw(1))
	// 			 		                  ->from('orders')
	// 			 		                  ->whereRaw('orders.status = "pago"')
	// 			 						  ->whereRaw('orders.id = vouchers.order_id');
	// 	               	   	 })
	// 	 					 ->orderBy('id', 'asc')
	// 	 					 ->get();

	// 	$spreadsheet = array();
	// 	$spreadsheet[] = array('ID da oferta', 'Cupom', 'Agendado?', 'Nome', 'E-mail', 'Código de rastreamento');

	// 	foreach ($vouchers as $voucher) {
	// 		$ss = null;
	// 		$ss[] = $voucher['offer_option']->offer_id;
	// 		$ss[] = $voucher->id.'-'.$voucher->display_code.'-'.$voucher['offer_option']->offer_id;
	// 		$ss[] = ($voucher->used == 1)?'Sim':'Não';
	// 		$ss[] = $voucher['order']->first_name.' '.$voucher['order']->last_name;
	// 		$ss[] = $voucher['order']->email;
	// 		$ss[] = $voucher->tracking_code;

	// 		$spreadsheet[] = $ss;
	// 	}

	// 	print('<pre>');
	// 	print_r($spreadsheet);
	// 	print('</pre>');

	// 	// $config = new ExporterConfig();
	// 	// $exporter = new Exporter($config);

	// 	// $exporter->export('php://output', $spreadsheet);
	// }

	// public function getView($id)
	// {
	// 	$payment = $this->payment
	// 				->findOrFail($id)
	// 				->with([
	// 					'user',
	// 					'offer',
	// 					'discount_coupon',
	// 				])
	// 				->where('id', $id)
	// 				->first()
	// 				->toArray();
	// 	// print('<pre>');
	// 	// print_r($payment);
	// 	// print('</pre>'); die();

	// 	$data['orderData'] = [
	// 		'ID Compra' => $payment['braspag_order_id'],
	// 		'Braspag ID' => $payment['braspag_id'],
	// 		'Antifraud ID' => $payment['antifraud_id'],
	// 	];

	// 	$paymented_offers = [ 'Quantidade comprada' => count($payment['offer']) ];

	// 	foreach ($payment['offer'] as $ord) {
	// 		$paymented_offers = array_merge($paymented_offers,
	// 		[
	// 			'Voucher #'.$ord['pivot']['id'] => 'Código: '.$ord['pivot']['id'].'-'.$ord['pivot']['display_code'].'-'.$ord['offer_id'].(($ord['is_product'] == true)?' | Código de rastreamento: '.(isset($ord['pivot']['tracking_code'])?$ord['pivot']['tracking_code']:'--'):'').' | '.$ord['pivot']['status'].' | Oferta: #'.$ord['offer_id'].' '.$ord['offer_title'].'  ('.$ord['title'].' R$ '.$ord['price_with_discount'].')'
	// 		]);
	// 	}

	// 	$data['orderData'] = array_merge($data['orderData'], $paymented_offers);
	// 	$data['orderData'] = array_merge($data['orderData'],
	// 	[
	// 		'Total pago' => $payment['total'],
	// 		'Cupom de desconto' => isset($payment['discount_coupon'])?($payment['discount_coupon']['value'].' | '. $payment['discount_coupon']['display_code']) : '--',
	// 		'Crédito do usuário' => $payment['credit_discount'],
	// 		'Meio de pagamento' => $payment['payment_terms'],
	// 		'Títular do cartão' => $payment['holder_card'],
	// 		'Número do cartão' => (isset($payment['first_digits_card'])?$payment['first_digits_card']:'****').' **** **** ****',
	// 		'CPF/CNPJ' => $payment['cpf'],
	// 		'Telefone' => $payment['telephone'],
	// 		'Conta INN' => $payment['user']['first_name'].' '.$payment['user']['last_name'].' | '. $payment['user']['email'],
	// 		// 'Conta INN' => '<a href="'.route('admin.user.view', ['id' => $payment['user']['id']]).'">'.$payment['user']['first_name'].' '.$payment['user']['last_name'].' | '. $payment['user']['email'].'</a>',
	// 		'Início da transação' => $payment['created_at'],
	// 		'Última atualização' => $payment['updated_at'],
	// 		'Data/hora da captura' => $payment['capture_date'],
	// 		'Histórico' => $payment['history'],
	// 	]);

	// 	$data['orderData'] = array_map(function($v){
	// 		return (is_null($v)||empty($v)) ? "--" : $v;
	// 	}, $data['orderData']);

	// 	// print('<pre>');
	// 	// print_r($data);
	// 	// print('</pre>'); die();

	// 	$this->layout->content = View::make('admin.payment.view', $data);
	// }

	// private function sendTransactionalEmail($payment, $new_status){
	// 	$ids = array();
	// 	$qties = array();
	// 	$products_email = '';

	// 	$vouchers = Voucher::with(['offer_option'])->get();

	// 	foreach ($vouchers as $voucher) {
	// 		$products_email .= '<a href="' . route('oferta', $voucher->offer_option->slug) . '">' . $voucher->offer_option->offer_title . ' | ' . $voucher->offer_option->title . '</a><br/>';
	// 	}

	// 	// Removendo o último </br>
	// 	$products_email = substr($products_email, 0, -5);

	// 	$user = User::find($payment->user_id)->with('profile');

 //        $data = array('name' => $user->profile->first_name, 'products' => $products_email);

 //        if($new_status == 'pago'){
 //        	Mail::send('emails.order.order_approved', $data, function($message){
	// 			$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra aprovada');
	// 		});
 //        }
 //        else{ // $new_status = 'cancelado'
 //        	Mail::send('emails.order.order_rejected', $data, function($message){
	// 			$message->to($user->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Pagamento não aprovado');
	// 		});
 //        }

	// }

}
