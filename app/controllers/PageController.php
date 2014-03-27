<?php

/**
 *
 */
class PageController extends BaseController {

    /**
     * Show Home
     */
	public function anyHome()
	{
		$groups = Group::with(['offer.genre', 'offer.genre2', 'offer.offer_option_home.included'])
						->orderBy('display_order', 'asc')
						->remember(5)
						->get()->toArray();

		$banners = Banner::limit(3)->remember(3)->get()->toArray();

		$this->layout->content = View::make('pages.home', compact('groups', 'banners'));
	}

    /**
     * Show Termos de uso
     */
    public function anyTermosDeUso()
    {
        $this->layout->content = View::make('pages.termos-de-uso');
    }

    /**
     * Show Política de Privacidade
     */
    public function anyPoliticaDePrivacidade()
    {
        $this->layout->content = View::make('pages.politica-de-privacidade');
    }

    /**
     * Show Quem somos
     */
    public function anyQuemSomos()
    {
        $this->layout->content = View::make('pages.quem-somos');
    }

    /**
     * Show Ação Social
     */
    public function anyAcaoSocial()
    {
        $this->layout->content = View::make('pages.acao-social');
    }

    /**
     * Show Imprensa
     */
    public function anyImprensa()
    {
        $this->layout->content = View::make('pages.imprensa');
    }

    /**
     * Show Imprensa
     */
    public function anyFaleConosco()
    {
        $this->layout->content = View::make('pages.fale-conosco');
    }
}
