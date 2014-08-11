@section('content')

    <div class="well widget row-fluid">

        {{ Former::horizontal_open()->rules([
        	'title' => 'required',
        ]) }}

        {{ Former::populate($genre) }}

        {{ Former::text('title', 'Nome')->class('span12') }}
        {{ Former::select('icon', 'Ícone')
        ->addOption(null)
        ->options(array(
        'map-icon-map-pin' => 'map-pin',
        'map-icon-expand' => 'expand',
        'map-icon-fullscreen' => 'fullscreen',
        'map-icon-square-pin' => 'square-pin',
        'map-icon-route-pin' => 'route-pin',
        'map-icon-sheild' => 'sheild',
        'map-icon-liquor-store' => 'liquor-store',
        'map-icon-bicycle-store' => 'bicycle-store',
        'map-icon-hardware-store' => 'hardware-store',
        'map-icon-insurance-agency' => 'insurance-agency',
        'map-icon-lawyer' => 'lawyer',
        'map-icon-real-estate-agency' => 'real-estate-agency',
        'map-icon-art-gallery' => 'art-gallery',
        'map-icon-campground' => 'campground',
        'map-icon-bakery' => 'bakery',
        'map-icon-bar' => 'bar',
        'map-icon-amusement-park' => 'amusement-park',
        'map-icon-aquarium' => 'aquarium',
        'map-icon-airport' => 'airport',
        'map-icon-bank' => 'bank',
        'map-icon-car-rental' => 'car-rental',
        'map-icon-car-dealer' => 'car-dealer',
        'map-icon-hospital' => 'hospital',
        'map-icon-hair-care' => 'hair-care',
        'map-icon-gym' => 'gym',
        'map-icon-grocery-or-supermarket' => 'grocery-or-supermarket',
        'map-icon-general-contractor' => 'general-contractor',
        'map-icon-pharmacy' => 'pharmacy',
        'map-icon-point-of-interest' => 'point-of-interest',
        'map-icon-political' => 'political',
        'map-icon-post-box' => 'post-box',
        'map-icon-health' => 'health',
        'map-icon-post-office' => 'post-office',
        'map-icon-real-estate-agency-copy' => 'real-estate-agency-copy',
        'map-icon-hindu-temple' => 'hindu-temple',
        'map-icon-restaurant' => 'restaurant',
        'map-icon-female' => 'female',
        'map-icon-male' => 'male',
        'map-icon-zoo' => 'zoo',
        'map-icon-veterinary-care' => 'veterinary-careo',
        'map-icon-car-repair' => 'car-repair',
        'map-icon-university' => 'university',
        'map-icon-transit-station' => 'transit-station',
        'map-icon-beauty-salon' => 'beauty-salon',
        'map-icon-electronics-store' => 'electronics-store',
        'map-icon-search' => 'search',
        'map-icon-zoom-out-alt' => 'zoom-out-alt',
        'map-icon-movie-rental' => 'movie-rental',
        'map-icon-atm' => 'atm',
        'map-icon-jewelry-store' => 'jewelry-store',
        'map-icon-car-wash' => 'car-wash',
        'map-icon-unisex' => 'unisex',
        'map-icon-rv-park' => 'rv-park',
        'map-icon-school' => 'school',
        'map-icon-clothing-store' => 'clothing-store',
        'map-icon-laundry' => 'laundry',
        'map-icon-casino' => 'casino',
        'map-icon-place-of-worship' => 'place-of-worship',
        'map-icon-furniture-store' => 'furniture-store',
        'map-icon-zoom-in-alt' => 'zoom-in-alt',
        'map-icon-zoom-in' => 'zoom-in',
        'map-icon-department-store' => 'department-store',
        'map-icon-fire-station' => 'fire-station',
        'map-icon-church' => 'church',
        'map-icon-library' => 'library',
        'map-icon-shopping-mall' => 'shopping-mall',
        'map-icon-local-government' => 'local-government',
        'map-icon-spa' => 'spa',
        'map-icon-convenience-store' => 'convenience-store',
        'map-icon-police' => 'police',
        'map-icon-route' => 'route',
        'map-icon-zoom-out' => 'zoom-out',
        'map-icon-location-arrow' => 'location-arrow',
        'map-icon-postal-code' => 'postal-code',
        'map-icon-locksmith' => 'locksmith',
        'map-icon-doctor' => 'doctor',
        'map-icon-mosque' => 'mosque',
        'map-icon-stadium' => 'stadium',
        'map-icon-storage' => 'storage',
        'map-icon-movie-theater' => 'movie-theater',
        'map-icon-electrician' => 'electrician',
        'map-icon-moving-company' => 'moving-company',
        'map-icon-postal-code-prefix' => 'postal-code-prefix',
        'map-icon-crosshairs' => 'crosshairs',
        'map-icon-compass' => 'compass',
        'map-icon-dentist' => 'dentist',
        'map-icon-plumber' => 'plumber',
        'map-icon-museum' => 'museum',
        'map-icon-finance' => 'finance',
        'map-icon-parking' => 'parking',
        'map-icon-courthouse' => 'courthouse',
        'map-icon-accounting' => 'accounting',
        'map-icon-store' => 'store',
        'map-icon-subway-station' => 'subway-station',
        'map-icon-natural-feature' => 'natural-feature',
        'map-icon-florist' => 'florist',
        'map-icon-food' => 'food',
        'map-icon-night-club' => 'night-club',
        'map-icon-synagogue' => 'synagogue',
        'map-icon-taxi-stand' => 'taxi-stand',
        'map-icon-painter' => 'painter',
        'map-icon-train-station' => 'train-station',
        'map-icon-pet-store' => 'pet-store',
        'map-icon-gas-station' => 'gas-station',
        'map-icon-funeral-home' => 'funeral-home',
        'map-icon-cemetery' => 'cemetery',
        'map-icon-bowling-alley' => 'bowling-alley',
        'map-icon-roofing-contractor' => 'roofing-contractor',
        'map-icon-physiotherapist' => 'physiotherapist',
        'map-icon-embassy' => 'embassy',
        'map-icon-city-hall' => 'city-hall',
        'map-icon-bus-station' => 'bus-station',
        'map-icon-park' => 'park',
        'map-icon-lodging' => 'lodging',
        'map-icon-toilet' => 'toilet',
        'map-icon-circle' => 'circle',
        'map-icon-square-rounded' => 'square-rounded',
        'map-icon-square' => 'square',
        'map-icon-book-store' => 'book-store',
        'map-icon-cafe' => 'cafe',
        'map-icon-wheelchair' => 'wheelchair',
        'map-icon-volume-control-telephone' => 'volume-control-telephone',
        'map-icon-sign-language' => 'sign-language',
        'map-icon-low-vision-access' => 'low-vision-access',
        'map-icon-open-captioning' => 'open-captioning',
        'map-icon-closed-captioning' => 'closed-captioning',
        'map-icon-braille' => 'braille',
        'map-icon-audio-description' => 'audio-description',
        'map-icon-assistive-listening-system' => 'assistive-listening-system',
        'map-icon-abseiling' => 'abseiling',
        'map-icon-tennis' => 'tennis',
        'map-icon-skateboarding' => 'skateboarding',
        'map-icon-playground' => 'playground',
        'map-icon-inline-skating' => 'inline-skating',
        'map-icon-hang-gliding' => 'hang-gliding',
        'map-icon-climbing' => 'climbing',
        'map-icon-baseball' => 'baseball',
        'map-icon-archery' => 'archery',
        'map-icon-wind-surfing' => 'wind-surfing',
        'map-icon-scuba-diving' => 'scuba-diving',
        'map-icon-sailing' => 'sailing',
        'map-icon-marina' => 'marina',
        'map-icon-canoe' => 'canoe',
        'map-icon-boat-tour' => 'boat-tour',
        'map-icon-boat-ramp' => 'boat-ramp',
        'map-icon-swimming' => 'swimming',
        'map-icon-whale-watching' => 'whale-watching',
        'map-icon-waterskiing' => 'waterskiing',
        'map-icon-surfing' => 'surfing',
        'map-icon-rafting' => 'rafting',
        'map-icon-kayaking' => 'kayaking',
        'map-icon-jet-skiing' => 'jet-skiing',
        'map-icon-fishing-pier' => 'fishing-pier',
        'map-icon-fish-cleaning' => 'fish-cleaning',
        'map-icon-diving' => 'diving',
        'map-icon-boating' => 'boating',
        'map-icon-fishing' => 'fishing',
        'map-icon-cross-country-skiing' => 'cross-country-skiing',
        'map-icon-skiing' => 'skiing',
        'map-icon-snowmobile' => 'snowmobile',
        'map-icon-snowboarding' => 'snowboarding',
        'map-icon-snow' => 'snow',
        'map-icon-snow-shoeing' => 'snow-shoeing',
        'map-icon-sledding' => 'sledding',
        'map-icon-ski-jumping' => 'ski-jumping',
        'map-icon-ice-skating' => 'ice-skating',
        'map-icon-ice-fishing' => 'ice-fishing',
        'map-icon-chairlift' => 'chairlift',
        'map-icon-golf' => 'golf',
        'map-icon-horse-riding' => 'horse-riding',
        'map-icon-motobike-trail' => 'motobike-trail',
        'map-icon-trail-walking' => 'trail-walking',
        'map-icon-viewing' => 'viewing',
        'map-icon-walking' => 'walking',
        'map-icon-bicycling' => 'bicycling'
        ))
        ->data_placeholder('Selecione um Ícone')
        ->class('span12 select2')
        ->select('map-icon-'.$genre->icon)
        }}

        {{ Former::actions()
          ->primary_submit('Salvar')
          ->inverse_reset('Limpar') }}

        {{ Former::close() }}

    </div>

@stop


