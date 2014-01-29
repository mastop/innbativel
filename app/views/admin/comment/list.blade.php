@section('content')

<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Lista de Permissões</h6>
	        <div class="nav pull-right">
	        </div>
		</div>
	</div>
	<div class="datatable-header">
		<div class="dataTables_filter">
			{{ Former::inline_open(route('admin.comment')) }}
			{{ Former::label('Pesquisar: ') }}
			{{ Former::text('comment')->class('input-medium')->placeholder('Comentário')->label('Comentário') }}
			{{ Former::select('offer_id', 'Oferta')
	        	->addOption('', null)
				->fromQuery(DB::table('offers')->select(DB::raw('concat (id," | ",destiny) as id_destiny, id')), 'id_destiny', 'id')
	        }}
	        {{ Former::select('user_id', 'Cliente')
	        	->addOption('', null)
				->fromQuery(DB::table('users')->get(['email', 'id']), 'email', 'id')
	        }}
	        {{ Former::select('approved', 'Aprovado?')
	        	->addOption('', null)
	        	->addOption('Sim', 1)
	        	->addOption('Não', 0)
	        }}
			{{ Former::text('date_start')->class('input-medium')->placeholder('Data inicial')->label('Data inicial') }}
			{{ Former::text('date_ends')->class('input-medium')->placeholder('Data final')->label('Data final') }}
			{{ Former::submit() }}
			{{ Former::link('Limpar Filtros', route('admin.comment')) }}
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
	{{ Table::headers('Comentário', 'Cliente', 'Oferta', 'Data e hora', 'Aprovado', 'Ações') }}
	{{ Table::body($comment)
		->ignore(['id', 'offer_id', 'user_id', 'approved', 'display_order', 'offer', 'user', 'created_at', 'updated_at'])
		->userr(function($body) {
			if(isset($body['user'])){
				return $body['user']->first_name.' '.$body['user']->last_name.' | '.$body['user']->email;
			}
			return '--';
		})
		->offerr(function($body) {
			if(isset($body['offer'])){
				return $body['offer']->id.' | '.$body['offer']->destiny;
			}
			return '--';
		})
		->date(function($body) {
			if(isset($body->created_at)){
				return $body->created_at;
			}
			return '--';
		})
		->approvedd(function($body) {
			if(isset($body->approved)){
				return ($body->approved == 1)?'Sim':'Não';
			}
			return '--';
		})
		->acoes(function($body) {
			if(isset($body->approved)){
				if($body->approved == 1){
					return DropdownButton::normal('Ações',
						Navigation::links([
							['Não aprovar', route('admin.comment.update_approved', ['id' => $body['id'], 'approved' => 0])],
							// ['Ver oferta', route('oferta', ['id' => $body['offer']->id])],
						])
					)->pull_right()->split();
				}
				else{
					return DropdownButton::normal('Ações',
						Navigation::links([
							['Aprovar', route('admin.comment.update_approved', ['id' => $body['id'], 'approved' => 1])],
							// ['Ver oferta', route('oferta', ['id' => $body['offer']->id])],
						])
					)->pull_right()->split();
				}
			}
		})
	}}
	{{ Table::close() }}
	<div class="table-footer">
		<div class="dataTables_info">Exibindo <strong>{{ $comment->getFrom() }}</strong> a <strong>{{ $comment->getTo() }}</strong> registros do total de <strong>{{ $comment->getTotal() }}</strong></div>
		{{ $comment->links() }}
	</div>
</div>

@stop
