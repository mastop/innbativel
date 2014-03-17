<?php

class PageController extends BaseController {

	public function anyHome()
	{
		$groups = Group::with(['offer.genre', 'offer.genre2', 'offer.offer_option_home.included'])
						->orderBy('display_order', 'asc')
						->remember(5)
						->get()->toArray();

		$banners = Banner::limit(3)->remember(3)->get()->toArray();

		$this->layout->content = View::make('pages.home', compact('groups', 'banners'));
	}

}
