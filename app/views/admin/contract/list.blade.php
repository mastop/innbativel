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
			{{ Former::select('partner_id', 'Parceiro')
	        	->addOption('', null)
				->fromQuery(DB::table('profiles')->select('profiles.first_name AS name', 'profiles.user_id AS id')->leftJoin('role_user', 'profiles.user_id', '=', 'role_user')->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')->where('roles.name', '=', 'parceiro'), 'name', 'id')
	        }}
			{{ Former::text('agent1_name')->class('input-medium')->placeholder('Representante')->label('Representante') }}
			{{ Former::select('is_signed', 'Assinado?')
	        	->addOption('', null)
	        	->addOption('Sim', 1)
	        	->addOption('Não', 0)
	        }}
	        {{ Former::select('is_sent', 'Enviado?')
	        	->addOption('', null)
	        	->addOption('Sim', 1)
	        	->addOption('Não', 0)
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
		->ignore(['id', 'partner_id', 'company_name', 'cnpj', 'trading_name', 'address', 'complement', 'neighborhood', 'zip', 'city', 'state', 'agent1_name', 'agent1_cpf', 'agent1_telephone', 'agent2_name', 'agent2_cpf', 'agent2_telephone', 'bank_name', 'bank_number', 'bank_holder', 'bank_agency', 'bank_account', 'bank_financial_email', 'is_signed', 'is_sent', 'consultant', 'term', 'restriction', 'has_scheduling', 'sched_contact', 'sched_max_date', 'sched_dates', 'sched_min_antecedence', 'n_people', 'details', 'clauses', 'ip', 'signed_at', 'created_at', 'updated_at', 'partner'])
		->image(function($body) {
			if(isset($body->img)){
				return '<img src="'.$body->img.'"/>';
			}
			return '--';
		})
		->acoes(function($body) {
			return DropdownButton::normal('Ações',
				Navigation::links([
					['Editar', route('admin.contract.edit', $body['id'])],
					['Excluir', route('admin.contract.delete', $body['id'])],
				])
			)->pull_right()->split();
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $contract->getFrom() }}</strong> a <strong>{{ $contract->getTo() }}</strong> registros do total de <strong>{{ $contract->getTotal() }}</strong></div>
		{{ $contract->links() }}
	</div>
</div>

@stop
