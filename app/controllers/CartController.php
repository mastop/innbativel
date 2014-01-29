<?php

class CartController extends BaseController {

	public function getIndex()
	{
		Session::put('cart', [
            [
			    'id' => 1,
			    'name' => 'Juicy Picnic Hamper',
			    'price' => '12000',
			    'quantity' => 1
            ],
            [
			    'id' => 1,
			    'name' => 'Juicy Picnic Hamper',
			    'price' => '12000',
			    'quantity' => 1
            ],
		]);

		return Redirect::route('home');
	}

}
