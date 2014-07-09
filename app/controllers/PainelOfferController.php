<?php

class PainelOfferController extends BaseController {

	/**
	 * Offer Repository
	 *
	 * @var Offer
	 */
	protected $offer;
	protected $offer_option;

	/**
	 * Constructor
	 */
	public function __construct(Offer $offer, OfferOption $offer_option)
	{
		/*
		 * Set Offer Instance
		 */

		$this->offer = $offer;
		$this->offer_option = $offer_option;

		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;
	}

    public function getView($id)
    {
        $offer = $this->offer->where('id', $id)->withTrashed()->with(['offer_option', 'category', 'offer_image', 'included'])->first();

        if (is_null($offer))
        {
            Session::flash('error', 'Oferta #'.$id.' não encontrada.');
            return Redirect::route('admin.offer');
        }

        $this->layout->page_title = 'Visualizando Oferta #'.$offer->id.' '.$offer->title;
        $this->layout->content = View::make('painel.offer.view', compact('offer'));
    }

}
