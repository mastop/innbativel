<?php

class AdminFaqController extends BaseController {

	/**
	 * Faq Repository
	 *
	 * @var Faq
	 */
	protected $faq;

	public function __construct(Faq $faq)
	{
		$this->faq = $faq;
		$this->sidebar = true;
	}

	/**
	 * Display all Faqs.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$faq = $this->faq->select(['id', 'question', 'answer', 'group_title']);

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
			$faq = $faq->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('value')) {
			$faq = $faq->where('value', 'like', '%'. Input::get('value') .'%');
		}

		/*
		 * Finally Obj
		 */
		$faq = $faq->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'name' => Input::get('name'),
			'value' => Input::get('value'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.faq.list', compact('sort', 'order', 'pag', 'faq'));

	}

	public function getCreate()
	{
		$this->layout->content = View::make('admin.faq.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
			'name' => 'required|unique:faqs,name',
			'value' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->faq->create($inputs);

			return Redirect::route('admin.faq');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.faq.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$faq = $this->faq->find($id);

		if (is_null($faq))
		{
			return Redirect::route('admin.faq');
		}

		$this->layout->content = View::make('admin.faq.edit', compact('faq'));
	}

	public function postEdit($id)
	{
		/*
		 * Faq
		 */
		$inputs = Input::all();

		$rules = [
			'name' => 'required|unique:faqs,name,'. $id,
        	'value' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$faq = $this->faq->find($id);

			if ($faq)
			{
				$faq->update($inputs);
			}

			return Redirect::route('admin.faq');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.faq.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$faq = $this->faq->find($id);

		if (is_null($faq))
		{
			return Redirect::route('admin.faq');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta faquração? Esta operação não poderá ser desfeita.');

		$data['faqData'] = $faq->toArray();
		$data['faqArray'] = null;

		foreach ($data['faqData'] as $key => $value) {
			$data['faqArray'][Lang::get('faq.'. $key)] = $value;
		}

		$this->layout->content = View::make('admin.faq.delete', $data);
	}

	public function postDelete($id)
	{
		$this->faq->find($id)->delete();

		Session::flash('success', 'faquração excluída com sucesso.');

		return Redirect::route('admin.faq');
	}

}
