@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar comentários da oferta {{ $offer->id }}</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.offer.save_sort_comment', $offer->id)) }}

		<div id="TabContainer">
			<ul>
				@foreach ($offer['comment'] as $comment)
				<li>
					{{ $comment->comment }}
					{{ Former::hidden('comments[]', $comment->id) }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit('Enviar') }}
		{{ Former::link('Resetar', route('admin.offer.sort_comment', $offer->id)) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
