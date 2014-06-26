@section('content')
    <div id="main" class="container">
    	<div class="offer-grid row offer-group">
          @if( $offers->count() < 1)
            <h3>Nenhuma oferta encontrada na categoria {{ $category->title }}</h3>
          @else
            <h3>{{ $category['title'] }}</h3>
            @foreach ($offers as $offer)
            <div itemscope class="offer-grid-item col-6 col-sm-6 col-lg-6 clearfix">
                @include('partials.oferta', array('offer'=>$offer))
            </div>
            @endforeach
          @endif
    	</div>
    </div>
@stop