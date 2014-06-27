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
        $groups = Group::with(['offer.genre', 'offer.genre2', 'offer.destiny', 'offer.included'])
                        ->orderBy('display_order', 'asc')
                        ->remember(5)
                        ->get();

        $banners = Banner::where('is_active', '=', 1)->limit(5)->remember(3)->get();

        $this->layout->body_classes = 'innbativel frontend no-sidebar';
        $this->layout->content = View::make('pages.home', compact('groups', 'banners'));
    }
    /**
     * Show Home
     */
    public function anyStatus()
    {
        return 'OK';
    }

    /**
     * Show Offer
     */
    public function anyOferta($slug)
    {
        $offer = Offer::where('slug', $slug)
                      ->with(['offer_option', 'offer_additional', 'offer_image', 'genre', 'genre2', 'partner'])
                      ->first();

        // print('<pre>');
        // print_r($offer->toArray());
        // print('</pre>'); die();

        // SEO
        $this->layout->title = $offer->destiny->name.' - '.$offer->title;
        $this->layout->description = $offer->subtitle.' A partir de R$ '.intval($offer->price_with_discount).' com '.$offer->percent_off.'% OFF!';
        $this->layout->og_type = 'article';
        $this->layout->image = 'https:'.$offer->thumb;

        $this->layout->content = View::make('pages.oferta', compact('offer'));
    }

    /**
     * Show Termos de uso
     */
    public function anyComprar()
    {
        $oId = Input::get('offer');
        $opt = Input::get('opt');
        $add = Input::get('add', array());

        if($oId && $opt){
            Session::put('oId', $oId);
            Session::put('opt', $opt);
            Session::put('add', $add);
        }elseif(Session::has('oId')){
            $oId = Session::get('oId');
            $opt = Session::get('opt');
            $add = Session::get('add');
        }

        $offer = Offer::with(['offer_option', 'offer_additional', 'offer_image', 'genre', 'genre2', 'partner'])->find((int)$oId);

        if(!$offer || !$opt){
            Session::flash('error', 'Oferta não encontrada');
            return Redirect::route('home');
        }

        $this->layout->comprar = true;
        $this->layout->body_classes = 'checkout-page';
        $this->layout->content = View::make('pages.comprar', compact('offer', 'opt', 'add'));
    }
    public function postValidateCoupon(){
        $this->layout = 'format.ajax';
        $display_code = Input::get('promoCode');
        $offers_options_ids = Input::get('opt', array());
        $offers = OfferOption::whereIn('id', $offers_options_ids)->get(['offer_id']);
        $offer_ids = [];

        foreach ($offers as $o) {
            $offer_ids[] = $o->offer_id;
        }

        $discount_coupon = DiscountCoupon::where('display_code', '=', $display_code)
            ->where( function ( $query ) use ( $offer_ids )
            {
                $query->whereIn('offer_id', $offer_ids)
                    ->orWhereNull('offer_id');
            })
            ->where( function ( $query )
            {
                $query->where('user_id', '=', Auth::user()->id)
                    ->orWhereNull('user_id');
            })
            ->where('starts_on', '<=', date('Y-m-d H:i:s'))
            ->where('ends_on', '>=', date('Y-m-d H:i:s'))
            ->get(['id', 'value', 'qty_used', 'qty'])
            ->first()
        ;
        if(isset($discount_coupon) && $discount_coupon->qty_used < $discount_coupon->qty){
            return Response::json($discount_coupon);
        }
        else{
            return Response::json(array("id"=>0,"value"=>0,"qty_used"=>0,"qty"=>0));
        }
    }

    /**
     * Show Termos de uso
     */
    public function anySucesso($status, $boletus_url = null)
    {
        $this->layout->content = View::make('pages.sucesso', ['status' => $status, 'boletus_url' => $boletus_url]);
    }

    /**
     * Show Termos de uso
     */
    public function anyBusca()
    {
        $this->layout->body_classes = 'search-page';
        $this->layout->content = View::make('pages.busca');
    }

    /**
     * Show Termos de uso
     */
    public function anyMinhaConta()
    {
        $this->layout->content = View::make('pages.minha-conta');
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
     * Show Fale Conosco
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
            $url = $inputs['url'];

            $data = array('name' => $name, 'email' => $email, 'telefone' => $telefone, 'celuar' => $celuar, 'msg' => $msg, 'url' => $url);

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

            // Session::flash('success', 'Seu contato foi enviado com sucesso.');
            $this->layout = 'format.ajax';
            return Response::json(['error' => 0]);
        }

        /*
         * Return and display Errors
         */
        $this->layout = 'format.ajax';
        return Response::json(['error' => 1, 'message' => 'Ocorreu um erro. Por favor verifique os dados prencidos e tente novamente.']);
    }
    /**
     * Redireciona até a página do Banner
     */
    public function getBanner($ban)
    {
        // Decodifica o ID do Banner
        $encoded = $ban;
        $offset = ord($encoded[0]) - 79;
        $encoded = substr($encoded, 1);
        for ($i = 0, $len = strlen($encoded); $i < $len; ++$i) {
            $encoded[$i] = ord($encoded[$i]) - $offset - 65;
        }
        $banner = Banner::find((int) $encoded);
        if($banner->is_active){
            // Incrementa os cliques
            $banner->increment('clicks');
        }
        return Redirect::to($banner->link);
    }
}

