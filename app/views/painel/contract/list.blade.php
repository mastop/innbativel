@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de contratos</h6>
	        <div class="nav pull-right">
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('painel.contract')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::number('id')->class('input-medium')->placeholder('ID')->label('ID') }}
			{{ Former::date('signed_at_begin')->class('input-medium')->placeholder('Data assinatura início')->label('Data assinatura início') }}
			{{ Former::date('signed_at_end')->class('input-medium')->placeholder('Data assinatura fim')->label('Data assinatura fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('painel.contract')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        	->select($pag)
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
	{{ Table::open() }}
	{{ Table::headers('ID', 'Consultor INNBatível', 'Representante legal', 'Assinado?', 'Criado em', 'Assinado em', 'Ações') }}
	{{ Table::body($contract)
		->ignore(['partner_id', 'consultant_id', 'company_name', 'cnpj', 'trading_name', 'address', 'complement', 'neighborhood', 'zip', 'city', 'state', 'agent1_name', 'agent1_cpf', 'agent1_telephone', 'agent2_name', 'agent2_cpf', 'agent2_telephone', 'bank_name', 'bank_number', 'bank_holder', 'bank_agency', 'bank_account', 'bank_cpf_cnpj', 'bank_financial_email', 'is_signed', 'is_sent', 'initial_term', 'final_term', 'restriction', 'has_scheduling', 'sched_contact', 'sched_max_date', 'sched_dates', 'sched_min_antecedence', 'n_people', 'features', 'rules', 'clauses', 'ip', 'signed_at', 'created_at', 'updated_at', 'partner', 'consultant'])
		->consultantt(function($body) {
			// print_r($body['consultant']);
			if(isset($body['consultant'])){
				return $body['consultant']['first_name'].' '.$body['consultant']['last_name'];
			}
			return '--';
		})
		->agent(function($body) {
			if(isset($body->agent1_name)){
				return $body->agent1_name;
			}
			return '--';
		})
		->is_signed(function($body) {
			if(isset($body->is_signed)){
				return ($body->is_signed == true)?'Sim':'Não';
			}
			return '--';
		})
		->created_at(function($body) {
			if(isset($body->created_at)){
				return $body->created_at;
			}
			return '--';
		})
		->signed_at(function($body) {
			if(isset($body->signed_at)){
				return ($body->is_signed == true)?$body->signed_at:'--';
			}
			return '--';
		})
		->acoes(function($body) {
				if($body->is_signed == false){
					return DropdownButton::normal('Ações',
						Navigation::links([
							['Visualizar', route('painel.contract.view', $body['id'])],
							['Imprimir', route('painel.contract.print', $body['id']).'" target="about:blank'],
							['Assinar', route('painel.contract.get_sign', $body['id'])],
						])
					)->pull_right()->split();
				}
				else{
					return DropdownButton::normal('Ações',
						Navigation::links([
							['Visualizar', route('painel.contract.view', $body['id'])],
							['Imprimir', route('painel.contract.print', $body['id']).'" target="about:blank'],
						])
					)->pull_right()->split();
				}
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $contract->getFrom() }}</strong> a <strong>{{ $contract->getTo() }}</strong> registros do total de <strong>{{ $contract->getTotal() }}</strong></div>
		{{ $contract->links() }}
	</div>
</div>

@stop
