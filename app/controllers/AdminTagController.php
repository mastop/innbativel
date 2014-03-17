<?php

class AdminTagController extends BaseController {

	/**
	 * tag Repository
	 *
	 * @var tag
	 */
	protected $tag;

	/**
	 * Constructor
	 */
	public function __construct(Tag $tag)
	{
		/*
		 * Set tag Instance
		 */

		$this->tag = $tag;

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
		$tag = $this->tag;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

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
			$tag = $tag->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$tag = $tag->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'title' => Input::get('title'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.tag.list', compact('sort', 'order', 'pag', 'tag'));
	}

	/**
	 * Display tag Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tag.create');
	}

	/**
	 * Create tag.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->tag->create($inputs);

			return Redirect::route('admin.tag');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.tag.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display tag Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$tag = $this->tag->find($id);

		if (is_null($tag))
		{
			return Redirect::route('admin.tag');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tag.edit', compact('tag'));
	}

	/**
	 * Update tag.
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
			$tag = $this->tag->find($id);

			if ($tag)
			{
				$tag->update($inputs);
			}

			return Redirect::route('admin.tag');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.tag.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display tag Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$tag = $this->tag->find($id);

		if (is_null($tag))
		{
			return Redirect::route('admin.tag');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta tag? Esta operação não poderá ser desfeita.');

		$data['tagData'] = $tag->toArray();
		$data['tagArray'] = null;

		foreach ($data['tagData'] as $key => $value) {
			$data['tagArray'][Lang::get('tag.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tag.delete', $data);
	}

	/**
	 * Delete tag.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->tag->find($id)->delete();

		Session::flash('success', 'Tag excluída com sucesso.');

		return Redirect::route('admin.tag');
	}

}
