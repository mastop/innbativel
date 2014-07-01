@section('content')
    <div id="main" class="container">
        <h1 class="title">As melhores ofertas para viajar no feriado</h1>
        @foreach ($feriados as $k => $feriado)
            @if(count($feriado->offer) > 0)
                <div class="offer-grid row offer-group">

                    <h3> {{ $feriado->title }}</h3>

                    @foreach ($feriado->offer as $offer)
                    <div itemscope class="offer-grid-item col-6 col-sm-6 col-lg-6 clearfix">
                        @include('partials.oferta', array('offer'=>$offer))
                    </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@stop