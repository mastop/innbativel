@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Ordenar Subcategorias</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.category.create') }}" title="Criar Subcategoria" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		{{ Former::inline_open(route('admin.category.save_sort_sub')) }}
		{{ Former::label($category) }}

		<div id="TabContainer">
			<ul>
				@foreach ($subcategories as $subcategory)
				<li>
					{{ $subcategory->title }}
					{{ Former::hidden('subcategories[]', $subcategory->id) }}
				</li>
				@endforeach
			</ul>
		</div>
		{{ Former::hidden('category_id', $category_id) }}

	    {{ Former::submit() }}
		{{ Former::link('Resetar', route('admin.category.sort_sub', $category_id)) }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
