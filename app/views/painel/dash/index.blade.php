@section('content')

	<div class="span4">
		<div class="widget">
			<div class="navbar">
				<div class="navbar-inner">
					<h6>Ofertas</h6>
				</div>
			</div>
			<div class="well body">
				<div class="fancy-count">{{ Offer::withTrashed()->where('partner_id', Auth::user()->id)->count() }}</div>
			</div>
		</div>
	</div>


@stop
