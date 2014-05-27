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
		$transaction = $this->transaction;

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
			$transaction = $transaction->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$transaction = $transaction->with(['order'])
								   ->orderBy($sort, $order)
								   ->paginate($pag)
								   ->appends([
										'sort' => $sort,
										'order' => $order,
										'pag' => $pag,
										'title' => Input::get('title'),
									]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.transaction.list', compact('sort', 'order', 'pag', 'transaction'));
	}

}
