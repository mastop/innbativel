<?php
class OffersOptionsTableSeeder extends DatabaseSeeder
{
  public function run()
  {

	$offers_options = [
	  [
		'price_original' => 1498.00,
		'price_with_discount' => 696.00,
		'percent_off' => 54,
		'offer_id' => 2001,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 640.00,
		'price_with_discount' => 299.00,
		'percent_off' => 53,
		'offer_id' => 2002,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1200.00,
		'price_with_discount' => 600.00,
		'percent_off' => 50,
		'offer_id' => 2003,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 400.00,
	  ],
	  [
		'price_original' => 2498.00,
		'price_with_discount' => 999.00,
		'percent_off' => 60,
		'offer_id' => 2004,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 2798.00,
		'price_with_discount' => 1099.00,
		'percent_off' => 61,
		'offer_id' => 2005,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1392.00,
		'price_with_discount' => 596.00,
		'percent_off' => 57,
		'offer_id' => 2006,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 1392.00,
		'price_with_discount' => 696.00,
		'percent_off' => 50,
		'offer_id' => 2007,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 3598.00,
		'price_with_discount' => 1499.00,
		'percent_off' => 58,
		'offer_id' => 2008,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 100.00,
	  ],
	  [
		'price_original' => 790.00,
		'price_with_discount' => 380.00,
		'percent_off' => 58,
		'offer_id' => 2009,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 300.00,
	  ],
	  [
		'price_original' => 1200.00,
		'price_with_discount' => 600.00,
		'percent_off' => 50,
		'offer_id' => 2009,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 400.00,
	  ],
	  [
		'price_original' => 600.00,
		'price_with_discount' => 300.00,
		'percent_off' => 50,
		'offer_id' => 2009,
		'title' => 'Teste',
		'subtitle' => 'Teste',
		'min_qty' => 10,
		'max_qty' => 100,
		'voucher_validity_start' => date('Y-m-d H:i:s',strtotime("-1 days")),
		'voucher_validity_end' => date('Y-m-d H:i:s',strtotime("+30 days")),
		'transfer' => 200.00,
	  ],
	];

	foreach ($offers_options as $offer_option)
	{
	  OfferOption::create($offer_option);
	}
  }
}
