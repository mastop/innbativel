@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Parceiros Excluídos/Inativos</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.partner') }}" title="Parceiros Ativos" class="dropdown-toggle navbar-icon"><i class="icon-partner"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.partner.deleted')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('email')->class('input-medium')->placeholder('E-mail') }}
			{{ Former::submit('Enviar') }}
			{{ Former::link('Limpar Filtros', route('admin.partner')) }}
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
{{ Table::headers('ID', 'E-mail', 'Nome', 'Razão Social', 'Cidade', 'Criado', 'Ações') }}
{{ Table::body($partner)
	->ignore(['profile', 'roles', 'created_at'])
	->nome(function($partner) {
		if(isset($partner['profile']['first_name']) || isset($partner['profile']['last_name'])) {
			return $partner['profile']['first_name'] .' '. $partner['profile']['last_name'];
		}
		return 'Não cadastrado.';
	})
    ->razao(function($partner) {
        if(isset($partner['profile']['company_name'])) {
            return $partner['profile']['company_name'];
        }
        return 'Não cadastrado.';
    })
	->cidade(function($partner) {
		if(isset($partner['profile']['city'])) {
			return $partner['profile']['city'];
		}
		return 'Não cadastrado.';
	})
	->criado(function($partner) {
		return $partner->created_at->formatLocalized('%d/%m/%Y %H:%I:%S');
	})
	->acoes(function($body) {
		return DropdownButton::normal('Ações',
		  	Navigation::links([
				['Ver', route('admin.partner.deleted.view', $body['id'])],
				['Editar', route('admin.partner.deleted.edit', $body['id'])],
				['Reativar Parceiro', route('admin.partner.deleted.restore', $body['id'])],
				['Excluir Permanentemente', route('admin.partner.deleted.delete', $body['id'])],
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
