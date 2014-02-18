@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Usuários</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.partner.deleted') }}" title="Usuários Excluídos" class="dropdown-toggle navbar-icon"><i class="icon-filter"></i></a>
	            <a href="{{ route('admin.partner.create') }}" title="Criar Usuário" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.partner')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('email')->label('')->class('input-medium')->placeholder('E-mail') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.partner')) }}
			<div class="dataTables_length">
			{{ Former::label('Exibir: ') }}
	        {{ Former::select('pag', 'Exibir')
	        	->label('')
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
{{ Table::headers('ID', 'E-mail', 'Nome', 'Cidade', 'Tipo', 'Criado', 'Ações') }}
{{ Table::body($partner)
	->ignore(['profile', 'roles', 'created_at'])
	->nome(function($partner) {
		if(isset($partner['profile']['first_name']) && isset($partner['profile']['last_name'])) {
			return $partner['profile']['first_name'] .' '. $partner['profile']['last_name'];
		}
		return 'Não cadastrado.';
	})
	->cidade(function($partner) {
		if(isset($partner['profile']['city'])) {
			return $partner['profile']['city'];
		}
		return 'Não cadastrado.';
	})
	->tipo(function($partner) {
		$ret = '';

		foreach ($partner['roles'] as $key => $value) {
			$ret .= '<span class="comma-sep">'. $value['description'] .'</span>';
		}

		return $ret;
	})
	->criado(function($partner) {
		return $partner->created_at->formatLocalized('%d/%m/%Y %H:%I:%S');
	})
	->acoes(function($body) {
		return DropdownButton::normal('Ações',
		  	Navigation::links([
				['Ver', route('admin.partner.view', $body['id'])],
				['Editar', route('admin.partner.edit', $body['id'])],
				['Excluir', route('admin.partner.delete', $body['id'])],
		    ])
		)->pull_right()->split();
	})
}}
{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $partner->getFrom() }}</strong> a <strong>{{ $partner->getTo() }}</strong> registros do total de <strong>{{ $partner->getTotal() }}</strong></div>
		{{ $partner->links() }}
	</div>
</div>
@stop
