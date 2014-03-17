<?php

class AdminGenreController extends BaseController {

	/**
	 * Genre Repository
	 *
	 * @var Genre
	 */
	protected $genre;

	/**
	 * Constructor
	 */
	public function __construct(Genre $genre)
	{
		/*
		 * Set Genre Instance
		 */

		$this->genre = $genre;

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
		$genre = $this->genre;

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
			$genre = $genre->where('name', 'like', '%'. Input::get('name') .'%');
		}

		/*
		 * Finally Obj
		 */
		$genre = $genre->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.genre.list', compact('sort', 'order', 'pag', 'genre'));
	}

	/**
	 * Display Genre Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.genre.create');
	}

	/**
	 * Create Genre.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
        	'icon_url' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$img = ImageUpload::createFrom(Input::file('icon_url'), Config::get('upload.genre'));
			$inputs['icon_url'] = $img;

			$this->genre->create($inputs);

			return Redirect::route('admin.genre');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.genre.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Genre Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$genre = $this->genre->find($id);

		if (is_null($genre))
		{
			return Redirect::route('admin.genre');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.genre.edit', compact('genre'));
	}

	/**
	 * Update Genre.
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
        	'icon_url' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$genre = $this->genre->find($id);

			if ($genre)
			{
				$img = ImageUpload::createFrom(Input::file('icon_url'), Config::get('upload.genre'));
				$inputs['icon_url'] = $img;

				$genre->update($inputs);
			}

			return Redirect::route('admin.genre');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.genre.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Genre Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$genre = $this->genre->find($id);

		if (is_null($genre))
		{
			return Redirect::route('admin.genre');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta Gênero? Esta operação não poderá ser desfeita.');

		$data['genreData'] = $genre->toArray();
		$data['genreArray'] = null;

		foreach ($data['genreData'] as $key => $value) {
			$data['genreArray'][Lang::get('genre.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.genre.delete', $data);
	}

	/**
	 * Delete Genre.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->genre->find($id)->delete();

		Session::flash('success', 'Gênero excluída com sucesso.');

		return Redirect::route('admin.genre');
	}

	public function getClearfield($id, $field)
	{
		$genre = $this->genre->find($id);

		if (is_null($genre) || !isset($genre))
		{
			return Redirect::route('admin.genre.edit', $id);
		}

		$toDelete = $genre->{$field};

		$path = public_path() . $toDelete;
		if (File::exists($path)) {
			File::delete($path);
		}

		$genre->{$field} = null;
		$genre->save();

		Session::flash('success', 'O campo '.$field.' pode ser editado agora.');

		return Redirect::route('admin.genre.edit', $id);
	}

}
