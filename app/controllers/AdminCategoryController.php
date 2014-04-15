<?php

class AdminCategoryController extends BaseController {

	/**
	 * Category Repository
	 *
	 * @var Category
	 */
	protected $category;

	/**
	 * Constructor
	 */
	public function __construct(Category $category)
	{
		/*
		 * Set Category Instance
		 */

		$this->category = $category;

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
		$category = $this->category;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title', 'id']) ? Input::get('sort') : 'display_order';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$category = $category->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$category = $category->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'title' => Input::get('title'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.category.list', compact('sort', 'order', 'pag', 'category'));
	}

	/**
	 * Display Category Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.category.create');
	}

	/**
	 * Create Category.
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
			$this->category->create($inputs);

			return Redirect::route('admin.category');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.category.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Category Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$category = $this->category->find($id);

		if (is_null($category))
		{
			return Redirect::route('admin.category');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.category.edit', compact('category'));
	}

	/**
	 * Update Category.
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
			$category = $this->category->find($id);

			if ($category)
			{
				$category->update($inputs);
			}

			return Redirect::route('admin.category');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.category.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Category Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$category = $this->category->find($id);

		if (is_null($category))
		{
			return Redirect::route('admin.category');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta categoria? Esta operação não poderá ser desfeita.');

		$data['categoryData'] = $category->toArray();
		$data['categoryArray'] = null;

		foreach ($data['categoryData'] as $key => $value) {
			$data['categoryArray'][Lang::get('category.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.category.delete', $data);
	}

	/**
	 * Delete Category.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->category->find($id)->delete();

		Session::flash('success', 'Categoria excluída com sucesso.');

		return Redirect::route('admin.category');
	}

	public function getSort(){
		/*
		 * Obj
		 */
		$categoryObj = $this->category;

		/*
		 * Finally Obj
		 */
		$categories = $categoryObj->orderBy('display_order', 'asc')
								 ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.category.sort', compact('categories'));
	}

	public function postSort(){
		$categories = Input::get('categories');
		foreach ($categories as $display_order => $id) {
			$c = Category::find($id);
            if (!is_null($c))
            {
			    $c->display_order = $display_order;
			    $c->save();
            }
		}
		return Redirect::route('admin.category.sort');
	}
}
