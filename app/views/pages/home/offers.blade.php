<?php
$first_group = array_shift($groups);
?>
<div class="row">
  <?php
  if (sizeof($first_group['offer']) > 0)
  {
    $offer =  $first_group['offer'][0];
    $offer_option = $offer['offer_option_home'][0];
  ?>
  <div itemscope class="offer-spotlight offer-grid-item col-7 col-sm-7 col-lg-7 clearfix">
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
  <?php } ?>
  <div class="col-5 col-sm-5 col-lg-5">

    <div id="banner-carousel" class="carousel slide banner-grid-item clearfix" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#banner-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#banner-carousel" data-slide-to="1" class=""></li>
            <li data-target="#banner-carousel" data-slide-to="2" class=""></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <a href="{{ $banners[0]['link'] }}" class="banner-grid-inner clearfix">
                    <img src="{{ $banners[0]['img'] }}" alt="{{ $banners[0]['subtitle'] }}">
                    @if(isset($banners[0]['title']))
                    <header class="tooltip" data-tip="{{ $banners[0]['subtitle'] }}">
                        <h2>{{ $banners[0]['title'] }}</h2>
                    </header>
                    @endif
                </a>
            </div>
            <div class="item">
                <a href="{{ $banners[1]['link'] }}" class="banner-grid-inner clearfix">
                    <img src="{{ $banners[1]['img'] }}" alt="{{ $banners[1]['subtitle'] }}">
                    @if(isset($banners[0]['title']))
                    <header class="tooltip" data-tip="{{ $banners[1]['subtitle'] }}">
                        <h2>{{ $banners[0]['title'] }}</h2>
                    </header>
                    @endif
                </a>
            </div>

            <div class="item">
                <a href="{{ $banners[2]['link'] }}" class="banner-grid-inner clearfix">
                    <img src="{{ $banners[2]['img'] }}" alt="{{ $banners[2]['subtitle'] }}">
                    @if(isset($banners[0]['title']))
                    <header class="tooltip" data-tip="{{ $banners[2]['subtitle'] }}">
                        <h2>{{ $banners[0]['title'] }}</h2>
                    </header>
                    @endif
                </a>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#banner-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#banner-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
  </div>
</div>

@foreach ($groups as $group)
<div class="offer-grid row offer-group">

  <h3>{{ $group['title'] }}</h3>

  @foreach ($group['offer'] as $offer)
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

  <a class="more" href="{{ $group['url'] }}">Veja mais ofertas</a>

</div>
@endforeach
