<?php

class AdminGroupController extends BaseController {

	/**
	 * group Repository
	 *
	 * @var group
	 */
	protected $group;

	/**
	 * Constructor
	 */
	public function __construct(Group $group)
	{
		/*
		 * Set group Instance
		 */

		$this->group = $group;

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
		$group = $this->group;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title', 'url']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'asc' ? 'asc' : 'desc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$group = $group->where('title', 'like', '%'. Input::get('title') .'%');
		}

		/*
		 * Finally Obj
		 */
		$group = $group->orderBy($sort, $order)
					   ->paginate($pag)
					   ->appends([
							'sort' => $sort,
							'order' => $order,
							'pag' => $pag,
							'title' => Input::get('title'),
						]);
		// ->get()->toArray(); print('<pre>'); print_r($group); print('</pre>'); die();

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Grupos de Ofertas';
		$this->layout->content = View::make('admin.group.list', compact('sort', 'order', 'pag', 'group'));
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function getOrder()
	{
		/*
		 * Finally Obj
		 */
		$groups = $this->group
					   ->with(['offer'])
					   ->orderBy('display_order', 'asc')
					   ->get();
		// print('<pre>'); print_r($groups->toArray()); print('</pre>'); die();

		foreach ($groups as $key => &$group) {
			$offer_ids = null;

			foreach ($group->offer as $offer) {
				$offer_ids[] = $offer->id;
			}

			$group->offer_ids = isset($offer_ids) ? implode(',', $offer_ids) : '';
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Popular e Ordenar Grupos de Ofertas';
		$this->layout->content = View::make('admin.group.order', compact('groups'));
	}

	public function postOrder()
	{
		$groups = Input::get('group');
		$group_display_order = 1;

		DB::delete('DELETE FROM offers_groups');

		foreach ($groups as $group_id => $offer_ids) {
			if(isset($offer_ids)){
				$offer_ids = explode(',', $offer_ids);
				$offer_display_order = 1;

				foreach ($offer_ids as $offer_id) {
					$offer = Offer::find($offer_id);
					
					if($offer){
						$offer->group()->attach($group_id, ['display_order' => $offer_display_order]);
						
						$offer->save();

						$offer_display_order++;
					}
				}

				$group = Group::find($group_id);

				if($group){
					$group->display_order = $group_display_order;
					$group->save();

					$group_display_order++;
				}
			}
		}

		Session::flash('success', 'Grupos populados e ordenados com sucesso.');
		return Redirect::route('admin.group.order');
	}

	/**
	 * Display group Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.group.create');
	}

	/**
	 * Create group.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

        $rules = [
            'title' => 'required',
            'url' => 'required',
        ];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
            $inputs['icon'] = ($inputs['icon'] != NULL) ? str_replace('map-icon-', '', $inputs['icon']) : NULL;
			$this->group->create($inputs);

            Session::flash('success', 'Grupo criado com sucesso.');

			return Redirect::route('admin.group');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.group.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display group Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$group = $this->group->find($id);

		if (is_null($group))
		{
			return Redirect::route('admin.group');
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Editando Grupo #'.$group->id.' '.$group->title;
		$this->layout->content = View::make('admin.group.edit', compact('group'));
	}

	/**
	 * Update group.
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
        	'url' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$group = $this->group->find($id);

			if ($group)
			{
                $inputs['icon'] = ($inputs['icon'] != NULL) ? str_replace('map-icon-', '', $inputs['icon']) : NULL;
				$group->update($inputs);
			}
            Session::flash('success', 'Grupo alterado com sucesso.');
			return Redirect::route('admin.group');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.group.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display group Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$group = $this->group->find($id);

		if (is_null($group))
		{
            Session::flash('error', 'Grupo #'.$id.' não encontrado.');
			return Redirect::route('admin.group');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este "grupo"? Esta operação não poderá ser desfeita.');

		$data['groupData'] = $group->toArray();
		$data['groupArray'] = null;

		foreach ($data['groupData'] as $key => $value) {
			$data['groupArray'][Lang::get('group.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Excluir Grupo #'.$group->id.' '.$group->title;
		$this->layout->content = View::make('admin.group.delete', $data);
	}

	/**
	 * Delete group.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->group->find($id)->delete();

		Session::flash('success', '"Grupo" excluído com sucesso.');

		return Redirect::route('admin.group');
	}

}
