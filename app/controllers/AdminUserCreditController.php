<?php

class AdminUserCreditController extends BaseController {

	/**
	 * User Indication Repository
	 *
	 * @var User Indication
	 */
	protected $credit_indication;

	/**
	 * Constructor
	 */
	public function __construct(UserCredit $credit_indication)
	{
		/*
		 * Set User Indication Instance
		 */

		$this->credit_indication = $credit_indication;

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
		$credit_indication = $this->credit_indication;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['user_id', 'new_user_id', 'value']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('value')) {
			$credit_indication = $credit_indication->where('value', Input::get('value'));
		}

		/*
		 * Finally Obj
		 */
		$credit_indication = $credit_indication->with(['user', 'new_user'])
					             ->whereExists(function($query){
					                if (Input::has('email')) {
										$query->select(DB::raw(1))
						                      ->from('users')
						                      ->whereRaw('users_credits.user_id = users.id')
						                      ->whereRaw('users.email LIKE "%'.Input::get('email').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('name')) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->join('profiles', 'profiles.user_id', '=', 'users.id')
						                      ->whereRaw('users_credits.user_id = users.id')
						                      ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('name').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('new_email')) {
										$query->select(DB::raw(1))
						                      ->from('users')
						                      ->whereRaw('users_credits.new_user_id = users.id')
						                      ->whereRaw('users.email LIKE "%'.Input::get('new_email').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('new_name')) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->join('profiles', 'profiles.user_id', '=', 'users.id')
						                      ->whereRaw('users_credits.new_user_id = users.id')
						                      ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('new_name').'%"');
									}

					             })
								 ->orderBy($sort, $order)
								 ->paginate($pag)
								 ->appends([
										'sort' => $sort,
										'order' => $order,
										'pag' => $pag,
										'name' => Input::get('name'),
										'email' => Input::get('email'),
										'new_name' => Input::get('new_name'),
										'new_email' => Input::get('new_email'),
										'value' => Input::get('value'),
								 ]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.credit_indication.list', compact('sort', 'order', 'pag', 'credit_indication'));
	}

}
