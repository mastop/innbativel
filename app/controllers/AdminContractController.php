<?php

class AdminContractController extends BaseController {

	/**
	 * contract Repository
	 *
	 * @var contract
	 */
	protected $contract;

	/**
	 * Constructor
	 */
	public function __construct(Contract $contract, ContractOption $contract_option)
	{
		/*
		 * Set contract Instance
		 */

		$this->contract = $contract;
		$this->contract_option = $contract_option;

		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;
	}

	// todos os campos de 'contracts' --> 'id', 'partner_id', 'company_name', 'cnpj', 'trading_name', 'address', 'complement', 'neighborhood', 'zip', 'city', 'state', 'agent1_name', 'agent1_cpf', 'agent1_telephone', 'agent2_name', 'agent2_cpf', 'agent2_telephone', 'bank_name', 'bank_number', 'bank_holder', 'bank_agency', 'bank_account', 'bank_financial_email', 'is_signed', 'is_sent', 'consultant', 'term', 'restriction', 'has_scheduling', 'sched_contact', 'sched_max_date', 'sched_dates', 'sched_min_antecedence', 'n_people', 'details', 'clauses', 'ip', 'signed_at', 'created_at', 'updated_at'

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
		$contract = $this->contract;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['partner_id', 'agent1_name']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';

		/*
		 * Search filters
		 */
		if (Input::has('id')) {
			$contract = $contract->where('id', Input::get('id'));
		}

		if (Input::has('consultant_id')) {
			$contract = $contract->where('consultant_id', Input::get('consultant_id'));
		}

		if (Input::has('is_signed')) {
			$contract = $contract->where('is_signed', (int) Input::get('is_signed'));
		}

		if (Input::has('is_sent')) {
			$contract = $contract->where('is_sent', (int) Input::get('is_sent'));
		}

		if (Input::has('created_at_begin')) {
			$contract = $contract->where('created_at', '>=', Input::get('created_at_begin'));
		}

		if (Input::has('created_at_end')) {
			$contract = $contract->where('created_at', '<=', Input::get('created_at_end'));
		}

		if (Input::has('signed_at_begin')) {
			$contract = $contract->where('signed_at', '>=', Input::get('signed_at_begin'));
		}

		if (Input::has('signed_at_end')) {
			$contract = $contract->where('signed_at', '<=', Input::get('signed_at_end'));
		}

