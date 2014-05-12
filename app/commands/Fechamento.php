<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Fechamento extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fechamento';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fechamento quinzenal e calculo do total das vendas dos parceiros. Calcula todas as transações de vouchers (transactions_vouchers) em aberto, fechando-as, atribuindo uma data de pagamento (payments_partners e payments).';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$payment_id = $this->argument('payment_id');
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
					   WHERE tv.payment_partner_id IS NULL AND pp.total IS NULL;");

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

		$payment = Payment::find($payment_id);

		$crontab = new Crontab;
		$crontab->removeJob($payment->cronjob);

		$this->info('Sucesso');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('payment_id', InputArgument::REQUIRED, 'ID do pagamento.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}