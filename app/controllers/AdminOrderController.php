<?php

use SebastianBergmann\Money\Currency;
use SebastianBerBRLgmann\Money\Money;
use SebastianBergmann\BRLMoney\IntlFormatter;

class AdminOrderController extends BaseController {

	/**
	 * Order Repository
	 *
	 * @var Order
	 */
	protected $order;

	/**
	 * Construct Instance
	 */
	public function __construct(Order $order)
	{
		/*
		 * Enable Sidebar
		 */

		$this->sidebar = true;

		/*
		 * Enable and Set Actions
		 */

		$this->actions = 'admin.order';

		/*
		 * Models Instance
		 */

		$this->order = $order;
	}

	/**
	 * Display all Users.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$data['orderArray'] = Order::with(['user','offer'])
			->groupBy('orders.id')
			->orderBy('id', 'asc')
			->paginate(10);


		foreach ($data['orderArray'] as &$value) {
			$braspag_order_id = $value->braspag_order_id;
			$id = $value->id;
			$value->braspag_order_id = link_to_route('admin.order.view', $braspag_order_id, ['id'=>$id]);

			// $m = new Money($value->total, new Currency('BRL'));
			// $f = new IntlFormatter('pt_BR');
			// $value->total = $f->format($m);
		}

		$this->layout->content = View::make('admin.order.list', $data);
	}

	public function getView($id)
	{
		$data['orderData'] = $this
			->order
			->findOrFail($id)
			->with([
				'user',
				'offer',
				'discount_coupon',
				'order_offer_option',
			])
			// ->get([
			// 	'',
			// ])
			->first()
			->toArray();

		print('<pre>');
		print_r($data['orderData']);
		print('</pre>');

		// $this->layout->content = View::make('admin.order.view', $data);
	}

	public function getCreate()
	{
		$this->layout->content = View::make('admin.user.create');
	}

	public function postCreate()
	{
		$inputs = Input::all();

		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));

		$rules = [
			'email' => 'required|email|unique:users,email',
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$created = $this->user->create($inputs)->id;

			$inputs['profile']['user_id'] = $created;


			$user = User::find($created);
			$user->profile()->create($inputs['profile']);

			return Redirect::route('admin.user');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.user.create')
			->withInput()
			->withErrors($validation);
	}

	public function getEdit($id)
	{
		$user = $this->user->with('profile')->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		$this->layout->content = View::make('admin.user.edit', compact('user'));
	}

	public function postEdit($id)
	{
		/*
		 * User
		 */
		$inputs = Input::all();

		// if (is_null($inputs['username']) || empty($inputs['username'])) {
		$inputs['username'] = Str::lower(Str::slug(Input::get('email')) . '-' .Str::random(16));
		// }

		$rules = [
			'email' => 'required|email|unique:users,email,'. $id,
        	'profile.cpf' => 'required',
        	'profile.city' => 'required',
        	'profile.state' => 'required',
        	'profile.country' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$user = $this->user->with('profile')->find($id);

			if ($user)
			{
				$user->update($inputs);

				if ($user->profile()->first()) {
					$user->profile()->update($inputs['profile']);
				}
				else
				{
					$user->profile()->create($inputs['profile']);
				}

			}

			return Redirect::route('admin.user.edit', $id);
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.user.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	public function getDelete($id)
	{
		$user = $this->user->find($id);

		if (is_null($user))
		{
			return Redirect::route('admin.user');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir este usuário? Esta operação não poderá ser desfeita.');

		$data['userData'] = $user->toArray();
		$data['userArray'] = null;
		$blackList = ['salt', 'created_at', 'updated_at', 'deleted_at'];

		foreach ($data['userData'] as $key => $value) {
			if (!is_array($value) && !in_array($key, $blackList)) {
				$data['userArray'][Lang::get('user.'. $key)] = $value;
			}
		}

		$this->layout->content = View::make('admin.user.delete', $data);
	}

	public function postDelete($id)
	{
		$this->user->find($id)->delete();

		Session::flash('success', 'Usuário excluído com sucesso.');

		return Redirect::route('admin.user');
	}

}
