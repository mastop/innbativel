@section('content')
	<div class="offer-grid row offer-group">
      @if( $offers->count() < 1)
        <h3>Nenhuma oferta encontrada na categoria {{ $category['title'] }}</h3>
      @else
        <h3>{{ $category['title'] }}</h3>
        @foreach ($offers as $offer)
        <?php $offer_option = $offer['offer_option_home'][0]; ?>
        <div itemscope class="offer-grid-item col-6 col-sm-6 col-lg-6 clearfix">
            <a href="oferta/{{ $offer['slug'] }}" class="offer-grid-inner clearfix">
                @if(isset($offer['genre']))
                <div class="offer-label">{{ $offer['genre']['icon'] . $offer['genre']['title'] }}</div>
                @endif
                @if(isset($offer['genre2']))
                <div class="offer-label">{{ $offer['genre2']['icon'] . $offer['genre2']['title'] }}</div>
                @endif
                <figure>
                    <img src="{{ $offer['cover_img'] }}" alt="{{ $offer['subtitle'] }}">
                </figure>
                <header class="tooltip" data-tip="{{ $offer['subtitle'] }}">
                    <h2 itemprop="name">{{ $offer['title'] }}</h2>
                </header>
                <div class="content clearfix">
                    <div class="info row" itemscope itemprop="offers">
                        @foreach ($offer['included'] as $included)
                        <div class="col-lg-2 tooltip" data-tip="{{ $included['description'] }}">{{ $included['icon'] . $included['title'] }}</div>
                        @endforeach
                    </div>
                    <div class="options clearfix">
                        <div class="prices clearfix">
                            <div class="price price-original">De <span>R${{ number_format(floatval($offer_option['price_original']), 0, '', '.') }}</span></div>
                            <div class="price price-discount">Por R$<strong>{{ number_format(floatval($offer_option['price_with_discount']), 0, '', '.') }}</strong></div>
                        </div>
                        <div class="percent-off tooltip" data-tip="Economize {{ $offer_option['percent_off'] }}%"><strong>{{ $offer_option['percent_off'] }}</strong>OFF</div>
                        <div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
                        <div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
      @endif
	</div>
@stop