<?php

// use SebastianBergmann\Money\Currency;
// use SebastianBerBRLgmann\Money\Money;
// use SebastianBergmann\BRLMoney\IntlFormatter;

class PainelPaymentController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $payment, $payment_partner, $transaction_voucher;

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

		$this->actions = 'painel.payment';

		/*
		 * Models Instance
		 */

		$this->payment = $payment;
		$this->payment_partner = $payment_partner;
		$this->transaction_voucher = $transaction_voucher;
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

		if (Input::has('id')) {
			$payment_partner = $payment_partner->where('id', Input::get('id'));
		}

		if (Input::has('payment_id')) {
			$payment_partner = $payment_partner->where('payment_id', Input::get('payment_id'));
		}

		$payment_partner = $payment_partner->where('partner_id', Auth::user()->id);

		$paymentPartnerData = $payment_partner->with(['payment', 'partner'])
											  ->orderBy($sort, $order)
											  ->paginate($pag)
											  ->appends([
													'sort' => $sort,
													'order' => $order,
													'pag' => $pag,
													'id' => Input::get('id'),
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

		$this->layout->content = View::make('painel.payment.list', compact('sort', 'order', 'pag', 'paymentPartnerData', 'paymData', 'totals'));
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

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */
		$sort = in_array(Input::get('sort'), ['user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */
    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';
    	

		$transactionVoucherData = $transaction_voucher->with(['voucher' => function($query){ 
																	$query->with(['offer_option_offer', 'order_customer'])
																		  ->whereExists(function($query){ 
																				$query->select(DB::raw(1))
																                      ->from('offers_options')
																                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																					  ->whereRaw('offers_options.id = vouchers.offer_option_id')
																					  ->whereRaw('offers.partner_id = '.Auth::user()->id);
												 					}); 
															  }])
													  ->whereExists(function($query){
															$query->select(DB::raw(1))
											                      ->from('vouchers')
											                      ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
											                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																  ->whereRaw('vouchers.id = transactions_vouchers.voucher_id')
																  ->whereRaw('offers.partner_id = '.Auth::user()->id);
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
															'payment_id' => Input::get('payment_id'),
													  ]);
													  // ->get()->toArray();print('<pre>');print_r($transactionVoucherData);print('</pre>');die();

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

		$this->layout->content = View::make('painel.payment.voucher', compact('sort', 'order', 'pag', 'transactionVoucherData', 'paymData', 'totals'));
	}

	public function getExport($id, $payment_id){
		$id = ($id == 'null')?null:$id;
		$payment_id = ($payment_id == 'null')?null:$payment_id;

		/*
		 * Obj
		 */
		$payment_partner = $this->payment_partner;

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

		if (isset($id)) {
			$payment_partner = $payment_partner->where('id', $id);
		}

		if (isset($payment_id)) {
			$payment_partner = $payment_partner->where('payment_id', $payment_id);
		}

		$payment_partner = $payment_partner->where('partner_id', Auth::user()->id);

		$paymentPartnerData = $payment_partner->with(['payment', 'partner'])
											  ->orderBy($sort, $order)
											  ->get();

		$transfer = 0;

		$spreadsheet = array();
		$spreadsheet[] = array('ID', 'Período', 'Data a Ser Pago', 'Data do Pagamento', 'Valor Total das Vendas (R$)');

		foreach ($paymentPartnerData as $paymentPartner) {
			$ss = null;

			$ss[] = $paymentPartner->payment_id;
			$ss[] = date("d/m/Y H:i:s", strtotime($paymentPartner->payment->sales_from)).' - '.date("d/m/Y H:i:s", strtotime($paymentPartner->payment->sales_to));
			$ss[] = date("d/m/Y H:i:s", strtotime($paymentPartner->payment->date));
			$ss[] = isset($paymentPartner->paid_on)?date("d/m/Y", strtotime($paymentPartner->paid_on)):'Não pago';
			$ss[] = number_format($paymentPartner->total, 2, ',', '.');

			$spreadsheet[] = $ss;

			$transfer += $paymentPartner->total;
		}

		$spreadsheet[] = array('Total', '', '', '', number_format($transfer, 2, ',', '.'));

		Excel::create('PagamentosINNBativel')
	         ->sheet('PagamentosINNBativel')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	public function getVoucherExport($payment_id){
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


		$transactionVoucherData = $transaction_voucher->with(['voucher' => function($query){ 
																	$query->with(['offer_option_offer', 'order_customer'])
																		  ->whereExists(function($query){ 
																				$query->select(DB::raw(1))
																                      ->from('offers_options')
																                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																					  ->whereRaw('offers_options.id = vouchers.offer_option_id')
																					  ->whereRaw('offers.partner_id = '.Auth::user()->id);
												 					}); 
															  }])
										              ->whereExists(function($query){
															$query->select(DB::raw(1))
											                      ->from('vouchers')
											                      ->join('offers_options', 'offers_options.id', '=', 'vouchers.offer_option_id')
											                      ->join('offers', 'offers.id', '=', 'offers_options.offer_id')
																  ->whereRaw('vouchers.id = transactions_vouchers.voucher_id')
																  ->whereRaw('offers.partner_id = '.Auth::user()->id);
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
		$spreadsheet[] = array('Data', 'Cliente', 'Código do Cupom', 'Oferta e Opção Escolhida', 'Status', 'Valor do Cupom (R$)', 'Valor a Receber (R$)');

		$voucher_price = 0;
		$transfer = 0;

		foreach ($transactionVoucherData as $transactionVoucher) {
			$ss = null;

			$coefficient = ( $transactionVoucher->status == 'pagamento' ? 1 : -1 );

			$ss[] = date("d/m/Y H:i:s", strtotime($transactionVoucher->created_at));
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

		$spreadsheet[] = array('Total', '', '', '', '', number_format($voucher_price, 2, ',', '.'), number_format($transfer, 2, ',', '.'));

		Excel::create('TransacoesDeVouchersINNBativel')
	         ->sheet('TransacoesDeVouchersINNBativel')
	            ->with($spreadsheet)
	         ->export('xls');
	}

}
