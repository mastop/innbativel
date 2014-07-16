@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>HTML da Newsletter</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
	            <a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
				<a href="{{ route('admin.offer.deleted') }}" title="Ofertas antigas" class="dropdown-toggle navbar-icon"><i class="icon-folder-open-alt"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
		<textarea>{{ $html }}</textarea>
	</div>
</div>
@stop
