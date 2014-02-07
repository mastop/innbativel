<?php

class XmlServerController extends BaseController {

	public function getSaveme()
	{
		// $select = 	[
		// 				'offers.id','offers.destiny', 'offers.saveme_title',
		// 				'offer_option.price_original', 'offers_options.price_with_discount',
		// 				'offers.percent_off', 'offers.saveme_img', 'offers.slug',
		// 				'offers.starts_on', 'offers.ends_on', 'offers.description',
		// 				'offers.general_rules', 'offers_option.rules',
		// 				'offers_saveme.priority', 'saveme.geocode', 'users.name', 'users.site',
		// 				'users.country', 'users.city', 'users.state', 'users.neighborhood',
		// 				'users.number', 'users.complement', 'users.zip', 'users.telephone',
		// 			];

		$now = date('Y-m-d H:i:s');

		$data['offers'] = Offer::with('saveme', 'offer_option', 'partner')->where('starts_on','<', $now)->where('ends_on','>', $now)->orderBy('starts_on', 'asc')->get();
		// $data['offers'] = Offer::with('saveme', 'offer_option', 'partner')->get($select);

		// d($data['offers'][0]->offer_option2);

		return Response::make(View::make('xml.saveme', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
	}

	function getCriteo()
	{
		$now = date('Y-m-d H:i:s');
		$data['offers'] =
		DB::select('SELECT 	o.id, o.destiny, o.saveme_title, o.slug, o.starts_on, o.ends_on, o.cover_img, op.price_original, op.price_with_discount, op.percent_off, op.max_qty, op.voucher_validity_end, p.first_name, p.last_name,
						(
						SELECT SUM( orop.qty )
						FROM orders_offers_options AS orop
						LEFT JOIN orders AS ord ON orop.order_id = ord.id
						WHERE orop.offer_option_id = op.id AND (ord.status =  "aprovado"OR ord.status =  "pago")
						) AS sold_qty
					FROM offers AS o
					LEFT JOIN offers_options AS op ON o.id = op.offer_id
					LEFT JOIN profiles AS p ON o.partner_id = p.user_id
					-- WHERE o.starts_on < ? AND o.ends_on > ?
					GROUP BY o.id
					ORDER BY o.display_order, op.id ASC');

		// sd($results);

		  return Response::make(View::make('xml.criteo', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
	}

}
