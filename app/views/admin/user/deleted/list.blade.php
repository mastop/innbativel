@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Usuários Excluídos/Inativos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.user') }}" title="Usuários Ativos" class="dropdown-toggle navbar-icon"><i class="icon-user"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.user.deleted')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.user')) }}
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
{{ Table::headers('ID', 'E-mail', 'Nome', 'Cidade', 'Tipo', 'Criado', 'Ações') }}
{{ Table::body($user)
	->ignore(['profile', 'roles', 'created_at'])
	->nome(function($user) {
		if(isset($user['profile']['first_name']) || isset($user['profile']['last_name'])) {
			return $user['profile']['first_name'] .' '. $user['profile']['last_name'];
		}
		return 'Não cadastrado.';
	})
	->cidade(function($user) {
		if(isset($user['profile']['city'])) {
			return $user['profile']['city'];
		}
		return 'Não cadastrado.';
	})
	->tipo(function($user) {
		$ret = '';

		foreach ($user['roles'] as $key => $value) {
			$ret .= '<span class="comma-sep">'. $value['description'] .'</span>';
		}

		return $ret;
	})
	->criado(function($user) {
		return $user->created_at->formatLocalized('%d/%m/%Y %H:%I:%S');
	})
	->acoes(function($body) {
		return DropdownButton::normal('Ações',
		  	Navigation::links([
				['Ver', route('admin.user.deleted.view', $body['id'])],
				['Editar', route('admin.user.deleted.edit', $body['id'])],
				['Reativar Usuário', route('admin.user.deleted.restore', $body['id'])],
				['Excluir Permanentemente', route('admin.user.deleted.delete', $body['id'])],
		    ])
		)->pull_right()->split();
	})
}}
{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $user->getFrom() }}</strong> a <strong>{{ $user->getTo() }}</strong> registros do total de <strong>{{ $user->getTotal() }}</strong></div>
		{{ $user->links() }}
	</div>
</div>
@stop
