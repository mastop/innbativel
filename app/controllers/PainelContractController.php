<?php

class PainelContractController extends BaseController {

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

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

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

		if (Input::has('signed_at_begin')) {
			$contract = $contract->where('signed_at', '>=', Input::get('signed_at_begin'));
		}

		if (Input::has('signed_at_end')) {
			$contract = $contract->where('signed_at', '<=', Input::get('signed_at_end'));
		}

		/*
		 * Finally Obj
		 */
		$contract = $contract->where('partner_id', Auth::user()->id);

		$contract = $contract->with(['partner', 'consultant'])->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'id' => Input::get('id'),
			'is_signed' => Input::get('is_signed'),
			'signed_at_begin' => Input::get('signed_at_begin'),
			'signed_at_end' => Input::get('signed_at_end'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('painel.contract.list', compact('sort', 'order', 'pag', 'contract'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getView($id)
	{
		$contract = $this->contract->with(['consultant', 'partner'])->where('partner_id', Auth::user()->id)->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato (ID: '.$id.') inválido.');
			return Redirect::route('painel.contract');
		}

		$contract_options = $this->contract_option->where('contract_id',$id)->get();

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('painel.contract.view', compact('contract', 'contract_options'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getPrint($id)
	{
		$contract = $this->contract->with(['consultant', 'partner'])->where('partner_id', Auth::user()->id)->find($id);

		if (is_null($contract))
		{
			Session::flash('error', 'Contrato (ID: '.$id.') inválido.');
			return Redirect::route('painel.contract');
		}

		$contract_options = $this->contract_option->where('contract_id',$id)->get();

		/*
		 * Layout / View
		 */

		$this->layout = View::make('themes.floripa.backend.blank');
		$this->layout->content = View::make('painel.contract.print', compact('contract', 'contract_options'));
	}

	/**
	 * Display contract Create Page.
	 *
	 * @return Response
	 */

	public function getSign($id)
	{
		
	}

	/**
	 * Create contract.
	 *
	 * @return Response
	 */

	public function postSign($id)
	{
		
	}

}
