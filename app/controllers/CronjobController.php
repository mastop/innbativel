<?php

class CronjobController extends BaseController {

	public function getFechamentoQuinzenal($payment_id)
	{
    try {
      $payment = Payment::find($payment_id);

      if($payment->is_sales_close){
        $error = 1;
        $message = 'Cron job duplicado: o fechamento do periodo (payments id = '.$payment_id.') já havia sido feito';
        return Response::json(['error' => $error, 'message' => $message]);
      }
      else{
        $payment->is_sales_close = true;
        $payment->save();

        // INSERINDO BOLETOS NÃO PAGOS EM transactions
        $boleto_from = date('Y-m-d H:i:s', strtotime($payment->sales_from . ' - 5 day'));
        $boleto_to = date('Y-m-d H:i:s', strtotime($payment->sales_to . ' - 5 day'));
        DB::statement("INSERT INTO transactions (order_id, status, created_at) 
                        SELECT o.id AS order_id, 'pagamento' AS status, o.created_at AS created_at 
                        FROM orders o
                        WHERE o.created_at >= '".$boleto_from."' AND o.created_at <= '".$boleto_to."' AND o.status = 'pendente' AND o.payment_terms = 'Boleto';");

        // INSERINDO pagamentos_empresas COM EMPRESAS QUE TIVERAM TRANSAÇÕES NO ÚLTIMO PERÍODO DE VENDAS
        DB::statement("INSERT INTO payments_partners (payment_id, partner_id) 
                        SELECT ".$payment_id." AS payment_id, o.partner_id AS partner_id 
                        FROM transactions_vouchers tv
                        LEFT JOIN vouchers v ON v.id = tv.voucher_id
                        LEFT JOIN offers_options oo ON oo.id = v.offer_option_id
                        LEFT JOIN offers o ON o.id = oo.offer_id
                        LEFT JOIN profiles p ON p.user_id = o.partner_id
                        WHERE tv.payment_partner_id IS NULL 
                        GROUP BY o.partner_id
                        ORDER BY p.first_name;");

        // ATUALIZANDO transacoes COM o id de pagamentos_empresas
        DB::statement("UPDATE transactions_vouchers tv
                        LEFT JOIN vouchers v ON v.id = tv.voucher_id
                        LEFT JOIN offers_options oo ON oo.id = v.offer_option_id
                        LEFT JOIN offers o ON o.id = oo.offer_id
                        LEFT JOIN payments_partners pp ON pp.partner_id = o.partner_id
                       SET tv.payment_partner_id = pp.id
                       WHERE tv.payment_partner_id IS NULL AND pp.payment_id = ".$payment_id.";");

        // CALCULANDO pagamentos_empresas.total dos pagamentos que acabaram de ser fechados
        DB::statement("UPDATE payments_partners pp
                        SET pp.total = 
                          (SELECT SUM(IF(tv.status = 'pagamento', oo.transfer, -1*oo.transfer)) AS total
                          FROM transactions_vouchers tv
                          LEFT JOIN vouchers v ON v.id = tv.voucher_id 
                          LEFT JOIN offers_options oo ON oo.id = v.offer_option_id 
                          WHERE tv.payment_partner_id = pp.id
                          GROUP BY tv.payment_partner_id)
                        WHERE pp.total IS NULL;");

        $error = 0;
        return Response::json(['error' => $error]);
      }

      $crontab = new Crontab;
      $crontab->removeJob($payment->cronjob);
    } catch (Exception $e) {
      $error = 2;
      $message = 'Erro de exceção: '.$e->getMessage();
      return Response::json(['error' => $error, 'message' => $message]);
    }
	}
}
