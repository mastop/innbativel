<?php

class AdminPartnerTestimonyController extends BaseController {

	/**
	 * PartnerTestimony Repository
	 *
	 * @var PartnerTestimony
	 */
	protected $partner_testimony;

	/**
	 * Constructor
	 */
	public function __construct(PartnerTestimony $partner_testimony)
	{
		/*
		 * Set PartnerTestimony Instance
		 */

		$this->partner_testimony = $partner_testimony;

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
		$partner_testimony = $this->partner_testimony;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'destiny', 'sponsor', 'role']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$partner_testimony = $partner_testimony->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('destiny')) {
			$partner_testimony = $partner_testimony->where('destiny', 'like', '%'. Input::get('destiny') .'%');
		}

		if (Input::has('sponsor')) {
			$partner_testimony = $partner_testimony->where('sponsor', 'like', '%'. Input::get('sponsor') .'%');
		}

		if (Input::has('role')) {
			$partner_testimony = $partner_testimony->where('role', 'like', '%'. Input::get('role') .'%');
		}

		if (Input::has('testimony')) {
			$partner_testimony = $partner_testimony->where('testimony', 'like', '%'. Input::get('testimony') .'%');
		}

		/*
		 * Finally Obj
		 */
		$partner_testimony = $partner_testimony->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'destiny' => Input::get('destiny'),
			'sponsor' => Input::get('sponsor'),
			'role' => Input::get('role'),
			'testimony' => Input::get('testimony'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.partner_testimony.list', compact('sort', 'order', 'pag', 'partner_testimony'));
	}

	/**
	 * Display PartnerTestimony Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.partner_testimony.create');
	}

	/**
	 * Create PartnerTestimony.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
        	'destiny' => 'required',
        	'sponsor' => 'required',
        	'role' => 'required',
			'testimony' => 'required',
			'img' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$img = ImageUpload::createFrom(Input::file('img'), Config::get('upload.partner_testimony'));
			$inputs['img'] = $img;

			$this->partner_testimony->create($inputs);

			return Redirect::route('admin.partner_testimony');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner_testimony.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display PartnerTestimony Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$partner_testimony = $this->partner_testimony->find($id);

		if (is_null($partner_testimony))
		{
			return Redirect::route('admin.partner_testimony');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.partner_testimony.edit', compact('partner_testimony'));
	}

	/**
	 * Update PartnerTestimony.
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
        	'name' => 'required',
        	'destiny' => 'required',
        	'sponsor' => 'required',
        	'role' => 'required',
			'testimony' => 'required',
			'img' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$partner_testimony = $this->partner_testimony->find($id);

			if ($partner_testimony)
			{
				$img = ImageUpload::createFrom(Input::file('img'), Config::get('upload.partner_testimony'));
				$inputs['img'] = $img;

				$partner_testimony->update($inputs);
			}

			return Redirect::route('admin.partner_testimony');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.partner_testimony.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display PartnerTestimony Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$partner_testimony = $this->partner_testimony->find($id);

		if (is_null($partner_testimony))
		{
			return Redirect::route('admin.partner_testimony');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este depoimento do parceiro? Esta operação não poderá ser desfeita.');

		$data['partnerTestimonyData'] = $partner_testimony->toArray();
		$data['partnerTestimonyArray'] = null;

		foreach ($data['partnerTestimonyData'] as $key => $value) {
			$data['partnerTestimonyArray'][Lang::get('partner_testimony.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.partner_testimony.delete', $data);
	}

	/**
	 * Delete PartnerTestimony.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->partner_testimony->find($id)->delete();

		Session::flash('success', 'Depoimento do parceiro excluído com sucesso.');

		return Redirect::route('admin.partner_testimony');
	}

	public function getClearfield($id, $field)
	{
		$partner_testimony = $this->partner_testimony->find($id);

		if (is_null($partner_testimony) || !isset($partner_testimony))
		{
			return Redirect::route('admin.partner_testimony.edit', $id);
		}

		$toDelete = $partner_testimony->{$field};

		$path = public_path() . $toDelete;
		if (File::exists($path)) {
			File::delete($path);
		}

		$partner_testimony->{$field} = null;
		$partner_testimony->save();

		Session::flash('success', 'O campo '.$field.' pode ser editado agora.');

		return Redirect::route('admin.partner_testimony.edit', $id);
	}

	public function getSort(){
		/*
		 * Obj
		 */
		$partner_testimonyObj = $this->partner_testimony;

		/*
		 * Finally Obj
		 */
		$partner_testimony = $partner_testimonyObj->orderBy('display_order', 'asc')
						    ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.partner_testimony.sort', compact('partner_testimony'));
	}

	public function postSort(){
		$partner_testimony = Input::get('partner_testimony');

		foreach ($partner_testimony as $display_order => $id) {
			$tu = PartnerTestimony::find($id);
			$tu->display_order = $display_order;
			$tu->save();
		}

		return Redirect::route('admin.partner_testimony.sort');
	}

}
