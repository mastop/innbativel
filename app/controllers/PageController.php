<?php

class PageController extends BaseController {

	public function anyHome()
	{
 		$offers = Offer::with(['ngo', 'partner', 'offer_option'])
			// ->where('starts_on', '<=', Carbon::now()->toDateTimeString())
			// ->where('ends_on'  , '>=', Carbon::now()->toDateTimeString())
			->orderBy('display_order', 'asc')
			->remember(5)
			->get();

		$this->layout->content = View::make('pages.home', compact('offers'));
	}

}
