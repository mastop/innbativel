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

        if(!$offer){
            return Redirect::route('home')->with('warning', 'Oferta não encontrada');
        }

        // print('<pre>');
        // print_r($offer->toArray());
        // print('</pre>'); die();

        // SEO
        $this->layout->title = $offer->destiny->name.' - '.$offer->short_title;
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

        if(!$offer->is_active || !$offer->is_available){
            return Redirect::route('home')->with('warning', 'A oferta '.$offer->title.' está indisponível no momento.');
        }

        $now = date('Y-m-d H:i:s');
        //dd($offer->getOriginal('starts_on'), $now);

        if($offer->getOriginal('starts_on') > $now){
            return Redirect::route('home')->with('warning', 'As vendas da oferta '.$offer->title.' ainda não iniciaram.');
        }
        if($offer->getOriginal('ends_on') < $now){
            return Redirect::route('home')->with('warning', 'As vendas da oferta '.$offer->title.' foram encerradas');
        }


        /////////////////////////////////////
        /////////////////////////////////////
        require_once app_path().'/braspag/vars.php';
        /////////////////////////////////////
        /////////////////////////////////////

        $this->layout->comprar = true;
        $this->layout->body_classes = 'checkout-page';
        $this->layout->content = View::make('pages.comprar', compact('offer', 'opt', 'add', 'MerchantReferenceCode'));
    }

    public function anyFeriados()
    {
        $feriados = Holiday::with('offer')->remember(5)->get();
        $this->layout->title = 'Viaje no Feriado - INNBatível';
        $this->layout->description = 'Ofertas INNBatíveis para você viajar no Feriado!';
        $this->layout->og_type = 'article';
        $this->layout->content = View::make('holiday.offers', compact('feriados'));
    }

    private function validateDiscountCoupon($display_code, $offers_options_ids){
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
            return $discount_coupon;
        }
        else{
            return NULL;
        }
    }

    private function logPagar($inputs, $error_message, $validation_message, $user_id, $user_email){
        $inputs['user_email'] = $user_email;
        $inputs['user_id'] = $user_id;
        $inputs['error_message'] = $error_message;
        $inputs['validation_message'] = $validation_message;

        Logs::debug(json_encode($inputs));
    }

    public function postPagar(){
        if(!Auth::check()){
            $error = 'Sua sessão expirou, faça login para finalizar sua compra.';
            Session::flash('error', $error);
            return Redirect::back()
                           ->withInput();
        }

        //get all user input
        $inputs = Input::all();
        // print('<pre>'); print_r($inputs); print('</pre>'); die();

        if(!isset($inputs['paymentCardEULA'])){
            $error = 'Para concluir sua compra é necessário aceitar o regulamento da oferta e os termos de uso.';
            Session::flash('error', $error);
            return Redirect::back()
                           ->withInput();
        }
        
        $rules = [
            'merchantreferencecode' => 'required',
            'donation' => 'required',
            'paymentCardEULA' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);

        if (!$validation->passes()){
            $this->logPagar($inputs, 'Nenhuma', $validation->messages(), Auth::user()->id, Auth::user()->email);
            return Redirect::back()
                            ->withInput()
                            ->withErrors($validation);
        }

        //organize some of the user inputs
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $braspag_order_id = $inputs['merchantreferencecode'];
        $donation = $inputs['donation'];
        $discount_coupon_code = $inputs['promoCode'];
        $total = 0;
        $qty_total = 0;
        $history = date('d/m/Y h:i:s').' - Transação iniciada.'."\r\n";
        $status = 'pendente';

        // as vezes houve uma tentativa de compra com o braspag order id que teve erros, 
        // mas o usuario permanece na mesma página (com o mesmo braspag order id), tal compra
        // deve ser deletada, para uma nova (sem erros) ser criada em seguida
        // Order::where('braspag_order_id', $braspag_order_id)->delete();

        $order = New Order;

        $order->user_id = $user_id;
        $order->braspag_order_id = $braspag_order_id;
        $order->donation = $donation;
        $order->history = $history;

        $order->save();

        $order_id = $order->id;

        $user_profile = Profile::where('user_id', $user_id)->first();

        $ids = array();
        $qties = array();
        $products = array();
        $vouchers = array();

        // get id and quantity of product user just ordered
        if(Input::has('add-quantity')){
            $ids = $inputs['opt-quantity'] + $inputs['add-quantity'];
            $ids = array_keys($ids);

            $qties = $inputs['opt-quantity'] + $inputs['add-quantity'];
            $qties = array_values($qties);
        }
        else{
            $ids = array_keys($inputs['opt-quantity']);
            $qties = array_values($inputs['opt-quantity']);
        }

        $offers_options = OfferOption::whereIn('id', $ids)->with(['offer', 'qty_sold', 'qty_sold_boletus'])->get(['id', 'offer_id', 'price_with_discount', 'title', 'subtitle', 'percent_off', 'voucher_validity_start', 'voucher_validity_end', 'price_with_discount', 'min_qty', 'max_qty']);

        // save the items the user ordered and calculate total
        foreach ($offers_options as $offer_option) {
            $qty_ordered = array_shift($qties); // pega o primeiro elemento de $qties e joga no final do próprio array $qties, além de obter o valor manipulado em si, claro
            $qty_sold = isset($offer_option->qty_sold{0})?$offer_option->qty_sold{0}->qty:0;
            $max_qty_allowed = $offer_option->max_qty - $qty_sold;

            if($qty_ordered > $max_qty_allowed){
                // ERRO: a quantidade comprada é maior que a quantidade permitida ou maior que a quantidade em estoque
                $error = 'A quantidade selecionada para a oferta "' . $offer_option->offer->title . '" é maior do que a quantidade em estoque.';
                $this->logPagar($inputs, $error, 'Nenhuma', Auth::user()->id, Auth::user()->email);

                Session::flash('error', $error);
                return Redirect::back()
                               ->withInput();
            }
            else{
                $products[] = '<a href="' . route('oferta', $offer_option->offer->slug) . '">' . $qty_ordered . ' x ' . $offer_option->offer->title . ' | ' . $offer_option->title . '</a>';

                // save each ordered item now to create vouchers later (case the order go successfully)
                for ($i = 0; $i < $qty_ordered; $i++) {
                    $voucher['status'] = 'pendente';
                    $voucher['order_id'] = $order_id;
                    $voucher['offer_option_id'] = $offer_option->id;
                    $voucher['display_code'] = $braspag_order_id . '-'. $offer_option->offer_id;
                    $voucher['name'] = $user_profile->first_name . ' ' . $user_profile->last_name;
                    $voucher['email'] = $user_email;
                    $voucher['price'] = $offer_option->price_with_discount;
                    
                    Voucher::create($voucher);
                }

                // sum the total
                $total += ($qty_ordered * $offer_option->price_with_discount);
                $qty_total += $qty_ordered;
            }
        }

        $coupon_discount_value = 0;
        $coupon_discount_id = NULL;

        // if user have entered a discount coupon code
        if($discount_coupon_code){
            $discount = $this->validateDiscountCoupon($discount_coupon_code, $ids);
            if($discount){
                $coupon_discount_value = $discount->value;
                $coupon_discount_id = $discount->id;
            }
        }

        $credit_discount_value = $user_profile->credit;

        // subtrate discounts and user credit from the total, calculating the total left
        if($coupon_discount_value < $total){
            $total -= $coupon_discount_value;

            if($credit_discount_value < $total){
                $total -= $credit_discount_value;
            }
            else{
                $credit_discount_value = $total;
                $total = 0;
            }
        }
        else{
            $coupon_discount_value = $total;
            $credit_discount_value = 0;
            $total = 0;
        }


        //*********************//
        //*********************//
        // paying for the order//
        //*********************//
        //*********************//

        ////////////////////////////////////////////////////////////////////////////
        // paying via user credits and/or discount coupon
        ////////////////////////////////////////////////////////////////////////////
        if($total <= 0){
            $order->status = 'pago';
            $order->total = 0.00;
            $order->credit_discount = $credit_discount_value;
            $order->coupon_discount = $coupon_discount_value;
            $order->coupon_id = $coupon_discount_id;
            $order->payment_terms = 'Créditos e/ou cupom de disconto';
            $order->history .= date('d/m/Y h:i:s').' - Pagamento feito completamente com créditos do usuário e/ou cupom de disconto'."\r\n";
            $order->save();
        }

        ////////////////////////////////////////////////////////////////////////////
        // paying via credti card
        ////////////////////////////////////////////////////////////////////////////
        else if($inputs['payment_type'] == 'credit_card'){
            $inputs['paymentCardCPF'] = preg_replace('/[^0-9]/', '', $inputs['paymentCardCPF']);
            $inputs['paymentCardPhone'] = preg_replace('/[^0-9]/', '', $inputs['paymentCardPhone']);
            $inputs['paymentCardNumber'] = preg_replace('/\D/', '', $inputs['paymentCardNumber']);

            $rules = [
                'paymentCardCPF' => 'required|digitsbetween:11,18',
                'paymentCardPhone' => 'required|digitsbetween:10,15',
                'paymentCardFlag' => 'required',
                'paymentCardNumber' => 'required',
                'paymentCardValidityMonth' => 'required|digits:2',
                'paymentCardValidityYear' => 'required|digits:4',
                'paymentCardCode' => 'required',
                'paymentCardName' => 'required',
                'paymentCardInstallment' => 'required',
            ];

            $validation = Validator::make($inputs, $rules);

            if (!$validation->passes()){
                $this->logPagar($inputs, 'Nenhuma', $validation->messages(), Auth::user()->id, Auth::user()->email);
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validation);
            }

            $first_name = $user_profile->first_name;
            $last_name = $user_profile->last_name;
            $state = $user_profile->state;
            $email = Auth::user()->email;
            $passenger_telephone = $user_profile->telephone;
            $flag = $inputs['paymentCardFlag'];
            $number = $inputs['paymentCardNumber'];
            $month = $inputs['paymentCardValidityMonth'];
            $year = $inputs['paymentCardValidityYear'];
            $cod = $inputs['paymentCardCode'];
            $cpf_cnpj = $inputs['paymentCardCPF'];
            $telephone = $inputs['paymentCardPhone'];
            list($holder_fname, $holder_surname) = explode(" ", $inputs['paymentCardName'], 2);
            $installment = $inputs['paymentCardInstallment'];

            if($installment == 1){
                $interest_rate = 0;
                $card_boletus_rate = Configuration::get('card-tax-1x');
                $antecipation_rate = Configuration::get('antecipation-tax-1x');
            }
            else if($installment == 3){
                $interest_rate = Configuration::get('interest-rate-3x');
                $card_boletus_rate = Configuration::get('card-tax-3x');
                $antecipation_rate = Configuration::get('antecipation-tax-3x');
                $total = $total + ($total * $interest_rate);
            }
            else if($installment == 6){
                $interest_rate = Configuration::get('interest-rate-6x');
                $card_boletus_rate = Configuration::get('card-tax-6x');
                $antecipation_rate = Configuration::get('antecipation-tax-6x');
                $total = $total + ($total * $interest_rate);
            }
            else if($installment == 10){
                $interest_rate = Configuration::get('interest-rate-10x');
                $card_boletus_rate = Configuration::get('card-tax-10x');
                $antecipation_rate = Configuration::get('antecipation-tax-10x');
                $total = $total + ($total * $interest_rate);
            }
            else{
                $error = 'Número de parcelas inválido.';
                $this->logPagar($inputs, $error, 'Nenhuma', Auth::user()->id, Auth::user()->email);
                Session::flash('error', $error);
                return Redirect::back()
                               ->withInput();
            }

            $order->total = $total;
            $order->credit_discount = $credit_discount_value;
            $order->coupon_discount = $coupon_discount_value;
            $order->coupon_id = $coupon_discount_id;
            $order->interest_rate = $interest_rate;
            $order->card_boletus_rate = $card_boletus_rate;
            $order->antecipation_rate = $antecipation_rate;
            $order->holder_card = $inputs['paymentCardName'];
            $order->first_digits_card = substr($number, 0, 4);
            $order->cpf = $cpf_cnpj;
            $order->telephone = $telephone;
            $order->payment_terms = 'Cartão de crédito - ' . $flag . ' - ' . $installment . 'x';

            $order->save();

            /////////////////////////////////////
            /////////////////////////////////////
            require_once app_path().'/braspag/vars.php';
            /////////////////////////////////////
            /////////////////////////////////////

            /////////////////////////////////////////////////
            /////////////////////////////////////////////////
            require_once app_path().'/braspag/pagador/Braspag.php';
            /////////////////////////////////////////////////
            /////////////////////////////////////////////////

            $Braspag = new Braspag($ambiente_pagador);

            ///////////////
            //Customer
            ///////////////
            $Customer = new BraspagCustomerData();
            $Customer->setName($first_name . ' ' . $last_name);
            $Customer->setID($user_id);
            $Customer->setEmail($email);

            ///////////////
            // Credit card
            ///////////////
            $CreditCard = new BraspagCreditCardModel();

            //Capture transaction after authorization
            $CreditCard->setTransactionType(2);

            //Testing
            $CreditCard->setMethod(card_type_2_code($flag));

            //Order and payment info
            $CreditCard->setOrderId($braspag_order_id);
            $CreditCard->setCardNumber($number);
            $CreditCard->setCardHolder($holder_fname . ' ' . $holder_surname);
            $CreditCard->setCardExpirationDate($month, $year);
            $CreditCard->setCardSecurityCode($cod);
            $CreditCard->setCurrency('BRL');
            $CreditCard->setCountry('BRA');
            $CreditCard->setAmount(number_format(($total*100), 0, '', ''));
            $CreditCard->setPaymentPlan( (($installment == 1) ? 0 : 1) );
            $CreditCard->setNumberOfPayments($installment);
            $CreditCard->setSaveCreditCard(false);

            //Execute transaction
            $response = $Braspag->authorizeCreditCardTransaction($CreditCard, $Customer);
            
            if(isset($response->ErrorReportDataCollection->ErrorReportDataResponse->ErrorMessage)){
                $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 061). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                $returnBD = 'Ocorreu um erro na solicitação.';

                $order->status = $status = 'cancelado';
                $order->history .= $history = date('d/m/Y H:i:s') . " - Pagador: " . $returnBD . " (ReturnCode = ? e Status =  ? e ErrorMesage = ".(isset($response->ErrorReportDataCollection->ErrorReportDataResponse->ErrorMessage)?$response->ErrorReportDataCollection->ErrorReportDataResponse->ErrorMessage:'?').")"."\r\n";

                $order->save();

                Voucher::where('order_id', $order_id)->update(['status' => 'cancelado']);

                // ERRO, NAO APROVADO, ETC...
                Session::flash('error', $return);
                return Redirect::back()
                               ->withInput();
            }
            
            $braspag_id = $response->PaymentDataCollection->PaymentDataResponse->BraspagTransactionId;

            if($response->PaymentDataCollection->PaymentDataResponse->Status != 0 && $response->PaymentDataCollection->PaymentDataResponse->Status != 1){
            // if($response->PaymentDataCollection->PaymentDataResponse->Status != 1){
                switch ($response->PaymentDataCollection->PaymentDataResponse->ReturnCode) {
                  case '1':
                  case '2':
                    $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Transação negada. Referida.';
                    break;
                  case '3':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 016). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Transação negada. Estabelecimento inválido.';
                    break;
                  case '4':
                  case '5':
                  case '7':
                  case '41':
                  case '43':
                  case '51':
                  case '54':
                  case '55':
                  case '61':
                  case '62':
                  case '63':
                  case '65':
                  case '75':
                  case '82':
                  case '93':
                  case '94':
                    $return = 'Pagamento não autorizado. Por favor, verifique se todos os campos estão preenchidos corretamente. Se o erro persistir, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Transação negada.';
                    break;
                  case '6':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 017). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Problemas ocorridos na transação eletrônica.';
                    break;
                  case '12':
                  case '13':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 018). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Transação inválida.';
                    break;
                  case '14':
                    $return = 'Oops, parece que alguma informação do cartão está digitada errada. Por favor, verifique todas as informações e tente novamente.';
                    $returnBD = 'Cartão inválido.';
                    break;
                  case '15':
                  case '91':
                  case '98':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 019). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Emissor sem comunicação.';
                    break;
                  case '19':
                  case '86':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 020). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Refaça a transação.';
                    break;
                  case '21':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 021). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Transação não localizada.';
                    break;
                  case '22':
                    $return = 'Número de parcelas inválidas.';
                    $returnBD = 'Parcelamento inválido.';
                    break;
                  case '25':
                    $return = 'Número da conta inválido.';
                    $returnBD = 'Número do cartão não foi enviado.';
                    break;
                  case '28':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 022). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Arquivo indisponível.';
                    break;
                  case '52':
                    $return = 'Por favor, preencha todos os campos corretamente.';
                    $returnBD = 'Cartão com dígito de controle inválido.';
                    break;
                  case '53':
                    $return = 'Por favor, preencha todos os campos corretamente.';
                    $returnBD = 'Cartão inválido para essa operação.';
                    break;
                  case '57':
                    $return = 'Pagamento não autorizado. Por favor, verifique se todos os campos estão preenchidos corretamente. Se o erro persistir, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Transação não permitida.';
                    break;
                  case '76':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 023). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Problemas com número de referência da transação.';
                    break;
                  case '77':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 024). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Dados não conferem com mensagem original.';
                    break;
                  case '80':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 025). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Data inválida.';
                    break;
                  case '81':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 026). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Erro de criptografia.';
                    break;
                  case '83':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 027). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Erro no sistema de senhas.';
                    break;
                  case '85':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 044). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Erro métodos de criptografia.';
                    break;
                  case '96':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 028). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Falha no sistema.';
                    break;
                  case '99':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 029). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Emissor sem comunicação. SITEF. Ou divergência cadastral (Ex: liberação de parcelado).';
                    break;
                  case '05':
                  case '51':
                  case '57':
                    $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Mensagem Bancaria.';
                    break;
                  case '08':
                    $return = 'Código de segurança inválido.';
                    $returnBD = 'Cód de Seg Invalido.';
                    break;
                  case '54':
                    $return = 'Cartão expirado.';
                    $returnBD = 'Cartão Vencido.';
                    break;
                  case '78':
                    $return = 'Cartão bloqueado devido ao seu primeiro uso.';
                    $returnBD = 'Cartão Bloqueado 1º USO.';
                    break;
                  case '170':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 030). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Autenticação do Banco Bradesco -Cliente deve digitar agencia, conta e senha do internet Bank.';
                    break;
                  case '99':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 031). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Parcelamento loja não esta liberado.';
                    break;
                  case '96':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 032). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Venda abaixo de  R$ 1,00.';
                    break;
                  case '13':
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 033). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Valor da parcela inferior a R$ 5,00 (parcelado loja).';
                    break;
                  case '57':
                    $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Mensagem Bancaria- Oriente o cliente a entrar em contato com o banco.';
                    break;
                  case '5115':
                  case '5117':
                    $return = 'Pagamento não autorizado. Por favor, entre em contato com a operadora do cartão de crédito.';
                    $returnBD = 'Falha de autenticação - caso não possua a liberaçao de vendas internacionais contate a Visanet se possuir entre em contato com Banco emissor do cartão.';
                    break;
                  default:
                    $return = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 034). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $returnBD = 'Ocorreu um erro na solicitação.';
                    break;
                }

                $order->status = $status = 'cancelado';
                $order->braspag_id = $braspag_id;
                $order->history .= $history = date('d/m/Y H:i:s') . " - Pagador: " . $returnBD . " (ReturnCode = " . $response->PaymentDataCollection->PaymentDataResponse->ReturnCode . " e Status =  " . $response->PaymentDataCollection->PaymentDataResponse->Status . ")"."\r\n";

                $order->save();

                Voucher::where('order_id', $order_id)->update(['status' => 'cancelado']);

                // ERRO, NAO APROVADO, ETC...
                Session::flash('error', $return);
                return Redirect::back()
                               ->withInput();
            }
            
            $order->status = 'pago';
            $order->braspag_id = $braspag_id;
            $order->capture_date = date('Y-m-d H:i:s');
            $order->history .= date('d/m/Y H:i:s') . " - Pagador: Transação capturada"."\r\n";
            $order->save();

        }

        ////////////////////////////////////////////////////////////////////////////
        // paying via boletus
        ////////////////////////////////////////////////////////////////////////////
        else{
            $rules = [
                'paymentBoletoPhone' => 'required|digitsbetween:10,15',
            ];

            $validation = Validator::make($inputs, $rules);

            if (!$validation->passes()){
                $this->logPagar($inputs, 'Nenhuma', $validation->messages(), Auth::user()->id, Auth::user()->email);
                return Redirect::back()
                                ->withInput()
                                ->withErrors($validation);
            }

            $order->total = $total;
            $order->card_boletus_rate = Configuration::get('boletus-value');
            $order->credit_discount = $credit_discount_value;
            $order->coupon_discount = $coupon_discount_value;
            $order->coupon_id = $coupon_discount_id;
            $order->telephone = $inputs['paymentBoletoPhone'];
            $order->payment_terms = "Boleto";

            $order->save();

            //////////////////////////////////////
            require_once app_path().'/braspag/vars.php';
            //////////////////////////////////////

            ////////////////////////////////////////
            require_once app_path().'/braspag/nusoap.php';
            ////////////////////////////////////////

            $name = $user_profile->first_name . ' ' . $user_profile->last_name;

            $client = new nusoap_client($url_boleto, 'wsdl', '', '', '', '');
            $client->soap_defencoding = 'UTF-8';
            $client->decode_utf8 = false;

            $err = $client->getError();

            $param = array(
              'merchantId'   => $MerchantId,
              'customerName'   => $name,
              'orderId'   => $braspag_order_id,
              'amount'   => number_format($total, 2, ',', ''),
              'expirationDate' => date('d/m/y', strtotime('+1 day')),
              'paymentMethod'   => '06',
              'instructions' => 'Este boleto pode ser pago até o dia '.date('d/m/y', strtotime('+1 day')).'. Assim que o pagamento for efetuado e aprovado, seu cupom será liberado em sua conta. Obrigado por comprar no INNBatível!',
              'emails' => Auth::user()->email,
            );

            $result = $client->call('CreateBoleto', array('parameters' => $param), '', '', false, true);

            if ($client->fault) {
                $error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 039). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                $this->logPagar($inputs, $message, $client, Auth::user()->id, Auth::user()->email);
                Session::flash('error', $error);
                return Redirect::back()
                               ->withInput();
            } else {
              $err = $client->getError();
              if ($err) {
                $error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 040). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                $this->logPagar($inputs, $message, $err, Auth::user()->id, Auth::user()->email);
                Session::flash('error', $error);
                return Redirect::back()
                                ->withInput();
              } else {
                if($result['CreateBoletoResult']['status'] == NULL){
                    $error = 'Houve um erro ao processar o seu pagamento, tente novamente em alguns instantes (CÓD: 041). Se o erro persistir, entre em contato conosco pelo e-mail faleconosco@innbativel.com.br';
                    $this->logPagar($inputs, $message, $result, Auth::user()->id, Auth::user()->email);
                    Session::flash('error', $error);
                    return Redirect::back()
                                   ->withInput();
                }
              }
            }

            $boletus_url = $result['CreateBoletoResult']['url'];

            $order->braspag_id = $result['CreateBoletoResult']['boletoNumber'];
            $order->boleto = $boletus_url;
            $order->status = 'pendente';
            $order->history .= date('d/m/Y H:i:s') . " - Boleto emitido"."\r\n";

            $order->save();
        }

        // status final
        $status = $order->status;

        Voucher::where('order_id', $order_id)->update(['status' => $status]);
        
        // atualizar quantidade de discount_cupons usados, caso $discount != NULL, ou seja, caso o usuário tenha entrado com um cupom de desconto e ele tenha sido válido
        if(isset($discount) && $discount != NULL){
            $discount->qty_used++;
            $discount->save();
        }

        // atualizar creditos do usuario
        if($credit_discount_value > 0){
            $user_profile->credit -= $credit_discount_value;
            $user_profile->save();
        }

        // caso a venda tenha sido concretizada
        if($status == 'pago'){
            $products_email = '';
            
            foreach ($products as $product) {
                $products_email .= $product . '<br/>';
            }

            $products_email = substr($products_email, 0, -5);

            $data = array('name' => $user_profile->first_name, 'products' => $products_email);

            Mail::send('emails.order.order_approved', $data, function($message){
                $message->to(Auth::user()->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Compra finalizada com sucesso');
            });

            return Redirect::route('sucesso', array('status' => $status));
        }
        else if($status == 'pendente' AND isset($boletus_url)){
            $products_email = '';

            foreach ($products as $product) {
                $products_email .= $product . '<br/>';
            }

            $products_email = substr($products_email, 0, -5);

            $data = array('name' => $user_profile->first_name, 'products' => $products_email, 'boletus_url' => $boletus_url);

            Mail::send('emails.order.order_boletus', $data, function($message){
                $message->to(Auth::user()->email, 'INNBatível')->replyTo('faleconosco@innbativel.com.br', 'INNBatível')->subject('Sua compra no INNBatível');
            });

            return Redirect::route('sucesso', array('status' => $status, 'boletus_url' => base64_encode($boletus_url)));
        }
        else{
            return Redirect::route('sucesso', array('status' => $status));
        }
    }

    public function postBraspagReturn(){
        $server_addr = array(
            '10.144.84.94',
            '209.134.48.121',
            '209.235.236.174',
            '209.134.53.179',
            '209.235.236.162',
            '209.134.48.120',
            '209.235.236.164',
            '209.134.48.122',
            '209.134.48.211',
            '209.134.48.69',
            '209.134.53.185',
            '209.235.206.3',
            '209.134.53.180',
            '209.134.48.123',
            '209.235.236.161',
            '69.171.26.131',
            '69.171.26.132',
            '69.171.26.133',
            '69.171.26.134',
            '69.171.26.135',
            '69.171.26.136',
            '69.171.26.137',
            '69.171.26.138',
            '69.171.26.139',
            '69.171.26.140',
        );

        if (
          empty($_SERVER['HTTP_X_FORWARDED_FOR']) ||
          !in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $server_addr) ||
          // empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          // !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
          !isset($_POST) ||
          empty($_POST)
        ) {
          return Response::make('<status>Acesso Negado</status>', 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
        }

        $braspag_id = $_POST['NumPedido'];
        // $codpagamento = $_POST['CODPAGAMENTO'];

        $status = $_POST['Status'] == '0' ? 'pago' : 'cancelado' ;

        $order = Order::where('braspag_id', $braspag_id)->first();

        $user_id = $order->user_id;
        $order_id = $order->id;

        $order->historico .= date('d/m/Y H:i:s')." - Status alterado para ".$status.", atualizado pelo retorno da Braspag"."\r\n";
        $order->status = $status;
        $order->save();

        Voucher::where('order_id', $order_id)->update(['status' => $status]);

        Controller::call('AdminOrderController@sendTransactionalEmail', ['order' => $order, 'new_status' => $status]);

        return Response::make('<status>OK</status>', 200, array('Content-Type' => 'application/xml; charset=UTF-8'));
    }

    public function postValidateCoupon(){
        $this->layout = 'format.ajax';

        if(!Auth::check()){
            return Response::json(['error' => 1, 'error_message' => 'Sua sessão expirou. Atualize esta página e faça login novamente para visualziar seu cupom.']);
        }

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
        $q = e(Input::get('q'));
        if(empty($q)){
            return Redirect::route('home')->with('error', 'Digite um termo para sua busca');
        }
        $qArray = explode(' ', $q);
        foreach($qArray as $k => $v){
            if(strlen($v) < 3){
                unset($qArray[$k]);
            }
        }
        $tags = (!empty($qArray)) ? Tag::whereIn('title', $qArray)->lists('id') : [];
        $offers = Offer::query()
            ->select('offers.*')
            ->leftJoin('offers_options', 'offers.id', '=', 'offers_options.offer_id')
            ->leftJoin('destinies', 'offers.destiny_id', '=', 'destinies.id')
            ->leftJoin('offers_tags', 'offers.id', '=', 'offers_tags.offer_id')
            ->where(function($query) use ($q, $tags){
                $query->orWhere('offers.title','like', "%$q%")
                    ->orWhere('offers.subtitle','like', "%$q%")
                    ->orWhere('destinies.name','like', "%$q%");
                if(count($tags) > 0) $query->orWhereIn('offers_tags.tag_id', $tags);
            })
            ->orderBy('offers.display_order', 'asc')
            ->orderBy('offers.ends_on', 'asc')
            ->take(50)->distinct()->get(); // Repare que não deixamos o usuário fuçar em mais do que 50 ofertas por busca
        $offers->load('holiday', 'category', 'genre', 'genre2', 'destiny', 'included', 'offer_option');
        $total = count($offers);
        $categories = [];
        $destinies = [];
        $holidays = [];
        $dateStart = strtotime('+1 year');
        $dateEnd = time();
        $dates = [];
        $months = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez',
        ];
        if($total > 0){
            foreach($offers as $offer){
                // Categorias
                $categories[$offer->category->id]['slug'] = $offer->category->slug;
                $categories[$offer->category->id]['title'] = $offer->category->title;
                $categories[$offer->category->id]['total'] = (!isset($categories[$offer->category->id]['total'])) ? 1 : $categories[$offer->category->id]['total'] + 1;
                // Destinos
                $destinies[$offer->destiny->id]['name'] = $offer->destiny->name;
                $destinies[$offer->destiny->id]['total'] = (!isset($destinies[$offer->destiny->id]['total'])) ? 1 : $destinies[$offer->destiny->id]['total'] + 1;
                // Feriados
                foreach($offer->holiday as $h){
                    $holidays[$h->id]['title'] = $h->title;
                    $holidays[$h->id]['total'] = (!isset($holidays[$h->id]['total'])) ? 1 : $holidays[$h->id]['total'] + 1;
                }
                // Datas
                $dateMin = $offer->min_date;
                if($dateMin <= $dateStart) $dateStart = $dateMin;
                $dateMax = $offer->max_date;
                if($dateMax >= $dateEnd) $dateEnd = $dateMax;
            }
            // Para formar o filtro de datas
            while ($dateStart <= $dateEnd) {
                $dates[date('Ym', $dateStart)] = $months[date('n', $dateStart)].' '.date('Y', $dateStart);
                $dateStart = strtotime('+1 month', $dateStart);
            }
        }
        $this->layout->title = $q.' - INNBatível';
        $this->layout->description = 'No INNBatível você encontra as melhores ofertas de '.$q.', com preços INNBatíveis!';
        $this->layout->og_type = 'article';
        $this->layout->body_classes = 'search-page';
        $this->layout->content = View::make('pages.busca', compact('offers', 'q', 'total', 'categories', 'destinies', 'holidays', 'dates'));
    }

    /**
     * Show Minha Conta
     */
    public function anyMinhaConta()
    {
        $vouchers = Voucher::with('offer_option_offer', 'offer_option.offer')->whereExists(function($query){
            $query->select(DB::raw(1))
                ->from('orders')
                ->whereRaw('orders.id = vouchers.order_id')
                ->whereRaw('orders.user_id = '.Auth::user()->id);
        })
        ->orderBy('id', 'desc')
        ->get();
        $this->layout->title = 'Minha Conta no INNBatível';
        $this->layout->content = View::make('pages.minha-conta', compact('vouchers'));
    }
    /**
     * Troca a Senha do Usuário
     */
    public function postTrocarSenha()
    {
        $old = Input::get('pass');
        $new = Input::get('newpass');
        $new2 = Input::get('newpass2');
        if(strlen($new) < 6){
            return Redirect::route('minha-conta')->with('error', 'A nova senha deve ter pelo menos 6 caracteres');
        }
        $hash= Auth::user()->password;
        $user = User::findOrFail(Auth::user()->id);
        if(Hash::check($user->salt.$old, $user->password))
        {
            if($new === $new2)
            {
                $user->password = $new;
                $user->save();
                Session::flash('success', 'Senha alterada com sucesso');
                return Redirect::route('minha-conta');
            }
            else
            {
                return Redirect::route('minha-conta')->with('error', 'Os campos "Nova Senha" e "Repita Nova Senha" devem ser iguais');
            }
        }
        else
        {
            return Redirect::route('minha-conta')->with('error', 'Senha atual inválida');
        }
    }

    public function postOfferShare(){
        $this->layout = 'format.ajax';
        $data = [];
        $data['senderName'] = Input::get('senderName');
        $data['senderEmail'] = Input::get('senderEmail');
        $data['receiverName'] = Input::get('receiverName');
        $data['receiverEmail'] = Input::get('receiverEmail');
        $id = Input::get('offer');

        $offer = Offer::with('destiny')->find($id);
        $data['offer'] = $offer;

        if($offer){
            Mail::send('emails.offer_share', $data,
                function($message) use($data) {
                    $message->to($data['receiverEmail'], $data['receiverName'])
                            ->replyTo('faleconosco@innbativel.com.br', 'INNBatível')
                            ->subject('Uma sugestão INNBatível de '.$data['senderName']);
                }
            );
            return Response::json(['error' => 0]);
        }else{
            return Response::json(['error' => 1]);
        }
    }

    /**
     * Show Termos de uso
     */
    public function getViewVoucher($id)
    {   
        if(!Auth::check()){
            return Redirect::route('minha-conta')->with('error', 'Sua sessão expirou, faça login novamente para visualziar seu cupom.');
        }
        $id = base64_decode($id);
        $voucher = Voucher::with(['order_buyer', 'offer_partner'])
                          ->where('id', $id)
                          ->where('status', 'pago')
                          ->whereExists(function($query){
                                $query->select(DB::raw(1))
                                      ->from('orders')
                                      ->whereRaw('orders.id = vouchers.order_id')
                                      ->whereRaw('orders.user_id = '.Auth::user()->id);
                          })
                          ->whereExists(function($query){
                                $query->select(DB::raw(1))
                                      ->from('offers_options')
                                      ->whereRaw('offers_options.id = vouchers.offer_option_id')
                                      ->whereRaw('offers_options.voucher_validity_end >= "'.date('Y-m-d H:i:s').'"');
                          })
                          ->first()
                          ;
        // print('<pre>'); print_r($voucher->toArray()); print('<pre>'); die();
        if($voucher){
            return View::make('pages.cupom', compact('voucher'));
        }
        else{
            return Redirect::route('minha-conta')->with('error', 'Não foi possível exibir o seu cupom pois ele já foi expirado.');
        }
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

            // ENVIO DE EMAIL PARA A EQUIPE DO INNBatível
            Mail::send('emails.contact.send', $data,
                function($message) use ($name, $email){
                    $message->to("faleconosco@innbativel.com.br", 'INNBatível')
                            ->replyTo($email, $name)
                            ->subject('[INNBatível] Contato de '.$name);
                }
            );

            // ENVIO DE EMAIL PARA O USUÁRIO INFORMANDO QUE FOI RECEBIDO SEU CONTATO
            Mail::send('emails.contact.reply', $data,
                function($message) use ($name, $email){
                    $message->to($email, 'INNBatível')
                            ->replyTo('faleconosco@innbativel.com.br', 'INNBatível')
                            ->subject('[INNBatível] '.$name. ', recebemos seu contato.');
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

    public function postSuggestATrip(){
        $inputs = Input::all();

        $rules = [
            'name' => 'required|min:3', 
            'email' => 'required|email',
            'destiny' => 'required|min:2',
            'suggestion' => 'required|min:10'
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes())
        {
            SuggestATrip::create($inputs);

            //Início e-mail
            $name = $inputs['name'];
            $email = $inputs['email'];
            $destiny = $inputs['destiny'];
            $suggestion = $inputs['suggestion'];

            $data = array('name' => $name, 'email' => $email, 'destiny' => $destiny, 'suggestion' => $suggestion);

            //Manda e-mail
            Mail::send('emails.suggest.create', $data,
                function($message) use ($name, $email) {
                    $message->to('comercial@innbativel.com.br', 'INNBatível')
                            ->replyTo($email, $name)
                            ->subject('[INNBatível] Recebemos uma sugestão de '.$name);
                }
            );

            //Retorna para o cliente
            Mail::send('emails.suggest.reply', $data,
                function($message) use($name, $email){
                    $message->to($email, $email)
                            ->replyTo('comercial@innbativel.com.br', 'INNBatível')
                            ->subject('[INNBatível] '.$name.', recebemos sua sugestão');
                }
            );

            $this->layout = 'format.ajax';
            return Response::json(['error' => 0]);
        }

        /*
         * Return and display Errors
         */
        $this->layout = 'format.ajax';
        return Response::json(['error' => 1, 'message' => 'Ocorreu um erro. Por favor verifique os dados prencidos e tente novamente.']);
    }

    public function postTellUs(){
        $inputs = Input::all();

        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'destiny' => 'required',
            'img' => 'required|image',
            'travel_date' => 'required|date_format:d/m/Y',
            'depoiment' => 'required|min:30',
            'authorize' => 'accepted',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes()) {
            $img = $inputs['img'];
            $directory = 'conte_pra_gente';
            $img_name = $img->getClientOriginalName();

            $inputs['img'] = $img_name;
            $inputs['approved'] = false;
            unset($inputs['authorize']);

            $id = TellUs::create($inputs)->id;

            $img_url = ImageUpload::upload($img, $directory, $id, $img_name);

            //Início e-mail
            $name = $inputs['name'];
            $email = $inputs['email'];

            $data = [
                'name' => $inputs['name'], 
                'email' => $inputs['email'], 
                'destiny' => $inputs['destiny'], 
                'travel_date' => $inputs['travel_date'],
                'depoiment' => $inputs['depoiment'], 
                'img_url' => $img_url,
            ];

            //Manda e-mail
            Mail::send('emails.tellus.create', $data,
                function ($message) use ($name, $email) {
                    $message->to('contepragente@innbativel.com.br', 'INNBatível')
                            ->replyTo($email, $name)
                            ->subject('[INNBatível] Recebemos um depoimento de '.$name);
                }
            );

            //Retorna para o cliente
            Mail::send('emails.tellus.reply', $data,
                function ($message) use ($name, $email) {
                    $message->to($email, $name)
                            ->replyTo('contepragente@innbativel.com.br', 'INNBatível')
                            ->subject('[INNBatível] '.$name.', recebemos seu depoimento');
                }
            );

            Input::merge(['modal' => 'conte-pra-gente-response']);
            return Redirect::back()->withInput();
        }

        /*
         * Return and display Errors
         */
        Input::merge(['modal' => 'conte-pra-gente']);
        return Redirect::back()->withInput()->withErrors($validation);
    }

    public function postBeOurPartner(){
        $inputs = Input::all();

        $rules = [
            'parceiroFullName' => 'required|min:5', 
            'parceiroBusinessName' => 'required|min:5', 
            'parceiroEmail' => 'required|email', 
            'parceiroPhone' => 'required|digits_between:10,11',
            'parceiroCelular' => 'required|digits_between:10,11',
            'parceiroCEP' => 'required|digits_between:8,8',
            'parceiroAddress' => 'required',
            'parceiroAddressBairro' => 'required',
            'parceiroAddressCity' => 'required',
            'parceiroAddressState' => 'required',
            'parceiroURL' => 'required|url',
            'parceiroAbout' => 'required|between:30,200',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes())
        {
            $name = $inputs['parceiroBusinessName'];
            $email = $inputs['parceiroEmail'];

            //Manda e-mail
            Mail::send('emails.be_our_partner.create', $inputs,
                function($message) use($name, $email){
                    $message->to('comercial@innbativel.com.br', 'INNBatível')
                            ->replyTo($email, $name)
                            ->subject('[INNBatível] '.$name.' tem interesse em ser nosso parceiro');
                }
            );

            //Retorna para o cliente
            Mail::send('emails.be_our_partner.reply', $inputs,
                function($message) use($name, $email){
                    $message->to($email, $name)
                            ->replyTo('comercial@innbativel.com.br', 'INNBatível')
                            ->subject('[INNBatível] '.$name.', recebemos seu interesse em ser nosso parceiro');
                }
            );

            $this->layout = 'format.ajax';
            return Response::json(['error' => 0]);
        }

        /*
         * Return and display Errors
         */
        $this->layout = 'format.ajax';
        return Response::json(['error' => 1, 'message' => 'Ocorreu um erro. Por favor verifique os dados prencidos e tente novamente.']);
    }

    public function postWorkWithUs(){
        $inputs = Input::all();

        $rules = [
            'trabalheFullName' => 'required|min:5',
            'trabalheEmail' => 'required|email',
            'trabalheSexo' => 'required',
            'trabalhePhone' => 'required|digits_between:10,11',
            'trabalheCelular' => 'required|digits_between:10,11',
            'trabalheCEP' => 'required|digits_between:8,8',
            'trabalheAddress' => 'required',
            'trabalheAddressBairro' => 'required',
            'trabalheAddressCity' => 'required',
            'trabalheAddressState' => 'required',
            'trabalheAtuacao' => 'required',
            'trabalheCV' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes()) {
            $cv = $inputs['trabalheCV'];
            $directory = 'trabalhe_conosco';
            $id = Str::slug($inputs['trabalheEmail']).'_'.date('Y-m-d_H:i:s').'_'.uniqid("");
            $cv_name = $cv->getClientOriginalName();
            $inputs['trabalheCV'] = ImageUpload::upload($cv, $directory, $id, $cv_name);

            //Início e-mail
            $name = $inputs['trabalheFullName'];
            $email = $inputs['trabalheEmail'];

            //Manda e-mail
            Mail::send('emails.work_with_us.create', $inputs,
                function ($message) use ($name, $email) {
                    $message->to('trabalheconosco@innbativel.com.br', 'INNBatível')
                            ->replyTo($email, $name)
                            ->subject('[INNBatível] '.$name.' tem interesse em trabalhar conosco');
                }
            );

            //Retorna para o cliente
            Mail::send('emails.work_with_us.reply', $inputs,
                function ($message) use ($name, $email) {
                    $message->to($email, $name)
                            ->replyTo('trabalheconosco@innbativel.com.br', 'INNBatível')
                            ->subject('[INNBatível] '.$name.', recebemos seu interesse em trabalhar conosco');
                }
            );

            Input::merge(['modal' => 'trabalhe-conosco-response']);
            return Redirect::back()->withInput();
        }

        /*
         * Return and display Errors
         */
        Input::merge(['modal' => 'trabalhe-conosco']);
        return Redirect::back()->withInput()->withErrors($validation);
    }
}
