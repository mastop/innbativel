@section('content')
<div class="widget">
	<div class="navbar">
		<div class="navbar-inner">
			<h6>Gerar HTML da Newsletter</h6>
	        <div class="nav pull-right">
	            <a href="{{ route('admin.offer.create') }}" title="Criar Oferta" class="dropdown-toggle navbar-icon"><i class="icon-plus"></i></a>
				<a href="{{ route('admin.offer.sort') }}" title="Ordenar Ofertas" class="dropdown-toggle navbar-icon"><i class="icon-random"></i></a>
				<a href="{{ route('admin.offer.newsletter') }}" title="Gerar Newsletter" class="dropdown-toggle navbar-icon"><i class="icon-envelope"></i></a>
	        </div>
		</div>
	</div>
	<div class="well widget row-fluid">
        {{ Former::inline_open(route('admin.offer.generate_newsletter')) }}

        {{ Former::select('system', 'Sistema')
        ->addOption('Sendy', 'sendy')
        ->addOption('GetResponse', 'getresponse')
        }}
        <hr/>
        {{ Former::text('title', 'Título do e-mail:') }}
        <hr/>
        @for ($i = 1; $i <= 3; $i++)
		<div id="TabContainer">
            {{ Former::text('input['.$i.']', 'Título do grupo '.$i.':') }}
            {{ Former::text('text['.$i.']', 'Texto do Botão '.$i.':') }}
            {{ Former::text('button['.$i.']', 'Link do Botão '.$i.':') }}
			<ul>
				@foreach ($offers as $offer)
				<li>
					{{ Former::checkbox('selected_offers['.$i.']['.$offer->id.']', '')->text($offer->id.' | '.$offer->title) }}
					{{ Former::hidden('offers['.$i.'][]', $offer->id) }}
				</li>
				@endforeach
			</ul>
		</div>
        <hr/>
        @endfor

	    {{ Former::submit('Gerar HTML') }}

	    {{ Former::close() }}
	</div>
</div>
<script type="text/javascript">
	$('#TabContainer').tabs();
	$('#TabContainer .ui-tabs-nav').sortable();
</script>
@stop
