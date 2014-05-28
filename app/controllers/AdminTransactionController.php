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

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '10';

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
		if (Input::has('title')) {
			$transactions = $transaction->where('title', 'like', '%'. Input::get('title') .'%');
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

		foreach ($transactions as $transaction) {
			$vouchers = 0;
			$transfers = 0;

			foreach ($transaction->voucher as $voucher) {
				$vouchers += $voucher->offer_option_offer->price_with_discount;
				$transfers += $voucher->offer_option_offer->transfer;
			}

			if(strpos($transaction->order->payment_terms, 'cartão') !== false || strpos($transaction->order->payment_terms, 'Cartão') !== false){
				$cardBoletusRate = $transaction->total * $transaction->order->card_boletus_rate;
			}
			else{
				$cardBoletusRate = $transaction->order->card_boletus_rate;
			}
			
			$antecipationRate = ($transaction->total - $cardBoletusRate) * $transaction->order->antecipation_rate;

			$gain = $transaction->total - $cardBoletusRate - $antecipationRate - $transfers;

			$transaction->vouchers = $vouchers;
			$transaction->transfers = $transfers;
			$transaction->gain = $gain;

			if($transaction->status == 'pagamento'){
				$total['vouchers'] += $vouchers;
				$total['credits'] += $transaction->credit_discount;
				$total['coupons'] += $transaction->coupon_discount;
				$total['paid'] += $transaction->total;
				$total['cardBoletusRate'] += $cardBoletusRate;
				$total['antecipationRate'] += $antecipationRate;
				$total['transfer'] += $transfers;
				$total['gain'] += $gain;
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
			}
		}

		$total = $this->round($total);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.transaction.list', compact('sort', 'order', 'pag', 'transactions', 'total'));
	}

	private function round($total){
		foreach ($total as $key => $value) {
			$total[$key] = round($value, 2);
		}
		return $total;
	}

}
