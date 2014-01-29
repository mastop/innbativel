@section('content')

<div class="row-fluid">
	<div class="span4">
		<div class="widget">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Clientes</h6>
				</div>
			</div>
			<div class="well body">
				<div class="fancy-count">{{ User::count() }}</div>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="widget">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Ofertas</h6>
				</div>
			</div>
			<div class="well body">
				<div class="fancy-count">{{ Offer::count() }}</div>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="widget">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Acessos</h6>
				</div>
			</div>
			<div class="well body">
				<div class="fancy-count">0</div>
			</div>
		</div>
	</div>
</div>

@stop
