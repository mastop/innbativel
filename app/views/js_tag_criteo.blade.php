////////////////////////////////
// INDEX
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>
<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
  { event: "setAccount", account: 11137 },
  { event: "setCustomerId", id: "{{ Auth::user()->id }}" },
  { event: "setSiteType", type: "{{ $d }}" },
  { event: "viewHome" }
);
</script>

////////////////////////////////
// OFERTA
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
    { event: "setAccount", account: 11137 },
    { event: "setCustomerId", id: "{{ Auth::user()->id }}" },
    { event: "setSiteType", type: "{{ $d }}" },
    { event: "viewItem", item: "{{ $offer->id; }}" }
);
</script>

////////////////////////////////
// COMPRA
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
	{ event: "setAccount", account: 11137 },
	{ event: "setCustomerId", id: "{{ Auth::user()->id }}" },
    { event: "setSiteType", type: "{{ $d }}" },
	{ event: "viewBasket", item: [
		@foreach ($offers_options as $offer_option)
		    { id: "{{ $offer_option->offer_id }}", price: {{ $offer_option->price_with_discount }}, quantity: 1 },
		@endforeach
]});
</script>

////////////////////////////////
// CATEGORIA
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
	{ event: "setAccount", account: 11137 },
	{ event: "setCustomerId", id: "{{ Auth::user()->id }}" },
    { event: "setSiteType", type: "{{ $d }}" },
	{ event: "viewList", item: [
		@foreach ($offers as $offer)
			"{{ $offer->id }}",
		@endforeach
	], keywords: "{{ $category_title }}" }
);
</script>

////////////////////////////////
// BUSCA
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
	{ event: "setAccount", account: 11137 },
	{ event: "setCustomerId", id: "{{ Auth::user()->id }}" },
    { event: "setSiteType", type: "{{ $d }}" },
	{ event: "viewList", item: [
		@foreach ($offers as $offer)
			"{{ $offer->id }}",
		@endforeach
	], keywords: "{{ $search_for }}" }
);
</script>

////////////////////////////////
// SUCESSO (CONVERSÃO)
////////////////////////////////
<?php
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;

$d = 'd';

if($detect->isTablet()){
    $d = 't';
}
else if($detect->isMobile()){
    $d = 'm';
}
?>

<script type="text/javascript" src="//static.criteo.net/js/ld/ld.js" async="true"></script>
<script type="text/javascript">
window.criteo_q = window.criteo_q || [];
window.criteo_q.push(
	{ event: "setAccount", account: 11137 },
	{ event: "setCustomerId", id: "{{ Auth::user()->id }}" },
    { event: "setSiteType", type: "{{ $d }}" },
	{ event: "trackTransaction" , id: "{{ $reference_id }}", new_customer: "", deduplication: "", item: [
		@foreach ($order['offers_options'] as $offer_option)
		    { id: "{{ $offer_option->offer_id }}", price: {{ $offer_option->price_with_discount }}, quantity: {{ $offer_option['pivot']->qty }} },
		@endforeach
]});
</script>
