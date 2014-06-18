<products xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="http://xml.saveme.com.br/xsd/ofertas.xsd">
@foreach ($offers as $offer)

	<?php
    $instock_and_recommendable =
        ($offer->max_qty - $offer->sold_qty > 0)
        ? 1 : 0;
    ?>

	<product id="{{ $offer->id }}">
		<name>{{ $offer->destiny }}</name>
		<producturl><![CDATA[http://www.innbativel.com.br/oferta/{{ $offer->slug }}]]></producturl>
		<smallimage><![CDATA[<?php echo substr($offer->cover_img, 0, -4) . '_t2' . substr($offer->cover_img, -4); ?>]]></smallimage>
		<price>{{ $offer->price_with_discount }}</price>
		<description>{{ $offer->subtitle }}</description>
		<instock>{{ $instock_and_recommendable }}</instock>
		<categoryid1></categoryid1>
		<bigimage><![CDATA[{{ $offer->cover_img }}]]></bigimage>
		<retailprice>{{ $offer->price_original }}</retailprice>
		<discount>{{ $offer->percent_off }}</discount>
		<recommendable>{{ $instock_and_recommendable }}</recommendable>
		<categoryid2></categoryid2>
		<categoryid3></categoryid3>
	</product>
@endforeach
</products>
