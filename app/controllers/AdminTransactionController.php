<?php

class AdminTransactionController extends BaseController {

	/**
	 * transaction Repository
	 *
	 * @var transaction
	 */
	protected $transaction;

	/**
	 * Constructor
	 */
	public function __construct(Transaction $transaction)
	{
		/*
		 * Set transaction Instance
		 */

		$this->transaction = $transaction;

		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$transactions = $this->transaction;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('date_start')) {
			$transactions = $transactions->where('created_at', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$transactions = $transactions->where('created_at', '<=', date('Y-m-d', strtotime(Input::get('date_end') . ' + 1 day')));
		}

		/*
		 * Finally Obj
		 */
		$transactions = $transactions->with(['order', 'voucher'])
								   ->orderBy($sort, $order)
								   ->paginate($pag)
								   ->appends([
										'sort' => $sort,
										'order' => $order,
										'pag' => $pag,
										'title' => Input::get('title'),
									]);
		
		$total['vouchers'] = 0;
		$total['credits'] = 0;
		$total['coupons'] = 0;
		$total['paid'] = 0;
		$total['cardBoletusRate'] = 0;
		$total['antecipationRate'] = 0;
		$total['transfer'] = 0;
		$total['gain'] = 0;
		$total['n_vouchers'] = 0;

		foreach ($transactions as $transaction) {
			$vouchers = 0;
			$transfers = 0;
			$display_codes = '';

			foreach ($transaction->voucher as $voucher) {
				$vouchers += $voucher->offer_option_offer->price_with_discount;
				$transfers += $voucher->offer_option_offer->transfer;
				$display_codes .= $voucher->id.'-'.$voucher->display_code.'<br/>';
			}

			$display_codes = substr($display_codes, 0, -5);

			if(strpos($transaction->order->payment_terms, 'cartão') !== false || strpos($transaction->order->payment_terms, 'Cartão') !== false){
				if($transaction->status == 'convercao_creditos' || $transaction->status == 'convercao_creditos_parcial'){
					$cardBoletusRate = 0;
					$antecipationRate = 0;
					$transaction->total = $vouchers - ($transaction->credit_discount + $transaction->coupon_discount);
				}
				else{
					$cardBoletusRate = $transaction->total * $transaction->order->card_boletus_rate;
					$antecipationRate = ($transaction->total - $cardBoletusRate) * $transaction->order->antecipation_rate;
				}
			}
			else if(strpos($transaction->order->payment_terms, 'boleto') !== false || strpos($transaction->order->payment_terms, 'Boleto') !== false){
				$cardBoletusRate = ($transaction->status == 'pagamento') ? $transaction->order->card_boletus_rate : 0;
				$antecipationRate = 0;
			}
			else{
				$cardBoletusRate = 0;
				$antecipationRate = 0;
			}

			$gain = ($transaction->total + $transaction->credit_discount) - $cardBoletusRate - $antecipationRate - $transfers;

			$transaction->vouchers = $vouchers;
			$transaction->transfers = $transfers;
			$transaction->gain = $gain;
			$transaction->card_boletus_rate = $cardBoletusRate;
			$transaction->antecipation_rate = $antecipationRate;
			$transaction->display_codes = $display_codes;

			if($transaction->status == 'pagamento'){
				$total['vouchers'] += $vouchers;
				$total['credits'] += $transaction->credit_discount;
				$total['coupons'] += $transaction->coupon_discount;
				$total['paid'] += $transaction->total;
				$total['cardBoletusRate'] += $cardBoletusRate;
				$total['antecipationRate'] += $antecipationRate;
				$total['transfer'] += $transfers;
				$total['gain'] += $gain;
				$total['n_vouchers'] += count($transaction->voucher);
			}
			else{
				$total['vouchers'] -= $vouchers;
				$total['credits'] -= $transaction->credit_discount;
				$total['coupons'] -= $transaction->coupon_discount;
				$total['paid'] -= $transaction->total;
				$total['cardBoletusRate'] -= $cardBoletusRate;
				$total['antecipationRate'] -= $antecipationRate;
				$total['transfer'] -= $transfers;
				$total['gain'] -= $gain;
				$total['n_vouchers'] -= count($transaction->voucher);
			}
		}

		$total = $this->round($total);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.transaction.list', compact('sort', 'order', 'pag', 'transactions', 'total'));
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function getExport($date_start, $date_end)
	{
		$date_start = ($date_start == 'null')?null:$date_start;
		$date_end = ($date_end == 'null')?null:$date_end;

		/*
		 * Obj
		 */
		$transactions = $this->transaction;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (isset($date_start)) {
			$transactions = $transactions->where('created_at', '>=', $date_start);
		}

		if (isset($date_end)) {
			$transactions = $transactions->where('created_at', '<', $date_end);
		}

		/*
		 * Finally Obj
		 */
		$transactions = $transactions->with(['order', 'voucher'])
								     ->orderBy($sort, $order)
								     ->get();
		
		$spreadsheet = array();
		$spreadsheet[] = array('Data', 'Número do pedido', 'Cliente', 'Tipo', 'Forma de pagto', 'Valor dos cupons (R$)', 'Créditos do usuário (R$)', 'Cupons de desconto (R$)', 'Total pago (R$)', 'Taxa cartão/boleto (R$) *', 'Taxa de antecipação (R$) **', 'Valor parceiro (R$) ***', 'Faturamento (R$)', 'Número de Cupons');

		$total['vouchers'] = 0;
		$total['credits'] = 0;
		$total['coupons'] = 0;
		$total['paid'] = 0;
		$total['cardBoletusRate'] = 0;
		$total['antecipationRate'] = 0;
		$total['transfer'] = 0;
		$total['gain'] = 0;
		$total['n_vouchers'] = 0;

		foreach ($transactions as $transaction) {
			$ss = null;
			$vouchers = 0;
			$transfers = 0;
			$display_codes = '';

			$coefficient = ( $transaction->status == 'pagamento' ? 1 : -1 );

			foreach ($transaction->voucher as $voucher) {
				$vouchers += $voucher->offer_option_offer->price_with_discount;
				$transfers += $voucher->offer_option_offer->transfer;
				$display_codes .= $voucher->id.'-'.$voucher->display_code.'<br/>';
			}

			$display_codes = substr($display_codes, 0, -5);

			if(strpos($transaction->order->payment_terms, 'cartão') !== false || strpos($transaction->order->payment_terms, 'Cartão') !== false){
				if($transaction->status == 'convercao_creditos' || $transaction->status == 'convercao_creditos_parcial'){
					$cardBoletusRate = 0;
					$antecipationRate = 0;
					$transaction->total = $vouchers - ($transaction->credit_discount + $transaction->coupon_discount);
				}
				else{
					$cardBoletusRate = $transaction->total * $transaction->order->card_boletus_rate;
					$antecipationRate = ($transaction->total - $cardBoletusRate) * $transaction->order->antecipation_rate;
				}
			}
			else if(strpos($transaction->order->payment_terms, 'boleto') !== false || strpos($transaction->order->payment_terms, 'Boleto') !== false){
				$cardBoletusRate = ($transaction->status == 'pagamento') ? $transaction->order->card_boletus_rate : 0;
				$antecipationRate = 0;
			}
			else{
				$cardBoletusRate = 0;
				$antecipationRate = 0;
			}

			$gain = ($transaction->total + $transaction->credit_discount) - $cardBoletusRate - $antecipationRate - $transfers;

			$transaction->vouchers = $vouchers;
			$transaction->transfers = $transfers;
			$transaction->gain = $gain;
			$transaction->card_boletus_rate = $cardBoletusRate;
			$transaction->antecipation_rate = $antecipationRate;
			$transaction->display_codes = $display_codes;

			$total['vouchers'] += ($vouchers * $coefficient);
			$total['credits'] += ($transaction->credit_discount * $coefficient);
			$total['coupons'] += ($transaction->coupon_discount * $coefficient);
			$total['paid'] += ($transaction->total * $coefficient);
			$total['cardBoletusRate'] += ($cardBoletusRate * $coefficient);
			$total['antecipationRate'] += ($antecipationRate * $coefficient);
			$total['transfer'] += ($transfers * $coefficient);
			$total['gain'] += ($gain * $coefficient);
			$total['n_vouchers'] += (count($transaction->voucher) * $coefficient);

			$ss[] = date("d/m/Y H:i:s", strtotime($transaction->created_at));
			$ss[] = $transaction->order->braspag_order_id;
			$ss[] = $transaction->order->buyer->profile->first_name.(isset($transaction->order->buyer->profile->last_name)?' '.$transaction->order->buyer->profile->last_name:'');
			$ss[] = $transaction->status;
			$ss[] = $transaction->order->payment_terms;
			$ss[] = number_format($transaction->vouchers * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->credit_discount * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->coupon_discount * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->total * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->card_boletus_rate * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->antecipation_rate * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->transfers * $coefficient, 2, ',', '.');
			$ss[] = number_format($transaction->gain * $coefficient, 2, ',', '.');
			$ss[] = count($transaction->voucher) * $coefficient;

			$spreadsheet[] = $ss;
		}

		$total = $this->round($total);

		/*
		 * Layout / View
		 */
		$spreadsheet[] = array('Total', '', '', '', '', number_format($total['vouchers'], 2, ',', '.'), number_format($total['credits'], 2, ',', '.'), number_format($total['coupons'], 2, ',', '.'), number_format($total['paid'], 2, ',', '.'), number_format($total['cardBoletusRate'], 2, ',', '.'), number_format($total['antecipationRate'], 2, ',', '.'), number_format($total['transfer'], 2, ',', '.'), number_format($total['gain'], 2, ',', '.'), $total['n_vouchers']);		

		Excel::create('Transacoes')
	         ->sheet('Transacoes')
	            ->with($spreadsheet)
	         ->export('xls');
	}

	private function round($total){
		foreach ($total as $key => $value) {
			$total[$key] = round($value, 2);
		}
		return $total;
	}

}
