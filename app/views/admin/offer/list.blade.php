@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Ofertas</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.sort_pre_booking') }}" title="Ordenar Ofertas em Pré-reservas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
	        </div>
		</div>
	</div>

	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.offer')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('id')->class('input-medium')->placeholder('ID')->label('ID') }}
			{{ Former::text('destiny')->class('input-medium')->placeholder('Destino')->label('Destino') }}
			{{ Former::text('title')->class('input-medium')->placeholder('Título')->label('Título') }}
			{{ Former::select('genre_id', 'Gênero')
	        	->addOption('', null)
				->fromQuery(DB::table('genres')->get(['title', 'id']), 'title', 'id')
	        }}
			{{ Former::select('in_pre_booking', 'Em pré-reservas?')
	        	->addOption('', null)
	        	->addOption('Sim', 1)
	        	->addOption('Não', 0)
	        }}
			{{ Former::date('starts_on')->class('input-medium')->placeholder('Data início')->label('Data início') }}
			{{ Former::date('ends_on')->class('input-medium')->placeholder('Data fim')->label('Data fim') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.offer')) }}
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
	{{ Table::headers('ID', 'Título', 'Destino', 'Início', 'Fim', 'Em pré-reservas?', 'Ações') }}
	{{ Table::body($offer)
		->ignore(['destiny', 'partner'])
        ->destiny_id__noreplace__(function($body) {
            return $body->getFullDestinnyAttribute();
        })
        ->in_pre_booking__noreplace__(function($body) {
			return ($body->in_pre_booking == 0)?'Não':'Sim';
		})
        ->starts_on__noreplace__(function($body) {
            $phpdate = strtotime( $body->starts_on );
            return date( 'd/m/Y H:i:s', $phpdate );
		})
        ->ends_on__noreplace__(function($body) {
            $phpdate = strtotime( $body->ends_on );
            return date( 'd/m/Y H:i:s', $phpdate );
		})
		->acoes(function($body) {
			if($body->in_pre_booking == 0){
				return DropdownButton::normal('Ações',
					Navigation::links([
						['Editar', route('admin.offer.edit', $body['id'])],
						['Excluir', route('admin.offer.delete', $body['id'])],
						['Aparecer em pré-reservas', route('admin.offer.in_pre_booking', ['id'=>$body['id'], 'in'=>1])],
						['Ordenar comentários', route('admin.offer.sort_comment', $body['id'])],
					])
				)->pull_right()->split();
			}
			else{
				return DropdownButton::normal('Ações',
					Navigation::links([
						['Editar', route('admin.offer.edit', $body['id'])],
						['Excluir', route('admin.offer.delete', $body['id'])],
						['Não aparecer em pré-reservas', route('admin.offer.in_pre_booking', ['id'=>$body['id'], 'in'=>0])],
						['Ordenar comentários', route('admin.offer.sort_comment', $body['id'])],
					])
				)->pull_right()->split();
			}
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $offer->getFrom() }}</strong> a <strong>{{ $offer->getTo() }}</strong> registros do total de <strong>{{ $offer->getTotal() }}</strong></div>
		{{ $offer->links() }}
	</div>
</div>

@stop
