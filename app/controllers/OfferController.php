<?php

class OfferController extends BaseController {

	public function anyOffer($slug)
	{
        $offer = Offer::with(['ngo', 'partner', 'offer_option', 'offer_image'])
                      // ->where('starts_on', '<=', Carbon::now()->toDateTimeString())
                      // ->where('ends_on'  , '>=', Carbon::now()->toDateTimeString())
                      ->where('slug', '=', $slug)
                      // ->remember(5)
                      ->first();

        if (is_null($offer)) {
            return App::abort(404);
        }

		$this->layout->content = View::make('offer.offer', compact('offer'));
	}

}