		/*
		 * Finally Obj
		 */
		$contract = $contract->with(['partner', 'consultant'])
		->whereExists(function($query){
		    if (Input::has('partner_name')) {
				$query->select(DB::raw(1))
		              ->from('profiles')
					  ->whereRaw('contracts.partner_id = profiles.user_id')
					  ->whereRaw('CONCAT(CONCAT(COALESCE(profiles.first_name, ""), " ", COALESCE(profiles.last_name, "")), " ", profiles.company_name) LIKE \'%'.str_replace("'", "\'", Input::get('partner_name')).'%\'');
			}
		})
		->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'id' => Input::get('id'),
			'partner_name' => Input::get('partner_name'),
			'consultant_id' => Input::get('consultant_id'),
			'is_signed' => Input::get('is_signed'),
			'is_sent' => Input::get('is_sent'),
			'created_at_begin' => Input::get('created_at_begin'),
			'created_at_end' => Input::get('created_at_end'),
			'signed_at_begin' => Input::get('signed_at_begin'),
			'signed_at_end' => Input::get('signed_at_end'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.contract.list', compact('sort', 'order', 'pag', 'contract'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getView($id)
	{
		$contract = $this->contract->with(['consultant', 'partner'])->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato ID: '.$id.' inválido.');
			return Redirect::route('admin.contract');
		}

		$contract_options = $this->contract_option->where('contract_id',$id)->get();

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.contract.view', compact('contract', 'contract_options'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getSend($id)
	{
		$contract = $this->contract->with(['partner'])->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato ID: '.$id.' inválido.');
			return Redirect::route('admin.contract');
		}

		$email = $contract->partner->email;
		$name = $contract->partner->profile->first_name.(isset($contract->partner->profile->last_name)?' '.$contract->partner->profile->last_name:'');

		$data = array('name' => $name, 'id' => $id);

    	Mail::send('emails.contract.send', $data, function($message) use($email, $id){
			$message->to($email, 'INNBatível')
					->cc('contrato@innbativel.com.br', 'INNBatível')
					->replyTo('faleconosco@innbativel.com.br', 'INNBatível')
					->subject('Contrato ID: '.$id.' | INNBatível');
		});

		$contract->is_sent = true;
		$contract->save();

		/*
		 * Layout / View
		 */	

		Session::flash('success', 'Contrato ID: '.$id.' disponibilizado e enviado para '.$name.' com sucesso.');

		return Redirect::back();
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getPrint($id)
	{
		$contract = $this->contract->with(['consultant', 'partner'])->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato ID: '.$id.' inválido.');
			return Redirect::route('admin.contract');
		}

		$contract_options = $this->contract_option->where('contract_id',$id)->get();

		/*
		 * Layout / View
		 */

		$this->layout = View::make('themes.floripa.backend.blank');
		$this->layout->content = View::make('admin.contract.print', compact('contract', 'contract_options'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.contract.create');
	}

	/**
	 * Create contract.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$partner = Profile::where('user_id', $inputs['partner_id'])->first();

		$inputs['company_name'] = $partner->company_name;
		$inputs['trading_name'] = $partner->first_name.' '.$partner->last_name;
		$inputs['cnpj'] = $partner->cnpj;
		$inputs['address'] = $partner->street.(isset($partner->number)?(', '.$partner->number):'');
		$inputs['complement'] = $partner->complement;
		$inputs['neighborhood'] = $partner->neighborhood;
		$inputs['zip'] = $partner->zip;
		$inputs['city'] = $partner->city;
		$inputs['state'] = $partner->state;

		$inputs['consultant_id'] = Auth::user()->id;
		
		$inputs['clauses'] = Configuration::get('clauses');

		$options = $inputs['options'];
		unset($inputs['options']);

		$rules = [
        	'partner_id' => 'required',
        	'agent1_name' => 'required',
        	'agent1_telephone' => 'required',
        	'bank_name' => 'required',
        	'bank_number' => 'required',
        	'bank_holder' => 'required',
        	'bank_agency' => 'required',
        	'bank_account' => 'required',
        	'bank_cpf_cnpj' => 'required',
        	'bank_financial_email' => 'required',
        	'initial_term' => 'required',
        	'final_term' => 'required',
			'n_people' => 'required|integer',
			'restriction' => 'required',
			'features' => 'required',
			'rules' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$contract = $this->contract->create($inputs);

			$id = $contract->id;
			$n_options = count($options['title']);

			for ($i=0; $i < $n_options; $i++) { 
				$contract_option = [
					'contract_id' 		  => $id,
					'title'		  		  => $options['title'][$i],
					'price_original'	  => $options['price_original'][$i],
					'price_with_discount' => $options['price_with_discount'][$i],
					'percent_off'		  => $options['percent_off'][$i],
					'transfer'		  	  => $options['transfer'][$i],
					'max_qty'		  	  => $options['max_qty'][$i],
				];

				$this->contract_option->create($contract_option);
			}

			// INÍCIO E-MAIL

			$partner = Profile::where('user_id', $contract->partner_id)->first();
			$consultant = Profile::where('user_id', $contract->consultant_id)->first();

			$partner_name = $partner->first_name.(isset($partner->last_name)?' '.$partner->last_name:'');
			$consultant_name = $consultant->first_name.(isset($consultant->last_name)?' '.$consultant->last_name:'');

			$data = array('partner_name' => $partner_name, 'consultant_name' => $consultant_name, 'id' => $id);
			
	    	Mail::send('emails.contract.create', $data, function($message) use($partner_name, $id){
				$message->to('contrato@innbativel.com.br', 'INNBatível')
						->replyTo('faleconosco@innbativel.com.br', 'INNBatível')
						->subject('Contrato ID: '.$id.' cadastrado | Parceiro: '.$partner_name);
			});

			// FIM E-MAIL

			Session::flash('success', 'Contrato ID: '.$id.' cadastrado com sucesso.');

			return Redirect::route('admin.contract');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.contract.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$contract = $this->contract->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato ID: '.$id.' inválido.');
			return Redirect::route('admin.contract');
		}

		$contract_options = $this->contract_option->where('contract_id',$id)->get();

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.contract.edit', compact('contract', 'contract_options'));
	}

	/**
	 * Update contract.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		$inputs = Input::all();

		// $partner = Profile::where('user_id', $inputs['partner_id'])->first();

		// $inputs['company_name'] = $partner->company_name;
		// $inputs['trading_name'] = $partner->first_name.' '.$partner->last_name;
		// $inputs['cnpj'] = $partner->cnpj;
		// $inputs['address'] = $partner->address.(isset($partner->number)?(', '.$partner->number):'');
		// $inputs['complement'] = $partner->complement;
		// $inputs['neighborhood'] = $partner->neighborhood;
		// $inputs['zip'] = $partner->zip;
		// $inputs['city'] = $partner->city;
		// $inputs['state'] = $partner->state;

		// $inputs['consultant_id'] = Auth::user()->id;
		
		// $inputs['clauses'] = Configuration::get('clauses');

		$options = $inputs['options'];
		unset($inputs['options']);
		unset($inputs['_token']);

		$rules = [
        	'partner_id' => 'required',
        	'agent1_name' => 'required',
        	'agent1_telephone' => 'required',
        	'bank_name' => 'required',
        	'bank_number' => 'required',
        	'bank_holder' => 'required',
        	'bank_agency' => 'required',
        	'bank_account' => 'required',
        	'bank_cpf_cnpj' => 'required',
        	'bank_financial_email' => 'required',
        	'initial_term' => 'required',
        	'final_term' => 'required',
			'n_people' => 'required|integer',
			'restriction' => 'required',
			'features' => 'required',
			'rules' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$contract = $this->contract->find($id);

			if($contract)
			{
				$contract->update($inputs);

				$this->contract_option->where('contract_id', $contract->id)->delete();

				$n_options = count($options['title']);

				for ($i=0; $i < $n_options; $i++) { 
					$contract_option = [
						'contract_id' 		  => $contract->id,
						'title'		  		  => $options['title'][$i],
						'price_original'	  => $options['price_original'][$i],
						'price_with_discount' => $options['price_with_discount'][$i],
						'percent_off'		  => $options['percent_off'][$i],
						'transfer'		  	  => $options['transfer'][$i],
						'max_qty'		  	  => $options['max_qty'][$i],
					];

					$this->contract_option->create($contract_option);
				}
			}

			return Redirect::route('admin.contract');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.contract.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display contract Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$contract = $this->contract->with(['partner', 'consultant', 'option'])->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato ID: '.$id.' inválido.');
			return Redirect::route('admin.contract');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este contrato? Esta operação não poderá ser desfeita.');

		$data['contractData'] = $contract->toArray();
		$data['contractArray'] = null;

		foreach ($data['contractData'] as $key => $value) {
			if(is_array($value)){
				foreach ($value as $key2 => $value2) {
					if(is_array($value2)){
						foreach ($value2 as $key3 => $value3) {
							$data['contractArray'][Lang::get('contract.'. $key.'.'.$key2.'.'.$key3)] = (!empty($value3)?$value3:'--');
						}
					}
					else{
						$data['contractArray'][Lang::get('contract.'. $key.'.'.$key2)] = (!empty($value2)?$value2:'--');
					}
				}
			}
			else{
				$data['contractArray'][Lang::get('contract.'. $key)] = (!empty($value)?$value:'--');
			}
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.contract.delete', $data);
	}

	/**
	 * Delete contract.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->contract->find($id)->delete();

		Session::flash('success', 'Contrato excluído com sucesso.');

		return Redirect::route('admin.contract');
	}

}
