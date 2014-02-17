@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'term' => 'required|date',
			'restriction' => 'required',
			'n_people' => 'required|integer',
        ]) }}

        <div class="control-group"><h1>Empresa</h1></div>

        {{ Former::select('partner_id', 'Nome')
				 ->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.name', '=', 'parceiro'), 'name', 'id')
				 ->class('span12')
		}}

		<div class="control-group"><h1>Consultor INNBatível</h1></div>

		{{ Former::select('consultant', 'Nome')
	        	 ->addOption('Terence Plentz', 'Terence Plentz')
	        	 ->addOption('Rodrigo Giannocaro', 'Rodrigo Giannocaro')
	        	 ->addOption('Danilo Konrad', 'Danilo Konrad')
	        	 ->addOption('Fernanda Mendes', 'Fernanda Mendes')
	        	 ->addOption('Marina Gerald', 'Marina Gerald')
	    }}

		<div class="control-group"><h1>Regras do cupom</h1></div>

        {{ Former::date('term', 'Prazo de utilização')->class('span12') }}
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

		<div class="control-group">
			<h1>Detalhamento dos serviços oferecidos</h1>

			Ex hotéis: check-in/check-out, café, meia pensão, all inclusive, categoria apto, taxa de serviço, política criança, cama extra, diária extra<br/>
			Ex passeios: horário de saida, restrições, guia, equipamentos<br/>
			Ex podutos: prazo de entrega, fret<br/>
			Ex gastronomia: bebidas, taxa de serviço
		</div>

       	{{ Former::textarea('details', 'Detalhamento')->class('span12') }}

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
						<td><input type="text" value="" name="opcoes[][opcao]"/></td>
						<td><input type="text" value="" name="opcoes[][preco_original]"/></td>
						<td><input type="text" value="" name="opcoes[][preco_com_desconto]"/></td>
						<td><input type="number" value="" name="opcoes[][percentagem]"/></td>
						<td><input type="text" value="" name="opcoes[][repasse]"/></td>
						<td><input type="number" value="" name="opcoes[][maximo]"/></td>
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
					return false;
				});

				$("#options").on('click', '.remove', function(e) {
					if($('#options tr').length > 1){
						$(this).closest("tr").remove();
					}
					return false;
				});
			</script>
		</div>

		<div class="control-group">
			<h1>Cláusulas</h1>

			<?php
			$config = Configuration::where('name', 'terms')->first();
			echo $config->value;
			?>
		</div>

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop
