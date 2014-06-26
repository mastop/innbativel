<?php

class AdminIncludedController extends BaseController {

	/**
	 * included Repository
	 *
	 * @var included
	 */
	protected $included;

	/**
	 * Constructor
	 */
	public function __construct(Included $included)
	{
		/*
		 * Set included Instance
		 */

		$this->included = $included;

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
		$included = $this->included;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title', 'description']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$included = $included->where('title', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('description')) {
			$included = $included->where('description', 'like', '%'. Input::get('description') .'%');
		}

		/*
		 * Finally Obj
		 */
		$included = $included->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'title' => Input::get('title'),
			'description' => Input::get('description'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Itens Inclusos';
		$this->layout->content = View::make('admin.included.list', compact('sort', 'order', 'pag', 'included'));
	}

	/**
	 * Display included Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.included.create');
	}

	/**
	 * Create included.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

        $rules = [
            'title' => 'required',
            'icon' => 'required',
        ];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
            $inputs['icon'] = str_replace('entypo-', '', $inputs['icon']);
			$this->included->create($inputs);

            Session::flash('success', 'Item Incluso criado com sucesso.');

			return Redirect::route('admin.included');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.included.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display included Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$included = $this->included->find($id);

		if (is_null($included))
		{
			return Redirect::route('admin.included');
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Editando Item Incluso #'.$included->id.' '.$included->title;
		$this->layout->content = View::make('admin.included.edit', compact('included'));
	}

	/**
	 * Update included.
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
        	'icon' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$included = $this->included->find($id);

			if ($included)
			{
                $inputs['icon'] = str_replace('entypo-', '', $inputs['icon']);
				$included->update($inputs);
			}
            Session::flash('success', 'Item Incluso alterado com sucesso.');
			return Redirect::route('admin.included');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.included.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display included Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$included = $this->included->find($id);

		if (is_null($included))
		{
            Session::flash('error', 'Item Incluso #'.$id.' não encontrado.');
			return Redirect::route('admin.included');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este "item incluso"? Esta operação não poderá ser desfeita.');

		$data['includedData'] = $included->toArray();
		$data['includedArray'] = null;

		foreach ($data['includedData'] as $key => $value) {
			$data['includedArray'][Lang::get('included.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Excluir Item Incluso #'.$included->id.' '.$included->title;
		$this->layout->content = View::make('admin.included.delete', $data);
	}

	/**
	 * Delete included.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->included->find($id)->delete();

		Session::flash('success', '"Item incluso" excluído com sucesso.');

		return Redirect::route('admin.included');
	}

}
