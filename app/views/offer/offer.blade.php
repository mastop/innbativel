@section('content')
	<div id="offer">
        <div class="col-8 col-sm-8 col-lg-8 clearfix">
            <h2>{{ $offer->title }}</h2>
            <h3>{{ $offer->subtitle }}</h3>
            <p>{{ $offer->description }}</p>
            <figure id="offer-image"><img src="{{ asset($offer->cover_img) }}"></figure>
            @if(isset($offer->offer_image) &&!empty($offer->offer_image) && !is_null($offer->offer_image))
            <div id="offer-thumbs">
                <ul class="clearfix">
                @foreach($offer->offer_image as $image)
                    <li><img src="{{ $image->url }}"></li>
                @endforeach
                </ul>
            </div>
            @endif
        </div>
        <div class="col-4 col-sm-4 col-lg-4 clearfix">
            <h2>Fixo</h2>
        </div>
    </div>
@stop
