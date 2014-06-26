<a href="{{$offer->url}}" class="offer-grid-inner clearfix">
    @if($offer->genre_id > 0)<div class="offer-label"><span class="entypo {{$offer->genre->icon}}"></span> {{$offer->genre->title}}</div>@endif
    @if($offer->genre2_id > 0)<div class="offer-label"><span class="entypo {{$offer->genre2->icon}}"></span> {{$offer->genre2->title}}</div>@endif
    <figure>
        <img src="{{$offer->thumb}}" alt="{{$offer->title}}">
    </figure>
    <header class="tooltip" data-tip="{{$offer->title}}">
        <h2 itemprop="name">{{$offer->destiny->name}}</h2>
    </header>
    <div class="content clearfix">
        <div class="info row" itemscope="" itemprop="offers">
            @foreach ($offer->included as $included)
            <div class="col-lg-2 tooltip" data-tip="{{ $included->description }}"><span class="entypo {{ $included->icon }}"></span> {{ $included->title }}</div>
            @endforeach
        </div>
        <div class="options clearfix">
            <div class="prices clearfix">
                <div class="price price-original">De <span>R$ {{intval($offer->price_original)}}</span></div>
                <div class="price price-discount">Por R$ <strong>{{intval($offer->price_with_discount)}}</strong></div>
            </div>
            <div class="percent-off tooltip" data-tip="Economize {{$offer->percent_off}}%"><strong>{{$offer->percent_off}}</strong>OFF</div>
            <div class="installment tooltip" data-tip="Parcele em até 10 vezes">Em até<strong>10</strong></div>
            <div class="more tooltip" data-tip="Veja mais detalhes da oferta"><span class="entypo chevron-thin-right"></span></div>
        </div>
    </div>
</a>