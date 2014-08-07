@section('javascript')
	<script src="{{ asset_timed('assets/vendor/modernizr/modernizr.min.js') }}"></script>
	<script src="{{ asset_timed('assets/vendor/jquery.shuffle/jquery.shuffle.min.js') }}"></script>
	<script src="{{ asset_timed('assets/themes/floripa/frontend/js/busca.js') }}"></script>
@stop

@section('content')
    <div id="main" class="container search-page">
		
		<div class="row">

			<div class="col-12 col-sm-12 col-lg-12">
                @if($total > 0)
				<h1><strong>{{$total}}</strong> @if($total > 1)ofertas @else oferta @endif encontradas contendo <strong>{{$q}}</strong></h1>
                <p class="subsubtitle">Utilize os filtros abaixo e encontre a melhor oferta para você</p>
                @else
                <h1>Nenhuma oferta encontrada contendo <strong>{{$q}}</strong></h1>
                <p class="subsubtitle">Não encontramos nenhuma oferta com seus critérios de pesquisa.<br />
                    Por favor, faça uma nova busca</p>
                @endif
			</div>

		</div>
		
		
		<div class="row">
			<form class="buy-form">
                @if($total > 0)
				<div itemscope class="col-4 col-sm-4 col-lg-4 clearfix">
					
					<h3>Filtrar por</h3>

					<ul id="categories" class="search-filters">
						<h4>Tipo</h4>
                        <li>
                            <label>
                                <input type="checkbox" id="categories-all" name="categories-all" value="all">
                                <div>Todos</div>
                            </label>
                        </li>
                        @foreach($categories as $k => $cat)
                        <li>
                            <label>
                                <input type="checkbox" id="categories-{{$k}}" name="categories-{{$k}}" value="{{$cat['slug']}}">
                                <div>{{$cat['title']}} ( {{$cat['total']}} )</div>
                            </label>
                        </li>
                        @endforeach
					</ul>

					<div class="form-group price-range">
						<h4>Preço</h4>
						<div>
							<label>De <input type="number" class="form-control" id="min-price" name="min-price" min="1" max="4999" step="9" placeholder="R$" /></label>
							<label>até <input type="number" class="form-control" id="max-price" name="max-price" min="2" max="5000" step="9" placeholder="R$" /></label>
						</div>
					</div>
					
					<ul id="destinies" class="search-filters">
						<h4>Destinos</h4>
						<li>
							<label>
								<input type="checkbox" id="destinies-all" name="destinies-all" value="all">
								<div>Todos</div>
							</label>
						</li>
                        @foreach($destinies as $k => $des)
                        <li>
                            <label>
                                <input type="checkbox" id="destinies-{{$k}}" name="destinies-{{$k}}" value="destiny-{{$k}}">
                                <div>{{$des['name']}} ( {{$des['total']}} )</div>
                            </label>
                        </li>
                        @endforeach
					</ul>
                    @if(!empty($holidays))
					<ul id="holidays" class="search-filters">
						<h4>Feriados</h4>
						<!-- <li>
							<label>
								<input type="checkbox" id="feriados-all" name="feriados-all" value="all">
								<div>Todos</div>
							</label>
						</li> -->
                        @foreach($holidays as $k => $hol)
                        <li>
                            <label>
                                <input type="checkbox" id="holidays-{{$k}}" name="holidays-{{$k}}" value="{{$k}}-holiday">
                                <div>{{$hol['title']}} ( {{$hol['total']}} )</div>
                            </label>
                        </li>
                        @endforeach
					</ul>
                    @endif

					<!-- <ul class="search-filters">
						<h4>Tipos de destino</h4>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-all" name="destinies-type-all" value="all">
								<div>Todos</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-1" name="destinies-type-1" value="litoral">
								<div>Litoral</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-2" name="destinies-type-2" value="serra">
								<div>Serra</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-3" name="destinies-type-3" value="termas">
								<div>Termas</div>
							</label>
						</li>
						<li>
							<label>
								<input type="checkbox" id="destinies-type-4" name="destinies-type-4" value="eco">
								<div>Ecológico</div>
							</label>
						</li>
					</ul> -->

					<ul id="dates" class="search-filters">
						<h4>Datas</h4>
						<li>
							<label>
								<input type="checkbox" id="dates-all" name="dates-all" value="all">
								<div>Qualquer data</div>
							</label>
						</li>
                        @foreach($dates as $k => $dat)
                        <li>
                            <label>
                                <input type="checkbox" id="dates-{{$k}}" name="dates-{{$k}}" value="{{$k}}">
                                <div>{{$dat}}</div>
                            </label>
                        </li>
                        @endforeach
					</ul>

				</div>
		
				<div class="col-8 col-sm-8 col-lg-8">
                    <h3>Resultados</h3>
                    <label class="sorter">
                        Ordenar por:
                        <select id="sort" name="sort">
                            <option value="spotlight">Maior Destaque</option>
                            <option value="price">Menor Preço</option>
                            <option value="discount">Maior Desconto</option>
                        </select>
                    </label>
                @else
                <div class="col-12 col-sm-12 col-lg-12">
                @endif
					<div id="sortable">
                        @if($total > 0)
                            @foreach($offers as $k => $offer)
                            <div itemscope class="offer-grid-item clearfix" data-spotlight="{{$k}}" data-categories="{{$offer->category->slug}}" data-price="{{intval($offer->price_with_discount)}}" data-discount="{{intval($offer->percent_off)}}" data-destinies="destiny-{{$offer->destiny->id}}" data-holidays='["{{implode("-holiday\",\"",$offer->holiday->lists("id"))}}-holiday"]' data-mindate='{{date("Ym", $offer->min_date)}}' data-maxdate='{{date("Ym", $offer->max_date)}}'>
                                @include('partials.oferta', array('offer'=>$offer))
                            </div>
                            @endforeach
                        @endif
					</div>

				</div>
			</form>
		</div>
	</div>
@stop
