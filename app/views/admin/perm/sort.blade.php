@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar menu</h6>
	        <div class="nav pull-right">
				<a href="{{ route('admin.perm') }}" title="Listar Permissões" class="dropdown-toggle navbar-icon"><i class="icon-align-justify"></i></a>
	            <a href="{{ route('admin.perm.create') }}" title="Criar Permissão" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.perm.sort') }}" title="Ordenar Menu" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.perm.save_sort')) }}

		<div id="TabContainer">
			<ul>
				@foreach ($perms as $perm)
				<li>
					{{ $perm->menu_name.' | '.$perm->name }}
					{{ Former::hidden('perms[]', '')->value($perm->id) }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit('Salvar') }}
	    {{ Former::link('Resetar', route('admin.perm.sor')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop