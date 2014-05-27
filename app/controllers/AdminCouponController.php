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

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

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

		$this->layout->content = View::make('admin.coupon.create');
	}

	/**
	 * Create Discount Coupon.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		$inputs = Input::all();

		$rules = [
        	'display_code' => 'required',
        	'value' => 'required|numeric',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$inputs['offer_id'] = ($inputs['offer_id'] != '')?$inputs['offer_id']:null;
			$inputs['user_id'] = ($inputs['user_id'] != '')?$inputs['user_id']:null;
			$this->coupon->create($inputs);

			return Redirect::route('admin.coupon');
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
		$inputs = Input::all();

		$rules = [
        	'name' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$coupon = $this->coupon->find($id);

			if ($coupon)
			{
				$coupon->update($inputs);
			}

			return Redirect::route('admin.coupon');
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

		Session::flash('error', 'Você tem certeza que deleja excluir este cupom de desconto? Esta operação não poderá ser desfeita.');

		$data['couponData'] = $coupon->toArray();
		$data['couponArray'] = null;

		foreach ($data['couponData'] as $key => $value) {
			$data['couponArray'][Lang::get('coupon.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

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

		Session::flash('success', 'Cupom de desconto excluído com sucesso.');

		return Redirect::route('admin.coupon');
	}

}
