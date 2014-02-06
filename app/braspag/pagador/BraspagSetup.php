<?php

/**
 * BraspagSetup
 * Contains settings to Braspag class
 *
 * @author Robson Morais (r.morais@isharelife.com.br)
 * @link http://www.isharelife.com.br/
 * @version $ID$
 * @package opensource
 * @copyright Copyright © 2010-2012 iShareLife
 * @license Apache License, Version 2.0
 *
 */

class BraspagSetup {

	const URL_TRANSACTION_HOMOLOGATION = "https://homologacao.pagador.com.br/webservice/pagadorTransaction.asmx?wsdl";
	const URL_ORDER_HOMOLOGATION = "https://homologacao.pagador.com.br/pagador/webservice/pedido.asmx?wsdl";
	const URL_JUSTCLICK_HOMOLOGATION = "https://homologacao.braspag.com.br/services/testenvironment/cartaoprotegido.asmx?wsdl";

	const URL_TRANSACTION = "https://www.pagador.com.br/webservice/pagadorTransaction.asmx?wsdl";

	const URL_ORDER = "https://query.pagador.com.br/webservices/pagador/pedido.asmx?wsdl";
	const URL_JUSTCLICK = "https://cartaoprotegido.braspag.com.br/services/v2/cartaoprotegido.asmx?wsdl";

	const MERCHANT_ID = '{663B1F6B-4B06-4EF0-DAAD-70B14E17FC63}';
	const MERCHANT_KEY = '{00000000-0000-0000-0000-000000000000}';

	const VERSION = '1.0';
}
