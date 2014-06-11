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
	public function getSearchOffers()
	{
        $q = Input::get('q');
        $page = Input::get('page_limit', 10);
        $now = date('Y-m-d H:i:s');

        //$data['offers'] = Offer::with(['saveme', 'offer_option', 'partner', 'destiny'])->where('starts_on','<', $now)->where('ends_on','>', $now)->where('title', 'LIKE', $q)->orderBy('starts_on', 'asc')->get();
        $results = DB::table('offers')
                    ->select(
                    'offers.id as ofid',
                    'offers.title as offer_title',
                    'offers.cover_img',

                    'offers_options.id as id',
                    'offers_options.title as optitle',
                    'offers_options.subtitle as opsubtitle',
                    'offers_options.price_with_discount',
                    'offers_options.percent_off',

                    'destinies.name as destname')
                    ->join('offers_options', 'offers.id', '=', 'offers_options.offer_id')
                    ->join('destinies', 'offers.destiny_id', '=', 'destinies.id')
                    ->where('offers.starts_on','<', $now)
                    ->where('offers.ends_on','>', $now)
                    ->where('offers.is_active','=', 1)
                    ->where(function($query) use ($q){
                        $query->orWhere('offers_options.title','like', "%$q%")
                        ->orWhere('destinies.name','like', "%$q%")
                        ->orWhere('offers.title','like', "%$q%");
                    })
                    ->orderBy('offers.starts_on', 'asc')
                    ->take($page)->get();
        $data['count'] = count($results);
        $data['offers'] = $results;
        //print_r($data);
        return Response::json($data)->setCallback(Input::get('callback'));
	}
	public function getSearchOffer()
	{
        $id = Input::get('id');
        if(!$id){
            return Response::json();
        }
        //print_r($id);
        //$data['offers'] = Offer::with(['saveme', 'offer_option', 'partner', 'destiny'])->where('starts_on','<', $now)->where('ends_on','>', $now)->where('title', 'LIKE', $q)->orderBy('starts_on', 'asc')->get();
        $results = DB::table('offers')
                    ->select(
                    'offers.id as ofid',
                    'offers.title as offer_title',
                    'offers.cover_img',

                    'offers_options.id as id',
                    'offers_options.title as optitle',
                    'offers_options.subtitle as opsubtitle',
                    'offers_options.price_with_discount',
                    'offers_options.percent_off',

                    'destinies.name as destname')
                    ->join('offers_options', 'offers.id', '=', 'offers_options.offer_id')
                    ->join('destinies', 'offers.destiny_id', '=', 'destinies.id')
                    ->whereIn('offers_options.id',explode(',', $id))
                    ->get();
        $data['count'] = count($results);
        $data['offers'] = $results;
        //print_r($data);
        return Response::json($data)->setCallback(Input::get('callback'));
	}

}
