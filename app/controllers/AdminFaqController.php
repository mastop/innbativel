<?php

class AdminFaqController extends BaseController {

	/**
	 * Faq Repository
	 *
	 * @var Faq
	 */
	protected $faq;
	protected $faqGroup;

	public function __construct(Faq $faq, FaqGroup $faqGroup)
	{
		$this->faq = $faq;
		$this->faqGroup = $faqGroup;
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
		$faq = $this->faq;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['id', 'question', 'answer']) ? Input::get('sort') : 'display_order';

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

		/*
		 * Finally Obj
		 */
		$faq = $faq->with(['group'])->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'question' => Input::get('question'),
			'answer' => Input::get('answer'),
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
		$inputs['faq_group_id'] = $inputs['faq_group_id'] == NULL ? NULL : $inputs['faq_group_id'];

		$rules = [
			'question' => 'required',
			'answer' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			Cache::forget('faq'); // Deleta do cache para atualizar o valor

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
		$inputs['faq_group_id'] = $inputs['faq_group_id'] == NULL ? NULL : $inputs['faq_group_id'];

		$rules = [
			'question' => 'required',
			'answer' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$faq = $this->faq->find($id);

			if ($faq)
			{
				Cache::forget('faq'); // Deleta do cache para atualizar o valor

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
		Cache::forget('faq'); // Deleta do cache para atualizar o valor

		$this->faq->find($id)->delete();

		Session::flash('success', 'FAQ excluída com sucesso.');

		return Redirect::route('admin.faq');
	}

	public function getSort(){
		/*
		 * Obj
		 */
		$groups = $this->faqGroup->with(['faq'])->orderBy('display_order', 'asc')->get();
		$faqs = $this->faq->whereNull('faq_group_id')->orderBy('display_order', 'asc')->get();
		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.faq.sort', compact('groups', 'faqs'));
	}

	public function postSort(){
		$faqs_groups = Input::get('faqs_groups');

		$fg_display_order = 1;

		// só há um "problema": quando o bloco Grupo fica vazio, não é atualizado seu display_order
		// porém não é realmente um problema pois nunca deverá haver um Grupo vazio, isso não faz sentido (seria um erro de quem configurou)
		foreach ($faqs_groups as $faq_group_id => $faqs) {
			if($faq_group_id != 0){
				$fg = FaqGroup::find($faq_group_id);
				$fg->display_order = $fg_display_order++;
				$fg->save();

				foreach ($faqs as $display_order => $faq_id) {
					$f = Faq::find($faq_id);
					$f->display_order = $display_order;
					$f->faq_group_id = $faq_group_id;
					$f->save();
				}
			}
		}

		Cache::forget('faq'); // Deleta do cache para atualizar o valor

		return Redirect::route('admin.faq.sort');
	}

	/**
	 * Display all Faqs.
	 *
	 * @return Response
	 */
	public function anyGroup()
	{
		/*
		 * Obj
		 */
		$faqGroup = $this->faqGroup->select(['id', 'title']);

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['id', 'title']) ? Input::get('sort') : 'display_order';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$faqGroup = $faqGroup->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$faqGroup = $faqGroup->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'title' => Input::get('title'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.faq.group.list', compact('sort', 'order', 'pag', 'faqGroup'));

	}

	public function getGroupCreate()
	{
		$this->layout->content = View::make('admin.faq.group.create');
	}

	public function postGroupCreate()
	{
		$inputs = Input::all();

		$rules = [
			'title' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->faqGroup->create($inputs);

			return Redirect::route('admin.faq.group');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.faq.group.create')
			->withInput()
			->withErrors($validation);
	}

	public function getGroupEdit($id)
	{
		$faqGroup = $this->faqGroup->find($id);

		if (is_null($faqGroup))
		{
			return Redirect::route('admin.faq.group');
		}

		$this->layout->content = View::make('admin.faq.group.edit', compact('faqGroup'));
	}

	public function postGroupEdit($id)
	{
		/*
		 * Faq
		 */
		$inputs = Input::all();

		$rules = [
			'title' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$faqGroup = $this->faqGroup->find($id);

			if ($faqGroup)
			{
				Cache::forget('faq'); // Deleta do cache para atualizar o valor

				$faqGroup->update($inputs);
			}

			return Redirect::route('admin.faq.group');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.faq.group.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getGroupDelete($id)
	{
		$faqGroup = $this->faqGroup->find($id);

		if (is_null($faqGroup))
		{
			return Redirect::route('admin.faq.group');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este Grupo de FAQs? Esta operação não poderá ser desfeita.');

		$data['faqGroupData'] = $faqGroup->toArray();
		$data['faqGroupArray'] = null;

		foreach ($data['faqGroupData'] as $key => $value) {
			$data['faqGroupArray'][Lang::get('faqGroup.'. $key)] = $value;
		}

		$this->layout->content = View::make('admin.faq.group.delete', $data);
	}

	public function postGroupDelete($id)
	{
		Cache::forget('faq'); // Deleta do cache para atualizar o valor
		
		$this->faqGroup->find($id)->delete();

		Session::flash('success', 'Grupo de FAQs excluída com sucesso.');

		return Redirect::route('admin.faq.group');
	}

}
