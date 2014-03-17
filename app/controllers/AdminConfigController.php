<?php

class AdminConfigController extends BaseController {

	/**
	 * Configuration Repository
	 *
	 * @var Configuration
	 */
	protected $config;

	public function __construct(Configuration $config)
	{
		$this->config = $config;
		$this->sidebar = true;
	}

	/**
	 * Display all Configurations.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$config = $this->config->select(['id', 'name', 'value']);

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

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
			$config = $config->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('value')) {
			$config = $config->where('value', 'like', '%'. Input::get('value') .'%');
		}

		/*
		 * Finally Obj
		 */
		$config = $config->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
			'value' => Input::get('value'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.config.list', compact('sort', 'order', 'pag', 'config'));

	}

	public function getCreate()
	{
		$this->layout->content = View::make('admin.config.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
			'name' => 'required|unique:configurations,name',
			'value' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->config->create($inputs);

			return Redirect::route('admin.config');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.config.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$config = $this->config->find($id);

		if (is_null($config))
		{
			return Redirect::route('admin.config');
		}

		$this->layout->content = View::make('admin.config.edit', compact('config'));
	}

	public function postEdit($id)
	{
		/*
		 * Configuration
		 */
		$inputs = Input::all();

		$rules = [
			'name' => 'required|unique:configurations,name,'. $id,
        	'value' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$config = $this->config->find($id);

			if ($config)
			{
				$config->update($inputs);
			}

			return Redirect::route('admin.config');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.config.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$config = $this->config->find($id);

		if (is_null($config))
		{
			return Redirect::route('admin.config');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta configuração? Esta operação não poderá ser desfeita.');

		$data['configData'] = $config->toArray();
		$data['configArray'] = null;

		foreach ($data['configData'] as $key => $value) {
			$data['configArray'][Lang::get('config.'. $key)] = $value;
		}

		$this->layout->content = View::make('admin.config.delete', $data);
	}

	public function postDelete($id)
	{
		$this->config->find($id)->delete();

		Session::flash('success', 'configuração excluída com sucesso.');

		return Redirect::route('admin.config');
	}

}
