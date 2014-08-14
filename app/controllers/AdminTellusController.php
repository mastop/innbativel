<?php

class AdminTellusController extends BaseController {

	/**
	 * Tellus Repository
	 *
	 * @var Tellus
	 */
	protected $tellus;

	/**
	 * Constructor
	 */
	public function __construct(TellUs $tellus)
	{
		/*
		 * Set Tellus Instance
		 */

		$this->tellus = $tellus;

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
		$tellus = $this->tellus;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'destiny', 'partner_name', 'travel_date']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$tellus = $tellus->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('destiny')) {
			$tellus = $tellus->where('destiny', 'like', '%'. Input::get('destiny') .'%');
		}

		if (Input::has('partner_name')) {
			$tellus = $tellus->where('partner_name', 'like', '%'. Input::get('partner_name') .'%');
		}

		if (Input::has('depoiment')) {
			$tellus = $tellus->where('depoiment', 'like', '%'. Input::get('depoiment') .'%');
		}

		if (Input::has('date_start')) {
			$tellus = $tellus->where('travel_date', '>=', Input::get('date_start'));
		}

		if (Input::has('date_end')) {
			$tellus = $tellus->where('travel_date', '<=', Input::get('date_end'));
		}

		/*
		 * Finally Obj
		 */
		$tellus = $tellus->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'destiny' => Input::get('destiny'),
			'parnter_name' => Input::get('parnter_name'),
			'depoiment' => Input::get('depoiment'),
			'date_start' => Input::get('date_start'),
			'date_end' => Input::get('date_end'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.tellus.list', compact('sort', 'order', 'pag', 'tellus'));
	}

	/**
	 * Display Tellus Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tellus.create');
	}

	/**
	 * Create Tellus.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'destiny' => 'required',
            'img' => 'required|image',
            'travel_date' => 'required|date_format:d/m/Y',
            'depoiment' => 'required|min:30',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes()) {
            $img = $inputs['img'];
            $directory = 'conte_pra_gente';
            $img_name = $img->getClientOriginalName();

            $inputs['img'] = $img_name;
            $inputs['approved'] = false;

            $id = $this->tellus->create($inputs)->id;

            $img_url = ImageUpload::upload($img, $directory, $id, $img_name);

			return Redirect::route('admin.tellus');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.tellus.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Tellus Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$tellus = $this->tellus->find($id);

		if (is_null($tellus))
		{
			return Redirect::route('admin.tellus');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tellus.edit', compact('tellus'));
	}

	/**
	 * Update Tellus.
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
        	'name' => 'required|min:5',
            'email' => 'required|email',
            'destiny' => 'required',
            'travel_date' => 'required|date_format:d/m/Y',
            'depoiment' => 'required|min:30',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$tellus = $this->tellus->find($id);

			if ($tellus)
			{
				if(!is_null($inputs['img'])){
					$img = $inputs['img'];
		            $directory = 'conte_pra_gente';
		            $img_name = $img->getClientOriginalName();
		            $img_url = ImageUpload::upload($img, $directory, $id, $img_name);
		            $inputs['img'] = $img_name;
				}

	            $tellus->update($inputs);
			}

			return Redirect::route('admin.tellus');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.tellus.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Tellus Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$tellus = $this->tellus->find($id);

		if (is_null($tellus))
		{
			Session::flash('error', 'Depoimento inválido.');
			return Redirect::back();
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este depoimento do Conte pra Gente? Esta operação não poderá ser desfeita.');

		$data['tellusData'] = $tellus->toArray();
		$data['tellusArray'] = null;

		foreach ($data['tellusData'] as $key => $value) {
			$data['tellusArray'][Lang::get('tellus.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.tellus.delete', $data);
	}

	/**
	 * Delete Tellus.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->tellus->find($id)->delete();

		Session::flash('success', 'Depoimento do Conte pra Gente excluído com sucesso.');

		return Redirect::route('admin.tellus');
	}

	public function getClearfield($id, $field)
	{
		$tellus = $this->tellus->find($id);

		if (is_null($tellus) || !isset($tellus))
		{
			Session::flash('error', 'Depoimento inválido.');
			return Redirect::back();
		}

		$toDelete = $tellus->{$field};

		$path = public_path() . $toDelete;
		if (File::exists($path)) {
			File::delete($path);
		}

		$tellus->{$field} = null;
		$tellus->save();

		Session::flash('success', 'O campo '.$field.' pode ser editado agora.');

		return Redirect::route('admin.tellus.edit', $id);
	}

	public function getSort(){
		/*
		 * Obj
		 */
		$tellusObj = $this->tellus;

		/*
		 * Finally Obj
		 */
		$tellus = $tellusObj->orderBy('display_order', 'asc')
						    ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.tellus.sort', compact('tellus'));
	}

	public function postSort(){
		$tellus = Input::get('tellus');

		foreach ($tellus as $display_order => $id) {
			$tu = Tellus::find($id);
			$tu->display_order = $display_order;
			$tu->save();
		}

		return Redirect::route('admin.tellus.sort');
	}

	public function getApprove($id, $approved){
		$tellus = $this->tellus->find($id);
		if (is_null($tellus) || !isset($tellus))
		{
			Session::flash('error', 'Depoimento inválido.');
			return Redirect::back();
		}
		$tellus->approved = $approved;
		$tellus->save();
		
		Session::flash('success', 'Depoimento '.(($approved == 1)?'aprovado':'desaprovado').' com sucesso.');

		return Redirect::back();
	}

}
