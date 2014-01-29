<?php

class AdminPreBookingController extends BaseController {

	/**
	 * Pre Booking Repository
	 *
	 * @var Pre Booking
	 */
	protected $prebooking;

	/**
	 * Constructor
	 */
	public function __construct(PreBooking $prebooking)
	{
		/*
		 * Set Pre Booking Instance
		 */

		$this->prebooking = $prebooking;

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
		$prebooking = $this->prebooking;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['offer_id', 'user_id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('offer_id')) {
			$prebooking = $prebooking->where('offer_id', '=', Input::get('offer_id'));
		}

		/*
		 * Finally Obj
		 */
		$prebooking = $prebooking->with(['user', 'offer'])
								 ->whereExists(function($query){
					                if (Input::has('destiny')) {
										$query->select(DB::raw(1))
						                      ->from('offers')
						                      ->whereRaw('pre_bookings.offer_id = offers.id')
						                      ->whereRaw('offers.destiny LIKE "%'.Input::get('destiny').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('email')) {
										$query->select(DB::raw(1))
						                      ->from('users')
						                      ->whereRaw('pre_bookings.user_id = users.id')
						                      ->whereRaw('users.email LIKE "%'.Input::get('email').'%"');
									}

					             })
					             ->whereExists(function($query){
					                if (Input::has('name')) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->join('profiles', 'profiles.user_id', '=', 'users.id')
						                      ->whereRaw('pre_bookings.user_id = users.id')
						                      ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.Input::get('name').'%"');
									}

					             })
								 ->orderBy($sort, $order)
								 ->paginate($pag)
								 ->appends([
										'sort' => $sort,
										'order' => $order,
										'offer_id' => Input::get('offer_id'),
										'destiny' => Input::get('destiny'),
										'name' => Input::get('name'),
										'email' => Input::get('email'),
								 ]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.prebooking.list', compact('sort', 'order', 'pag', 'prebooking'));
	}

	public function getExport($offer_id, $destiny, $name, $email){
		$prebooking = new PreBooking;

		$offer_id = ($offer_id == 'null')?null:$offer_id;
		$destiny = ($destiny == 'null')?null:$destiny;
		$name = ($name == 'null')?null:$name;
		$email = ($email == 'null')?null:$email;

		/*
		 * Search filter
		 */
    	if($offer_id){
    		$prebooking = $prebooking->where('offer_id', $offer_id);
    	}

		/*
		 * Finally Obj
		 */
		$prebooking = $prebooking->with(['user', 'offer'])
								 ->whereExists(function($query) use($destiny){
					                if ($destiny) {
										$query->select(DB::raw(1))
						                      ->from('offers')
						                      ->whereRaw('pre_bookings.offer_id = offers.id')
						                      ->whereRaw('offers.destiny LIKE "%'.$destiny.'%"');
									}

					             })
					             ->whereExists(function($query) use($email){
					                if ($email) {
										$query->select(DB::raw(1))
						                      ->from('users')
						                      ->whereRaw('pre_bookings.user_id = users.id')
						                      ->whereRaw('users.email LIKE "%'.$email.'%"');
									}

					             })
					             ->whereExists(function($query) use($name){
					                if ($name) {
										$query->select(DB::raw(1))
						                      ->from('users')
											  ->join('profiles', 'profiles.user_id', '=', 'users.id')
						                      ->whereRaw('pre_bookings.user_id = users.id')
						                      ->whereRaw('CONCAT(profiles.first_name, " ", profiles.last_name) LIKE "%'.$name.'%"');
									}

					             })
								 ->orderBy('id', 'desc')
								 ->get();

		$spreadsheet = array();
		$spreadsheet[] = array('ID da oferta', 'Destino', 'Nome do cliente', 'E-mail do cliente', 'Telefone do cliente');

		foreach ($prebooking as $pb) {
			$ss = null;
			$ss[] = $pb->offer_id;
			$ss[] = $pb['offer']->destiny;
			$ss[] = $pb['user']->first_name.' '.$pb['user']->last_name;
			$ss[] = $pb['user']->email;
			$ss[] = $pb['user']->telephone1;


			$spreadsheet[] = $ss;
		}

		print('<pre>');
		print_r($spreadsheet);
		print('</pre>');

		// $config = new ExporterConfig();
		// $exporter = new Exporter($config);

		// $exporter->export('php://output', $spreadsheet);
	}

	// /**
	//  * Display Pre Booking Create Page.
	//  *
	//  * @return Response
	//  */

	// public function getCreate()
	// {
	// 	/*
	// 	 * Layout / View
	// 	 */

	// 	$this->layout->content = View::make('admin.prebooking.create');
	// }

	// /**
	//  * Create Pre Booking.
	//  *
	//  * @return Response
	//  */

	// public function postCreate()
	// {
	// 	$inputs = Input::all();

	// 	$rules = [
 //        	'name' => 'required',
	// 	];

	//     $validation = Validator::make($inputs, $rules);

	// 	if ($validation->passes())
	// 	{
	// 		$this->prebooking->create($inputs);

	// 		return Redirect::route('admin.prebooking');
	// 	}

	// 	/*
	// 	 * Return and display Errors
	// 	 */
	// 	return Redirect::route('admin.prebooking.create')
	// 		->withInput()
	// 		->withErrors($validation);
	// }

	// /**
	//  * Display Pre Booking Create Page.
	//  *
	//  * @return Response
	//  */

	// public function getEdit($id)
	// {
	// 	$prebooking = $this->prebooking->find($id);

	// 	if (is_null($prebooking))
	// 	{
	// 		return Redirect::route('admin.prebooking');
	// 	}

	// 	/*
	// 	 * Layout / View
	// 	 */

	// 	$this->layout->content = View::make('admin.prebooking.edit', compact('prebooking'));
	// }

	// /**
	//  * Update Pre Booking.
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
	// 		$prebooking = $this->prebooking->find($id);

	// 		if ($prebooking)
	// 		{
	// 			$prebooking->update($inputs);
	// 		}

	// 		return Redirect::route('admin.prebooking');
	// 	}

	// 	/*
	// 	 * Return and display Errors
	// 	 */
	// 	return Redirect::route('admin.prebooking.edit', $id)
	// 		->withInput()
	// 		->withErrors($validation);
	// }

	// /**
	//  * Display Pre Booking Delete Page.
	//  *
	//  * @return Response
	//  */

	// public function getDelete($id)
	// {
	// 	$prebooking = $this->prebooking->find($id);

	// 	if (is_null($prebooking))
	// 	{
	// 		return Redirect::route('admin.prebooking');
	// 	}

	// 	Session::flash('error', 'Você tem certeza que deleja excluir esta pré reserva? Esta operação não poderá ser desfeita.');

	// 	$data['prebookingData'] = $prebooking->toArray();
	// 	$data['prebookingArray'] = null;

	// 	foreach ($data['prebookingData'] as $key => $value) {
	// 		$data['prebookingArray'][Lang::get('prebooking.'. $key)] = $value;
	// 	}

	// 	/*
	// 	 * Layout / View
	// 	 */

	// 	$this->layout->content = View::make('admin.prebooking.delete', $data);
	// }

	// /**
	//  * Delete Pre Booking.
	//  *
	//  * @return Response
	//  */

	// public function postDelete($id)
	// {
	// 	$this->prebooking->find($id)->delete();

	// 	Session::flash('success', 'Papel de usuário excluído com sucesso.');

	// 	return Redirect::route('admin.prebooking');
	// }

}
