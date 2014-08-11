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

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$genre = $genre->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$genre = $genre->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'title' => Input::get('title'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Gêneros';
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
        $this->layout->page_title = 'Criar Gênero';
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
        	'title' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$inputs['icon'] = str_replace('map-icon-', '', $inputs['icon']);

			$this->genre->create($inputs);

            Session::flash('success', 'Gênero criado com sucesso.');

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
        $this->layout->page_title = 'Editando Gênero #'.$genre->id.' '.$genre->title;
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
        	'title' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$genre = $this->genre->find($id);

			if ($genre)
			{
                $inputs['icon'] = str_replace('map-icon-', '', $inputs['icon']);
				$genre->update($inputs);
			}
            Session::flash('success', 'Gênero alterado com sucesso.');

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
            Session::flash('error', 'Gênero #'.$id.' não encontrado.');
			return Redirect::route('admin.genre');
		}elseif($id == 1){
            Session::flash('error', 'O gênero de ID #1 não pode ser excluído.');
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
        $this->layout->page_title = 'Excluir Gênero #'.$genre->id.' '.$genre->title;
		$this->layout->content = View::make('admin.genre.delete', $data);
	}

	/**
	 * Delete Genre.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
        // Troca os gêneros das ofertas que usam o gênero que está sendo deletado
        Offer::where('genre_id', '=', $id)->update(array('genre_id' => 1));
        Offer::where('genre2_id', '=', $id)->update(array('genre2_id' => null));
		$this->genre->find($id)->delete();

		Session::flash('success', 'Gênero excluído com sucesso.');

		return Redirect::route('admin.genre');
	}

}
