<?php

class AdminNgoController extends BaseController {

	/**
	 * NGO Repository
	 *
	 * @var NGO
	 */
	protected $ngo;

	/**
	 * Constructor
	 */
	public function __construct(Ngo $ngo)
	{
		/*
		 * Set NGO Instance
		 */

		$this->ngo = $ngo;

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
		$ngo = $this->ngo;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'description']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$ngo = $ngo->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('description')) {
			$ngo = $ngo->where('description', 'like', '%'. Input::get('description') .'%');
		}

		/*
		 * Finally Obj
		 */
		$ngo = $ngo->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
			'description' => Input::get('description'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.ngo.list', compact('sort', 'order', 'pag', 'ngo'));
	}

	/**
	 * Display NGO Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.ngo.create');
	}

	/**
	 * Create NGO.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
        	'description' => 'required',
        	'img' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$img = ImageUpload::createFrom(Input::file('img'), Config::get('upload.ngo'));
			$inputs['img'] = $img;

			$this->ngo->create($inputs);

			return Redirect::route('admin.ngo');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.ngo.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display NGO Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$ngo = $this->ngo->find($id);

		if (is_null($ngo))
		{
			return Redirect::route('admin.ngo');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.ngo.edit', compact('ngo'));
	}

	/**
	 * Update NGO.
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
        	'description' => 'required',
        	'img' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$ngo = $this->ngo->find($id);

			if ($ngo)
			{
				$img = ImageUpload::createFrom(Input::file('img'), Config::get('upload.ngo'));
				$inputs['img'] = $img;

				$ngo->update($inputs);
			}

			return Redirect::route('admin.ngo');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.ngo.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display NGO Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$ngo = $this->ngo->find($id);

		if (is_null($ngo))
		{
			return Redirect::route('admin.ngo');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta ONG? Esta operação não poderá ser desfeita.');

		$data['ngoData'] = $ngo->toArray();
		$data['ngoArray'] = null;

		foreach ($data['ngoData'] as $key => $value) {
			$data['ngoArray'][Lang::get('ngo.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.ngo.delete', $data);
	}

	/**
	 * Delete NGO.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->ngo->find($id)->delete();

		Session::flash('success', 'ONG excluída com sucesso.');

		return Redirect::route('admin.ngo');
	}

	public function getClearfield($id, $field)
	{
		$ngo = $this->ngo->find($id);

		if (is_null($ngo) || !isset($ngo))
		{
			return Redirect::route('admin.ngo.edit', $id);
		}

		$toDelete = $ngo->{$field};

		$path = public_path() . $toDelete;
		if (File::exists($path)) {
			File::delete($path);
		}

		$ngo->{$field} = null;
		$ngo->save();

		Session::flash('success', 'O campo '. $field .' pode ser editado agora.');

		return Redirect::route('admin.ngo.edit', $id);
	}

}
