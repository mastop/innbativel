@section('content')
	<div id="main" class="container">
        @if(isset($groups[0]->offer[0]) || count($banners) > 0)
            <div class="row">
              @if(isset($groups[0]->offer[0]))
              <div itemscope class="offer-spotlight offer-grid-item col-7 col-sm-7 col-lg-7 clearfix">
                  @include('partials.oferta', array('offer'=>$groups[0]->offer[0]))
              </div>
              @endif
              <div class="col-5 col-sm-5 col-lg-5">

                <div id="banner-carousel" class="carousel slide banner-grid-item clearfix" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach($banners as $k => $banner)
                        <li data-target="#banner-carousel" data-slide-to="{{$k}}" @if($k == 0) class="active" @endif></li>
                        @endforeach
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        @foreach($banners as $k => $banner)
                        <div class="item @if($k == 0) active @endif">
                            <a href="{{ $banner->url }}" class="banner-grid-inner clearfix">
                                <img src="{{ $banner->img }}" alt="{{ $banner->title }}">
                                @if($banner->title)
                                    <header @if($banner->subtitle) class="tooltip" data-tip="{{ $banner->subtitle }}@endif">
                                        <h2>{{ $banner->title }}</h2>
                                    </header>
                                @endif
                            </a>
                        </div>
                        @endforeach
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
        @endif

		@foreach ($groups as $k => $group)
        @if($k == 0) @continue @endif
		<div class="offer-grid row offer-group">

		  <h3><span class="entypo {{ $group->icon }}"></span> {{ $group->title }}</h3>

		  @foreach ($group->offer as $k => $offer)
		  <div itemscope class="offer-grid-item col-6 col-sm-6 col-lg-6 clearfix">
              @include('partials.oferta', array('offer'=>$offer))
		  </div>
          @if($k == 5) @break @endif
		  @endforeach
		  <a class="more" href="{{ $group->url }}">Veja mais ofertas de <strong>{{ $group->short_title }}</strong></a>

		</div>
		@endforeach
		
	</div>
@stop
