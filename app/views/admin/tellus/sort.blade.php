@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar depoimento do conte pra gente</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.tellus.create') }}" title="Criar Depoimento" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.tellus.sort') }}" title="Ordenar Depoimentos" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.tellus.save_sort')) }}

		<div id="TabContainer">
			<ul>
				@foreach ($tellus as $tu)
				<li>
					{{ $tu->name.' ('.$tu->destiny.'): '.$tu->depoiment }}
					{{ Former::hidden('tellus[]', $tu->id) }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit() }}
		{{ Former::link('Resetar', route('admin.tellus.sort')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
