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

    	$sort = in_array(Input::get('sort'), ['question', 'answer', 'group_title']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('question')) {
			$faq = $faq->where('question', 'like', '%'. Input::get('question') .'%');
		}

		if (Input::has('answer')) {
			$faq = $faq->where('answer', 'like', '%'. Input::get('answer') .'%');
		}

		if (Input::has('group_title')) {
			$faq = $faq->where('group_title', 'like', '%'. Input::get('group_title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$faq = $faq->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'question' => Input::get('question'),
			'answer' => Input::get('answer'),
			'group_title' => Input::get('group_title'),
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
			'question' => 'required',
			'answer' => 'required',
			'group_title' => 'required',
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
			'question' => 'required',
			'answer' => 'required',
			'group_title' => 'required',
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

		Session::flash('error', 'Você tem certeza que deleja excluir esta FAQ? Esta operação não poderá ser desfeita.');

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

		Session::flash('success', 'FAQ excluída com sucesso.');

		return Redirect::route('admin.faq');
	}

}
