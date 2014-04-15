@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de depoimentos do Conte pra Gente</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.tellus.create') }}" title="Criar Depoimento" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.tellus.sort') }}" title="Ordenar Depoimentos" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.tellus')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('name')->class('input-medium')->placeholder('Nome')->label('Nome') }}
			{{ Former::text('destiny')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::text('partner_name')->class('input-medium')->placeholder('Parceiro')->label('Parceiro') }}
			{{ Former::text('depoiment')->class('input-medium')->placeholder('Depoimento')->label('Depoimetno') }}
			{{ Former::date('date_start')->class('input-medium')->placeholder('Data inicial')->label('Data da inicial') }}
			{{ Former::date('date_end')->class('input-medium')->placeholder('Data da final')->label('Data da final') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.tellus')) }}
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
	{{ Table::headers('Nome', 'Destino', 'Parceiro', 'Data da viagem', 'Depoimento', 'Ordem de exibição', 'Imagem', 'Aprovado?', 'Ações') }}
	{{ Table::body($tellus)
		->ignore(['id', 'img', 'approved', 'created_at', 'updated_at'])
		->image(function($body) {
			if(isset($body->img)){
				return '<a href="'.$body->img.'">Link para a imagem</a>';
			}
			return '--';
		})
		->approvedd(function($body) {
			return ($body['approved'] == true)?'Sim':'Não';
		})
		->acoes(function($body) {
			if($body['approved'] == true){
				return DropdownButton::normal('Ações',
					Navigation::links([
						['Desaprovar', route('admin.tellus.approve', ['id' => $body['id'], 'approved' => 0])],
						['Editar', route('admin.tellus.edit', $body['id'])],
						['Excluir', route('admin.tellus.delete', $body['id'])],
					])
				)->pull_right()->split();
			}
			else{
				return DropdownButton::normal('Ações',
					Navigation::links([
						['Aprovar', route('admin.tellus.approve', ['id' => $body['id'], 'approved' => 1])],
						['Editar', route('admin.tellus.edit', $body['id'])],
						['Excluir', route('admin.tellus.delete', $body['id'])],
					])
				)->pull_right()->split();
			}
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $tellus->getFrom() }}</strong> a <strong>{{ $tellus->getTo() }}</strong> registros do total de <strong>{{ $tellus->getTotal() }}</strong></div>
		{{ $tellus->links() }}
	</div>
</div>

@stop
