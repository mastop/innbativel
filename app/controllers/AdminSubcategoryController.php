<?php

class AdminSubcategoryController extends BaseController {

	/**
	 * Permission Repository
	 *
	 * @var Permission
	 */
	protected $subcategory;

	/**
	 * Constructor
	 */
	public function __construct(Subcategory $subcategory)
	{
		/*
		 * Set Permission Instance
		 */

		$this->subcategory = $subcategory;

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
		$subcategoryObj = $this->subcategory;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['is_active','title','id','display_order']) ? Input::get('sort') : 'category_id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$subcategoryObj = $subcategoryObj->where('title', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('is_active')) {
			$subcategoryObj = $subcategoryObj->where('is_active', Input::get('is_active'));
		}

		if (Input::has('category_id')) {
			$subcategoryObj = $subcategoryObj->where('category_id', Input::get('category_id'));
		}

		/*
		 * Finally Obj
		 */
		$subcategory = $subcategoryObj->with(['category'])
								   ->orderBy($sort, $order)
								   ->paginate($pag)
								   ->appends([
										'sort' => $sort,
										'order' => $order,
										'title' => Input::get('title'),
										'is_active' => Input::get('is_active'),
										'category_id' => Input::get('category_id'),
									]);

		// print('<pre>');
		// print_r($subcategory);
		// print('</pre>');

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.subcategory.list', compact('sort', 'order', 'pag', 'subcategory'));
	}

	/**
	 * Display Permission Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.subcategory.create');
	}

	/**
	 * Create Permission.
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
			$this->subcategory->create($inputs);

			return Redirect::route('admin.subcategory');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.subcategory.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Permission Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$subcategory = $this->subcategory->find($id);

		if (is_null($subcategory))
		{
			return Redirect::route('admin.subcategory');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.subcategory.edit', compact('subcategory'));
	}

	/**
	 * Update Permission.
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
			$subcategory = $this->subcategory->find($id);

			if ($subcategory)
			{
				$subcategory->update($inputs);
			}

			return Redirect::route('admin.subcategory');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.subcategory.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Permission Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$subcategory = $this->subcategory->find($id);

		if (is_null($subcategory))
		{
			return Redirect::route('admin.subcategory');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta Subcategoria? Esta operação não poderá ser desfeita.');

		$data['subcategoryData'] = $subcategory->toArray();
		$data['subcategoryArray'] = null;

		foreach ($data['subcategoryData'] as $key => $value) {
			$data['subcategoryArray'][Lang::get('subcategory.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.subcategory.delete', $data);
	}

	/**
	 * Delete Permission.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->subcategory->find($id)->delete();

		Session::flash('success', 'Subcategoria excluída com sucesso.');

		return Redirect::route('admin.subcategory');
	}

}
