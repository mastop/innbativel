@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar Categorias</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.category.create') }}" title="Criar Categoria" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.category.save_sort')) }}

		<div id="TabContainer">
			<ul>
				@foreach ($categories as $category)
				<li>
					{{ $category->title }}
                    {{ Form::hidden('categories[]', "$category->id") }}
				</li>
				@endforeach
			</ul>
		</div>

	    {{ Former::submit('Enviar') }}
		{{ Former::link('Resetar', route('admin.category.sort')) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
