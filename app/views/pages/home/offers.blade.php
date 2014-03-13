<div class="offer-grid row">

	@foreach($offers as $offer)

	<div itemscope itemtype="http://schema.org/Product" class="offer-grid-item col-6 col-sm-6 col-lg-6 clearfix">
		<div class="offer-grid-inner clearfix">

			@if(isset($offer->cover_img['normal']))
			<figure>
				<a href="oferta/{{ $offer->slug }}">
					<img src="{{ asset($offer->cover_img['normal']) }}">
				</a>
			</figure>
			@endif

			<header>
				<h2 itemprop="name"><a href="{{ $offer->slug }}">{{ $offer->title }}</a></h2>
				<h3>{{ $offer->subtitle }}</h3>
			</header>

			<div class="content clearfix">
			   <div class="info row" itemscope itemprop="offers" itemtype="http://schema.org/Offer">
					<div class="installment col-lg-6">{{ $offer->installment }}</div>
					<div class=" col-lg-6">Informação</div>
					<div class=" col-lg-6">Informação</div>
					<div class=" col-lg-6">Informação</div>
					<div class=" col-lg-6">Informação</div>
					<div class=" col-lg-6">Informação</div>
				</div>
				<div class="options clearfix">
					<?php
					$option = $offer->offer_option->sortBy(function($option)
					{
						return $option->price_with_discount;
					})
					->take(1);
					?>
					<div class="prices clearfix">
						<div class="price price-original">De <strong>{{ preg_replace('/,[09]{2}/', '', $option[0]['price_original']) }}</strong></div>
						<div class="price price-discount">Por <strong>{{ preg_replace('/,[09]{2}/', '', $option[0]['price_with_discount']) }}</strong></div>
					</div>
					<div class="action"><a class="view-action" href="oferta/{{ $offer->slug }}">Veja Mais</a></div>
					<div class="percent-off">{{ $option[0]['percent_off'] }}% OFF</div>
				</div>
			</div>

		</div>
	</div>

	@endforeach

</div>
