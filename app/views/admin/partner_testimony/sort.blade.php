@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar depoimento de parceiros</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.partner_testimony.create') }}" title="Criar Depoimento" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.partner_testimony.sort') }}" title="Ordenar Depoimentos" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.partner_testimony.save_sort')) }}

		<div id="TabContainer">
			<ul>
				@foreach ($partner_testimony as $pt)
				<li>
					{{ $pt->name.' ('.$pt->destiny.'): '.$pt->testimony }}
					{{ Former::hidden('partner_testimony[]', $pt->id) }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit('Enviar') }}
		{{ Former::link('Resetar', route('admin.partner_testimony.sort')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
