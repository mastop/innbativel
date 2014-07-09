<?php

class AdminCouponController extends BaseController {

	/**
	 * Discount Coupon Repository
	 *
	 * @var Discount Coupon
	 */
	protected $coupon;

	/**
	 * Constructor
	 */
	public function __construct(DiscountCoupon $coupon)
	{
		/*
		 * Set Discount Coupon Instance
		 */

		$this->coupon = $coupon;

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
		$coupon = $this->coupon;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['display_code', 'value', 'starts_on', 'ends_on', 'qty', 'qty_used']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('display_code')) {
			$coupon = $coupon->where('display_code', 'LIKE', '%'. Input::get('display_code') .'%');
		}

		if (Input::has('starts_on')) {
			$coupon = $coupon->where('starts_on', '>=', Input::get('starts_on'));
		}

		if (Input::has('ends_on')) {
			$coupon = $coupon->where('ends_on', '<=', Input::get('ends_on'));
		}

		/*
		 * Finally Obj
		 */
		$coupon = $coupon->with(['user', 'offer'])->orderBy($sort, $order)
		->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'display_code' => Input::get('display_code'),
			'starts_on' => Input::get('starts_on'),
			'ends_on' => Input::get('ends_on'),
		]);

		// ->get()->toArray();
		// print('<pre>');
		// print_r($coupon);
		// print('</pre>'); die();

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Cupons de Desconto';
		$this->layout->content = View::make('admin.coupon.list', compact('sort', 'order', 'pag', 'coupon'));
	}

	/**
	 * Display Discount Coupon Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Novo Cupom de Desconto';
		$this->layout->content = View::make('admin.coupon.create');
	}

	/**
	 * Create Discount Coupon.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::except('user_email');

		$rules = [
        	'display_code' => 'required|unique:discount_coupons',
        	'value' => 'required|numeric',
        	'qty' => 'required|integer',
            'starts_on' => 'required',
            'ends_on' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
            $user = User::where('email', '=', Input::get('user_email'))->first();
			$inputs['offer_id'] = ($inputs['offer_id'] != '')?$inputs['offer_id']:null;
			$inputs['user_id'] = (!is_null($user))?$user->id:null;
			$this->coupon->create($inputs);

			return Redirect::route('admin.coupon')->with('success', 'Cupom criado com sucesso');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.coupon.create')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Discount Coupon Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$coupon = $this->coupon->find($id);

		if (is_null($coupon))
		{
			return Redirect::route('admin.coupon');
		}

		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Editando Cupom de Desconto '.$coupon->display_code;
		$this->layout->content = View::make('admin.coupon.edit', compact('coupon'));
	}

	/**
	 * Update Discount Coupon.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::except('user_email');

        $rules = [
            'display_code' => 'required|unique:discount_coupons',
        	'qty' => 'required|integer',
            'starts_on' => 'required',
            'ends_on' => 'required',
        ];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$coupon = $this->coupon->find($id);

			if ($coupon)
			{
                $user = User::where('email', '=', Input::get('user_email'))->first();
                $inputs['user_id'] = (!is_null($user))?$user->id:null;
                $inputs['offer_id'] = ($inputs['offer_id'] != '')?$inputs['offer_id']:null;
				$coupon->update($inputs);
			}

			return Redirect::route('admin.coupon')->with('success', 'Cupom de Desconto atualizado com sucesso');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.coupon.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Discount Coupon Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$coupon = $this->coupon->find($id);

		if (is_null($coupon))
		{
			return Redirect::route('admin.coupon');
		}

		Session::flash('error', 'Você tem certeza que deleja desativar este cupom de desconto? Esta operação não poderá ser desfeita.');

		$data['couponData'] = $coupon->toArray();
		$data['couponArray'] = null;

		foreach ($data['couponData'] as $key => $value) {
			$data['couponArray'][Lang::get('coupon.'. $key)] = isset($value)?$value:'-';
		}

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Desativar Cupom de Desconto';

		$this->layout->content = View::make('admin.coupon.delete', $data);
	}

	/**
	 * Delete Discount Coupon.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->coupon->find($id)->delete();

		Session::flash('success', 'Cupom de desconto desativado com sucesso.');

		return Redirect::route('admin.coupon');
	}

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function anyDeleted()
	{
		/*
		 * Obj
		 */
		$coupon = $this->coupon->onlyTrashed();

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['display_code', 'value', 'starts_on', 'ends_on', 'qty', 'qty_used']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('display_code')) {
			$coupon = $coupon->where('display_code', 'LIKE', '%'. Input::get('display_code') .'%');
		}

		if (Input::has('starts_on')) {
			$coupon = $coupon->where('starts_on', '>=', Input::get('starts_on'));
		}

		if (Input::has('ends_on')) {
			$coupon = $coupon->where('ends_on', '<=', Input::get('ends_on'));
		}

		/*
		 * Finally Obj
		 */
		$coupon = $coupon->with(['user', 'offer'])->orderBy($sort, $order)
		->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'display_code' => Input::get('display_code'),
			'starts_on' => Input::get('starts_on'),
			'ends_on' => Input::get('ends_on'),
		]);

		// ->get()->toArray();
		// print('<pre>');
		// print_r($coupon);
		// print('</pre>'); die();

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Cupons de Desconto Desativados';
		$this->layout->content = View::make('admin.coupon.deleted.list', compact('sort', 'order', 'pag', 'coupon'));
	}

	public function getDeletedRestore($id)
	{
		$coupon = $this->coupon->onlyTrashed()->find($id);

		if (is_null($coupon))
		{
			return Redirect::route('admin.coupon.deleted');
		}

		Session::flash('error', 'Você tem certeza que deleja reativar este cupom de desconto?');

		$data['couponData'] = $coupon->toArray();
		$data['couponArray'] = null;
		$blackList = ['deleted_at'];

		foreach ($data['couponData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['couponArray'][Lang::get('coupon.'. $key)] = isset($value)?$value:'-';
			}
		}
        $this->layout->page_title = 'Reativar Cupom '.$coupon->display_code;
		$this->layout->content = View::make('admin.coupon.deleted.restore', $data);
	}

	public function postDeletedRestore($id)
	{
		$this->coupon->onlyTrashed()->find($id)->restore();

		Session::flash('success', 'Cupom de desconto reativado com sucesso.');

		return Redirect::route('admin.coupon.deleted');
	}

}
