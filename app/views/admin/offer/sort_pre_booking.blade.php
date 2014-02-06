@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar Ofertas</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.sort_pre_booking') }}" title="Ordenar Ofertas em Pré-reservas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.offer.save_sort_pre_booking')) }}

		<div id="TabContainer">
			<ul>
				@foreach ($offers as $offer)
				<li>
					{{ $offer->title }}
					{{ Former::hidden('offers[]', $offer->id) }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit() }}
		{{ Former::link('Resetar', route('admin.offer.sort_pre_booking')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
