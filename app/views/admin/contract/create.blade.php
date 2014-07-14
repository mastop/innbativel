@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'partner_id' => 'required',
        	'agent1_name' => 'required',
        	'agent1_telephone' => 'required',
        	'bank_name' => 'required',
        	'bank_number' => 'required',
        	'bank_holder' => 'required',
        	'bank_agency' => 'required',
        	'bank_account' => 'required',
        	'bank_cpf_cnpj' => 'required',
        	'bank_financial_email' => 'required',
        	'initial_term' => 'required|date',
        	'final_term' => 'required|date',
			'n_people' => 'required|integer',
			'restriction' => 'required',
			'features' => 'required',
			'rules' => 'required',
        ]) }}

        <div class="control-group"><h1>Empresa</h1></div>

        {{ Former::select('partner_id', 'Nome')
				 ->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.name', '=', 'parceiro'), 'name', 'id')
				 ->class('span12')
		}}

		<div class="control-group"><h1>Representantes legais com poderes previstos no Contrato Social</h1></div>

		{{ Former::text('agent1_name', 'Nome representante 1')->class('span12') }}
		{{ Former::text('agent1_cpf', 'CPF representante 1')->class('span12') }}
		{{ Former::text('agent1_telephone', 'Telefone representante 1')->class('span12') }}

		{{ Former::text('agent2_name', 'Nome representante 2')->class('span12') }}
		{{ Former::text('agent2_cpf', 'CPF representante 2')->class('span12') }}
		{{ Former::text('agent2_telephone', 'Telefone representante 2')->class('span12') }}

		<div class="control-group"><h1>Dados Bancários (devem necessariamente ser dados vinculados ao CNPJ e Razão Social acima)</h1></div>

		{{ Former::text('bank_name', 'Nome do banco')->class('span12') }}
		{{ Former::text('bank_number', 'Número do banco')->class('span12') }}
		{{ Former::text('bank_holder', 'Ttular')->class('span12') }}
		{{ Former::text('bank_agency', 'Agência')->class('span12') }}
		{{ Former::text('bank_account', 'Conta')->class('span12') }}
		{{ Former::text('bank_cpf_cnpj', 'CPF ou CNPJ')->class('span12') }}
		{{ Former::text('bank_financial_email', 'E-mail do dpto financeiro')->class('span12') }}

		<div class="control-group"><h1>Regras do cupom</h1></div>

        {{ Former::date('initial_term', 'Prazo inicial de utilização')->class('span12') }}
        {{ Former::date('final_term', 'Prazo final de utilização')->class('span12') }}
        {{ Former::number('n_people', 'Nº de pessoas por cupom')->class('span12') }}
        {{ Former::text('restriction', 'Restrição')->class('span12') }}
		{{ Former::select('has_scheduling', 'Agendamento?')
	        	 ->addOption('Não', 0)
	        	 ->addOption('Sim', 1)
	    }}

		<span id="yes_has_scheaduling">
        	{{ Former::text('sched_contact', 'Telefone, e-mail e/ou site para agendamento')->class('span12') }}
        	{{ Former::text('sched_dates', 'Dias e horários para agendamento')->class('span12') }}
        	{{ Former::date('sched_max_date', 'Data limite para agendamento, se existir')->class('span12') }}
        	{{ Former::text('sched_min_antecedence', 'Antecedência mínima para agendamento')->class('span12') }}
		</span>

		<script type="text/javascript">$('#yes_has_scheaduling').hide()</script>

		<div class="control-group">
			<h1>Detalhamento dos serviços oferecidos</h1>

			Ex hotéis: check-in/check-out, café, meia pensão, all inclusive, categoria apto, taxa de serviço, política criança, cama extra, diária extra<br/>
			Ex passeios: horário de saida, restrições, guia, equipamentos<br/>
			Ex podutos: prazo de entrega, fret<br/>
			Ex gastronomia: bebidas, taxa de serviço
		</div>

       	{{ Former::textarea('features', 'Destaques')->class('span12') }}
       	{{ Former::textarea('rules', 'Regras')->class('span12') }}

		<div class="control-group">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Opção da oferta</th>
						<th>Preço original (R$)</th>
						<th>Preço final (R$)</th>
						<th>Desconto oferecido ao usuário (%)</th>
						<th>Valor repasse por cupom (R$)</th>
						<th>Número máximo de cupons</th>
						<th>Remover</th>
					</tr>
				</thead>
				<tbody id="options">
					<tr>
						<td><input type="text" value="" name="options[title][]"/></td>
						<td><input type="text" value="" name="options[price_original][]" class="money"/></td>
						<td><input type="text" value="" name="options[price_with_discount][]" class="money"/></td>
						<td><input type="number" value="" name="options[percent_off][]"/></td>
						<td><input type="text" value="" name="options[transfer][]" class="money"/></td>
						<td><input type="number" value="" name="options[max_qty][]"/></td>
						<td><button class="remove btn btn-danger">Remover esta opção</button></td>
					</tr>
				</tbody>
			</table>

			<button class="add btn btn-default">Adicionar outra opção</button>

			<script type="text/javascript">
				$(".add").on('click', function(e) {
					var row = $("#options > tr:first-child").clone();
					row.find('input').val('');
					row.insertAfter("#options > tr:last-child");
					$('.money').mask('000.000.000.000.000,00', {reverse: true});
					return false;
				});

				$("#options").on('click', '.remove', function(e) {
					if($('#options tr').length > 1){
						$(this).closest("tr").remove();
					}
					return false;
				});

				$("#has_scheduling").on('change', function(e) {
					var myselect = document.getElementById("has_scheduling");
				    if(myselect.value == 1){
				        $('#yes_has_scheaduling').show();
				    }
				    else{
				        $('#yes_has_scheaduling').hide();
				    }
					return false;
				});
			</script>
		</div>

		<div class="control-group">
			<h1>Cláusulas</h1>

			<?php
			$config = Configuration::where('name', 'clauses')->first();
			echo $config->value;
			?>
		</div>

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

    <script src="{{ asset('assets/vendor/jquery.mask/jquery.mask.min.js') }}"></script>
    <script>
    $(document).ready(function(){
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    });
    </script>

@stop
