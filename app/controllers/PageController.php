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
		$groups = Group::with(['offer.genre', 'offer.genre2', 'offer.offer_option_home', 'offer.included'])
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

    public function postFaleConosco()
    {
        $inputs = Input::all();

        $rules = [
            'contactName' => 'Required|Max:255',
            'contactEmail' => 'Required|Max:255|Email',
            'contactMessage' => 'Required|Max:255',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes())
        {
            // INÍCIO E-MAIL
            $name = $inputs['contactName'];
            $email = $inputs['contactEmail'];
            $telefone = $inputs['contactPhone'];
            $celuar = $inputs['contactCelular'];
            $msg = $inputs['contactMessage'];


            $data = array('name' => $name, 'email' => $email, 'telefone' => $telefone, 'celuar' => $celuar, 'msg' => $msg);

            // ENVIO DE EMAIL PARA O USUÁRIO INFORMANDO QUE FOI RECEBIDO SEU CONTATO
            Mail::send('emails.contact.reply', $data,
                function($message) use($name, $email){
                    $message->to($email, 'INNBatível')
                        ->setReplyTo('faleconosco@innbativel.com.br', 'INNBatível')
                        ->setSubject('[INNBatível] '.$name. ', recebemos seu contato.'
                        );
                    }
            );

            // ENVIO DE EMAIL PARA A EQUIPE DO INNBatível
            Mail::send('emails.contact.send', $data,
                function($message) use($name, $email){
                    $message->to("faleconosco@innbativel.com.br", 'INNBatível')
                        ->setReplyTo($email, 'INNBatível')
                        ->setSubject('[INNBatível] Contato de '.$name. ''
                        );
                }
            );
            // FIM E-MAIL

            Session::flash('success', 'Seu contato foi enviado com sucesso.');

            return Redirect::route('home');
        }

        /*
         * Return and display Errors
         */
        return Redirect::route('home')
            ->withInput()
            ->withErrors($validation);
    }
}
