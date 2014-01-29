<?php

class AjaxController extends BaseController {

    public function __construct()
    {
        $this->layout = 'format.ajax';
    }

	public function postSearch()
	{
		return [];
	}

	public function getSearchRecomendations()
	{
		$tips = [
			'Florianópolis',
			'Rio de Janeiro',
			'Veneza',
			'Toquio',
		];

		return Response::json($tips);
	}

}
