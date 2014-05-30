<?php

class AdminUserIndicationController extends BaseController {

	/**
	 * User Indication Repository
	 *
	 * @var User Indication
	 */
	protected $indication;

	/**
	 * Constructor
	 */
	public function __construct(UserIndication $indication)
	{
		/*
		 * Set User Indication Instance
		 */

		$this->indication = $indication;

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
		$indication = $this->indication;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['user_id', 'name', 'email']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('indicated_email')) {
			$indication = $indication->where('email', 'LIKE', '%'.Input::get('indicated_email').'%');
		}

		if (Input::has('indicated_name')) {
			$indication = $indication->where('name', 'LIKE', '%'.Input::get('indicated_name').'%');
		}

		/*
		 * Finally Obj
		 */
		$indication = $indication->with(['user'])
					             ->whereExists(function($query){
					                if (Input::has('email')) {
										$query->select(DB::raw(1))
						                      ->from('users')
						                      ->whereRaw('users_indications.user_id = users.id')
						                      ->whereRaw('users.email LIKE "%'.Input::get('email').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('name')) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->join('profiles', 'profiles.user_id', '=', 'users.id')
						                      ->whereRaw('users_indications.user_id = users.id')
						                      ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('name').'%"');
									}

					             })
								 ->orderBy($sort, $order)
								 ->paginate($pag)
								 ->appends([
										'sort' => $sort,
										'order' => $order,
										'pag' => $pag,
										'indicated_name' => Input::get('indicated_name'),
										'indicated_email' => Input::get('indicated_email'),
										'name' => Input::get('name'),
										'email' => Input::get('email'),
								 ]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.indication.list', compact('sort', 'order', 'pag', 'indication'));
	}

	/**
	 * Display User Indication Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.indication.create');
	}

	/**
	 * Create User Indication.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'user_id' => 'required|integer',
  			'email' => 'required|email',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			//
			//
			// MANDAR EMAIL PRO USUARIO INDICADO AQUI
			// AH, E NAO ESQUECER DO BACK-END DA INDICAÇÃO DE VARIOS E-MAILS PELA AREA DO USUARIO!
			//
			//

			$this->indication->create($inputs);

			return Redirect::route('admin.indication');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.indication.create')
			->withInput()
			->withErrors($validation);
	}

	// /**
	//  * Display User Indication Create Page.
	//  *
	//  * @return Response
	//  */

	// public function getEdit($id)
	// {
	// 	$indication = $this->indication->find($id);

	// 	if (is_null($indication))
	// 	{
	// 		return Redirect::route('admin.indication');
	// 	}

	// 	/*
	// 	 * Layout / View
	// 	 */

	// 	$this->layout->content = View::make('admin.indication.edit', compact('indication'));
	// }

	// /**
	//  * Update User Indication.
	//  *
	//  * @return Response
	//  */

	// public function postEdit($id)
	// {
	// 	/*
	// 	 * Permuration
	// 	 */
	// 	$inputs = Input::all();

	// 	$rules = [
 //        	'name' => 'required',
	// 	];

	//     $validation = Validator::make($inputs, $rules);

	// 	if ($validation->passes())
	// 	{
	// 		$indication = $this->indication->find($id);

	// 		if ($indication)
	// 		{
	// 			$indication->update($inputs);
	// 		}

	// 		return Redirect::route('admin.indication');
	// 	}

	// 	/*
	// 	 * Return and display Errors
	// 	 */
	// 	return Redirect::route('admin.indication.edit', $id)
	// 		->withInput()
	// 		->withErrors($validation);
	// }

	// /**
	//  * Display User Indication Delete Page.
	//  *
	//  * @return Response
	//  */

	// /**
	//  * Delete User Indication.
	//  *
	//  * @return Response
	//  */

	// public function postDelete($id)
	// {
	// 	$this->indication->find($id)->delete();

	// 	Session::flash('success', 'Papel de usuário excluído com sucesso.');

	// 	return Redirect::route('admin.indication');
	// }

}
