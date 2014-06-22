<?php

class AdminDestinyController extends BaseController {

	/**
	 * destiny Repository
	 *
	 * @var destiny
	 */
	protected $destiny;

	/**
	 * Constructor
	 */
	public function __construct(Destiny $destiny)
	{
		/*
		 * Set destiny Instance
		 */

		$this->destiny = $destiny;

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
		$destiny = $this->destiny;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$destiny = $destiny->where('name', 'like', '%'. Input::get('name') .'%');
		}

		/*
		 * Finally Obj
		 */
		$destiny = $destiny->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.destiny.list', compact('sort', 'order', 'pag', 'destiny'));
	}

	/**
	 * Display destiny Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.destiny.create');
	}

	/**
	 * Create destiny.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->destiny->create($inputs);

			return Redirect::route('admin.destiny');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.destiny.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display destiny Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$destiny = $this->destiny->find($id);

		if (is_null($destiny))
		{
			return Redirect::route('admin.destiny');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.destiny.edit', compact('destiny'));
	}

	/**
	 * Update destiny.
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
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$destiny = $this->destiny->find($id);

			if ($destiny)
			{
				$destiny->update($inputs);
			}

			return Redirect::route('admin.destiny');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.destiny.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display destiny Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$destiny = $this->destiny->find($id);

		if (is_null($destiny))
		{
			return Redirect::route('admin.destiny');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este destino? Esta operação não poderá ser desfeita.');

		$data['destinyData'] = $destiny->toArray();
		$data['destinyArray'] = null;

		foreach ($data['destinyData'] as $key => $value) {
			$data['destinyArray'][Lang::get('destiny.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.destiny.delete', $data);
	}

	/**
	 * Delete destiny.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->destiny->find($id)->delete();

		Session::flash('success', 'Destino excluído com sucesso.');

		return Redirect::route('admin.destiny');
	}

}
