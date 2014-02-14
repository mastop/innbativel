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
	public function __construct(Contract $contract)
	{
		/*
		 * Set contract Instance
		 */

		$this->contract = $contract;

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
		$contract = $this->contract;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['partner_id', 'agent1_name']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('id')) {
			$contract = $contract->where('id', Input::get('id'));
		}

		if (Input::has('partner_id')) {
			$contract = $contract->where('partner_id', Input::get('partner_id'));
		}

		if (Input::has('agent1_name')) {
			$contract = $contract->where('agent1_name', 'like', '%'. Input::get('description') .'%')->orWhere('agent2_name', 'like', '%'. Input::get('description') .'%');
		}

		if (Input::has('is_signed')) {
			$contract = $contract->where('is_signed', Input::get('is_signed'));
		}

		if (Input::has('is_sent')) {
			$contract = $contract->where('is_sent', Input::get('is_sent'));
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
		$contract = $contract->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'id' => Input::get('id'),
			'partner_id' => Input::get('partner_id'),
			'agent1_name' => Input::get('agent1_name'),
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

		$rules = [
        	'term' => 'required|date',
			'restriction' => 'required',
			'n_people' => 'required|integer',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->contract->create($inputs);

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
			return Redirect::route('admin.contract');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.contract.edit', compact('contract'));
	}

	/**
	 * Update contract.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::all();

		$rules = [
        	'term' => 'required|date',
			'restriction' => 'required',
			'n_people' => 'required|integer',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$contract = $this->contract->find($id);

			if ($contract)
			{
				$contract->update($inputs);
			}

			return Redirect::route('admin.contract');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.contract.edit', $id)
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
		$contract = $this->contract->find($id);

		if (is_null($contract))
		{
			return Redirect::route('admin.contract');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este contrato? Esta operação não poderá ser desfeita.');

		$data['contractData'] = $contract->toArray();
		$data['contractArray'] = null;

		foreach ($data['contractData'] as $key => $value) {
			$data['contractArray'][Lang::get('contract.'. $key)] = $value;
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
