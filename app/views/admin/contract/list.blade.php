@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de contratos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.contract.create') }}" title="Criar contrato" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.contract')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::number('id')->class('input-medium')->placeholder('ID')->label('ID') }}
			{{ Former::select('consultant_id', 'Consultor')
	        	->addOption('', null)
				->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.id', 5), 'name', 'id')
	        }}
			{{ Former::select('partner_id', 'Empresa')
	        	->addOption('', null)
				->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user.user_id')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.id', 9), 'name', 'id')
	        }}
			{{ Former::select('is_signed', 'Assinado?')
	        	->addOption('', null)
	        	->addOption('Sim', '1')
	        	->addOption('Não', '0')
	        }}
	        {{ Former::select('is_sent', 'Enviado?')
	        	->addOption('', null)
	        	->addOption('Sim', '1')
	        	->addOption('Não', '0')
	        }}
	        {{ Former::date('created_at_begin')->class('input-medium')->placeholder('Data criação início')->label('Data criação início') }}
			{{ Former::date('created_at_end')->class('input-medium')->placeholder('Data criação fim')->label('Data criação fim') }}
			{{ Former::date('signed_at_begin')->class('input-medium')->placeholder('Data assinatura início')->label('Data assinatura início') }}
			{{ Former::date('signed_at_end')->class('input-medium')->placeholder('Data assinatura fim')->label('Data assinatura fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.contract')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->addOption('5', '5')
	        	->addOption('10', '10')
	        	->addOption('25', '25')
	        	->addOption('50', '50')
	        	->addOption('100', '100')
	        }}
	        </div>
			{{ Former::hidden('sort', $sort) }}
			{{ Former::hidden('order', $order) }}
			{{ Former::close() }}
		</div>
	</div>
	{{ Table::open() }}
	{{ Table::headers('ID', 'Consultor INNBatível', 'Empresa', 'Nome fantasia', 'Representante legal', 'Assinado?', 'Enviado?', 'Criado em', 'Assinado em', 'Ações') }}
	{{ Table::body($contract)
		->ignore(['partner_id', 'consultant_id', 'company_name', 'cnpj', 'trading_name', 'address', 'complement', 'neighborhood', 'zip', 'city', 'state', 'agent1_name', 'agent1_cpf', 'agent1_telephone', 'agent2_name', 'agent2_cpf', 'agent2_telephone', 'bank_name', 'bank_number', 'bank_holder', 'bank_agency', 'bank_account', 'bank_financial_email', 'is_signed', 'is_sent', 'initial_term', 'final_term', 'restriction', 'has_scheduling', 'sched_contact', 'sched_max_date', 'sched_dates', 'sched_min_antecedence', 'n_people', 'features', 'rules', 'clauses', 'ip', 'signed_at', 'created_at', 'updated_at', 'partner', 'consultant'])
		->consultantt(function($body) {
			// print_r($body['consultant']);
			if(isset($body['consultant'])){
				return $body['consultant']['first_name'].' '.$body['consultant']['last_name'];
			}
			return '--';
		})
		->partnerr(function($body) {
			// print_r($body['partner']);
			if(isset($body['partner'])){
				return $body['partner']['first_name'].' '.$body['partner']['last_name'];
			}
			return '--';
		})
		->trading_name(function($body) {
			if(isset($body->trading_name)){
				return $body->trading_name;
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
		->is_sent(function($body) {
			if(isset($body->is_sent)){
				return ($body->is_sent == true)?'Sim':'Não';
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
					if($body->is_sent == false){
						return DropdownButton::normal('Ações',
							Navigation::links([
								['Visualizar', route('admin.contract.view', $body['id'])],
								['Imprimir', route('admin.contract.print', $body['id'])],
								['Enviar', route('admin.contract.send', $body['id'])],
								['Editar', route('admin.contract.edit', $body['id'])],
								['Excluir', route('admin.contract.delete', $body['id'])],
							])
						)->pull_right()->split();
					}
					else{
						return DropdownButton::normal('Ações',
							Navigation::links([
								['Visualizar', route('admin.contract.view', $body['id'])],
								['Imprimir', route('admin.contract.print', $body['id'])],
								['Editar', route('admin.contract.edit', $body['id'])],
								['Excluir', route('admin.contract.delete', $body['id'])],
							])
						)->pull_right()->split();
					}
				}
				else{
					return DropdownButton::normal('Ações',
						Navigation::links([
							['Visualizar', route('admin.contract.view', $body['id'])],
							['Imprimir', route('admin.contract.print', $body['id'])],
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
