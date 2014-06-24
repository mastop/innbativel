<?php

class AdminHolidayController extends BaseController {

	/**
	 * holiday Repository
	 *
	 * @var holiday
	 */
	protected $holiday;

	/**
	 * Constructor
	 */
	public function __construct(Holiday $holiday)
	{
		/*
		 * Set holiday Instance
		 */

		$this->holiday = $holiday;

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
		$holiday = $this->holiday;

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
			$holiday = $holiday->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$holiday = $holiday->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'title' => Input::get('title'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Feriados';
		$this->layout->content = View::make('admin.holiday.list', compact('sort', 'order', 'pag', 'holiday'));
	}

	/**
	 * Display holiday Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Novo Feriado';
		$this->layout->content = View::make('admin.holiday.create');
	}

	/**
	 * Create holiday.
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
			$this->holiday->create($inputs);

			return Redirect::route('admin.holiday');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.holiday.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display holiday Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$holiday = $this->holiday->find($id);

		if (is_null($holiday))
		{
			return Redirect::route('admin.holiday');
		}

		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Editando Feriado #'.$holiday->id.' '.$holiday->title;

		$this->layout->content = View::make('admin.holiday.edit', compact('holiday'));
	}

	/**
	 * Update holiday.
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
			$holiday = $this->holiday->find($id);

			if ($holiday)
			{
				$holiday->update($inputs);
			}

			return Redirect::route('admin.holiday');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.holiday.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display holiday Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$holiday = $this->holiday->find($id);

		if (is_null($holiday))
		{
			return Redirect::route('admin.holiday');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este feriado? Esta operação não poderá ser desfeita.');

		$data['holidayData'] = $holiday->toArray();
		$data['holidayArray'] = null;

		foreach ($data['holidayData'] as $key => $value) {
			$data['holidayArray'][Lang::get('holiday.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Deletar Feriado #'.$holiday->id.' '.$holiday->title;
		$this->layout->content = View::make('admin.holiday.delete', $data);
	}

	/**
	 * Delete holiday.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->holiday->find($id)->delete();

		Session::flash('success', 'Feriado excluído com sucesso.');

		return Redirect::route('admin.holiday');
	}

}
