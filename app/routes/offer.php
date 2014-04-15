<?php

Route::any('oferta/{slug}', ['as' => 'offer', 'uses' => 'OfferController@anyOffer', 'after' => 'cache.public']);
