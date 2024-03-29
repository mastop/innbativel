<?php

class XmlServerController extends BaseController {

	function getCriteo()
	{
		$now = date('Y-m-d H:i:s');
		$data['offers'] =
		DB::select('SELECT 	o.id, d.name AS destiny, o.slug, o.starts_on, o.ends_on, o.cover_img, op.price_original, op.price_with_discount, op.percent_off, op.max_qty, op.voucher_validity_end, p.first_name, p.last_name,
						(
						SELECT COUNT( v.id )
						FROM vouchers AS v
						LEFT JOIN orders AS ord ON v.order_id = ord.id
						WHERE v.offer_option_id = op.id AND v.status =  "pago" AND ord.status =  "pago"
						) AS sold_qty
					FROM offers AS o
					LEFT JOIN offers_options AS op ON o.id = op.offer_id
					LEFT JOIN profiles AS p ON o.partner_id = p.user_id
					LEFT JOIN destinies AS d ON o.destiny_id = d.id
					-- WHERE o.starts_on < ? AND o.ends_on > ?
					GROUP BY o.id
					ORDER BY o.display_order, op.id ASC');

		// sd($results);

		  return Response::make(View::make('xml.criteo', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
	}

	function getVoucherId($voucher){
	    $voucher_id = explode('-', $voucher, 1);
	    return $voucher_id[0];
	}

	function postSnowlandValida(){
		$body = file_get_contents('php://input');
		$xml = simplexml_load_string($body);

		if(!property_exists($xml, 'api-key')){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 1,
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(!property_exists($xml, 'voucher')){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 2,
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$api_key = $xml->{'api-key'};
		$voucher_code = $xml->{'voucher'};
		$voucher_id = $this->getVoucherId($voucher_code);

		if(User::where('api_key', $api_key)->count() == 0){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 2,
				'voucher' => $voucher_code,
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$voucher = Voucher::with(['offer_option', 'order'])
						  ->where('id', $voucher_id)
						  ->get()
						  ->toArray();
		// return $voucher;
		if(empty($voucher)){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 4,
				'voucher' => $voucher_code,
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(strpos($voucher[0]['offer_option']['title'], 'Adulto') !== false || strpos($voucher[0]['offer_option']['title'], 'adulto') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Adulto') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'adulto') !== false){
			$adultos = 1;
			$criancas = 0;
		}
		else if(strpos($voucher[0]['offer_option']['title'], 'Criança') !== false || strpos($voucher[0]['offer_option']['title'], 'criança') !== false || strpos($voucher[0]['offer_option']['title'], 'Crianca') !== false || strpos($voucher[0]['offer_option']['title'], 'crianca') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Criança') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'criança') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Crianca') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'crianca') !== false){
			$adultos = 0;
			$criancas = 1;
		}
		else{
			$adultos = 0;
			$criancas = 0;
			$data['result'] = [
				'valido' => 'false',
				'erro' => 3,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(date('Y-m-d') < $voucher[0]['offer_option']['voucher_validity_start']){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 8,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(date('Y-m-d') > $voucher[0]['offer_option']['voucher_validity_end']){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 9,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if($voucher[0]['order']['status'] != 'pago'){
			if($voucher[0]['order']['status'] == 'pendente'){
				$data['result'] = [
					'valido' => 'false',
					'erro' => 6,
					'voucher' => $voucher_code,
					'final-de-semana' => 'true',
					'adultos' => $adultos,
					'criancas' => $criancas,
					'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
				];
			}
			else{
				$data['result'] = [
					'valido' => 'false',
					'erro' => 7,
					'voucher' => $voucher_code,
					'final-de-semana' => 'true',
					'adultos' => $adultos,
					'criancas' => $criancas,
					'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
				];
			}

			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if($voucher[0]['used']){
			$data['result'] = [
				'valido' => 'false',
				'erro' => 5,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$data['result'] = [
			'valido' => 'true',
			'voucher' => $voucher_code,
			'final-de-semana' => 'true',
			'adultos' => $adultos,
			'criancas' => $criancas,
			'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
		];
		return Response::make(View::make('xml.snowland_valida', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));

	}

	function postSnowlandUtiliza(){
		$body = file_get_contents('php://input');
		$xml = simplexml_load_string($body);

		if(!property_exists($xml, 'api-key')){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 1,
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(!property_exists($xml, 'voucher')){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 2,
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$api_key = $xml->{'api-key'};
		$voucher_code = $xml->{'voucher'};
		$voucher_id = $this->getVoucherId($voucher_code);

		if(User::where('api_key', $api_key)->count() == 0){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 2,
				'voucher' => $voucher_code,
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$voucher = Voucher::with(['offer_option', 'order'])
						  ->where('id', $voucher_id)
						  ->get()
						  ->toArray();
		// return $voucher;
		if(empty($voucher)){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 4,
				'voucher' => $voucher_code,
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(strpos($voucher[0]['offer_option']['title'], 'Adulto') !== false || strpos($voucher[0]['offer_option']['title'], 'adulto') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Adulto') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'adulto') !== false){
			$adultos = 1;
			$criancas = 0;
		}
		else if(strpos($voucher[0]['offer_option']['title'], 'Criança') !== false || strpos($voucher[0]['offer_option']['title'], 'criança') !== false || strpos($voucher[0]['offer_option']['title'], 'Crianca') !== false || strpos($voucher[0]['offer_option']['title'], 'crianca') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Criança') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'criança') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'Crianca') !== false || strpos($voucher[0]['offer_option']['subtitle'], 'crianca') !== false){
			$adultos = 0;
			$criancas = 1;
		}
		else{
			$adultos = 0;
			$criancas = 0;
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 3,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(date('Y-m-d') < $voucher[0]['offer_option']['voucher_validity_start']){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 8,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if(date('Y-m-d') > $voucher[0]['offer_option']['voucher_validity_end']){
			$data['result'] = [
				'utilizado' => 'false',
				'erro' => 9,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if($voucher[0]['order']['status'] != 'pago'){
			if($voucher[0]['order']['status'] == 'pendente'){
				$data['result'] = [
					'utilizado' => 'false',
					'erro' => 6,
					'voucher' => $voucher_code,
					'final-de-semana' => 'true',
					'adultos' => $adultos,
					'criancas' => $criancas,
					'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
				];
			}
			else{
				$data['result'] = [
					'utilizado' => 'false',
					'erro' => 7,
					'voucher' => $voucher_code,
					'final-de-semana' => 'true',
					'adultos' => $adultos,
					'criancas' => $criancas,
					'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
				];
			}

			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		if($voucher[0]['used']){
			$data['result'] = [
				'utilizado' => 'true',
				'erro' => 5,
				'voucher' => $voucher_code,
				'final-de-semana' => 'true',
				'adultos' => $adultos,
				'criancas' => $criancas,
				'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
			];
			return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
		}

		$voucher_atualiza = Voucher::find($voucher[0]['id']);
		$voucher_atualiza->used = true;
		$voucher_atualiza->save();

		$data['result'] = [
			'utilizado' => 'false',
			'voucher' => $voucher_code,
			'final-de-semana' => 'true',
			'adultos' => $adultos,
			'criancas' => $criancas,
			'nome' => $voucher[0]['order']['first_name'].' '.$voucher[0]['order']['last_name'],
		];
		return Response::make(View::make('xml.snowland_utiliza', $data), 200, array('Content-Type' => 'application/xml; charset=UTF-8'));

	}

}
