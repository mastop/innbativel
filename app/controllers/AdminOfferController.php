<?php

class AdminOfferController extends BaseController {

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

	/**
	 * Display all Perms.
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		/*
		 * Obj
		 */
		$offer = $this->offer;

		/*
		 * Paginate
		 */


    	$pag = Input::get('pag', 25);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['id']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('id')) {
			$offer = $offer->where('id', Input::get('id'));
		}

		if (Input::has('title')) {
			$offer = $offer->where('title', 'like', '%'. Input::get('title') .'%');
		}

		if (Input::has('genre_id')) {
			$offer = $offer->where('genre_id', Input::get('genre_id'));
		}

		if (Input::has('starts_on')) {
			$offer = $offer->where('starts_on', '>=', Input::get('starts_on'));
		}

		if (Input::has('ends_on')) {
			$offer = $offer->where('ends_on', '<=', Input::get('ends_on'));
		}

		/*
		 * Finally Obj
		 */
		$offer = $offer
			->with(['partner', 'destiny'])
			->select(['id', 'title', 'destiny_id', 'starts_on', 'ends_on'])
			->whereExists(function($query){
                if (Input::has('destiny')) {
					$query->select(DB::raw(1))
	                      ->from('destinies')
						  ->whereRaw('destinies.id = offers.destiny_id')
						  ->whereRaw('destinies.name LIKE "%'.Input::get('destiny').'%"');
				}

            })
			->orderBy($sort, $order)
			->paginate($pag)->appends([
				'sort' => $sort,
				'order' => $order,
				'id' => Input::get('id'),
				'destiny' => Input::get('destiny'),
				'title' => Input::get('title'),
				'genre_id' => Input::get('genre_id'),
				'starts_on' => Input::get('starts_on'),
				'ends_on' => Input::get('ends_on'),
				'pag' => Input::get('pag'),
			]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.list', compact('sort', 'order', 'pag', 'offer'));
	}

	/**
	 * Display Offer Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

        $s3access = Configuration::get('s3access');
        $s3secret = Configuration::get('s3secret');
        $s3region = Configuration::get('s3region');
        $s3bucket = Configuration::get('s3bucket');

        $s3 = Aws\S3\S3Client::factory(
            array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
        );

        $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

        $postObject = new Aws\S3\Model\PostObject($s3, $s3bucket, array('acl' => 'public-read', 'Cache-Control' => 'max-age=315360000', 'Content-Type' => '^', 'Expires' => $expires, "success_action_status" => "200"));
        $form = $postObject->prepareData()->getFormInputs();
        $policy = $form['policy'];
        $signature = $form['signature'];
        $uid = uniqid();

		$this->layout->page_title = 'Criar Oferta';
		$this->layout->content = View::make('admin.offer.create', compact('policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Create Offer.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
		if ($this->offer->passes() && $this->offer_option->passes(Input::get('offer_options')[0]))
		{
            // Cria a oferta
			$offer = $this->offer->create(Input::all());

            if($offer->id){
                // Insere as opções de venda
                $offer_options = Input::get('offer_options');

                $price_original = 0;
                $price_with_discount = 0;
                $percent_off = 0;


                foreach($offer_options as $k => $opt){
                    $opt['display_order'] = $k;
                    $opt['offer_id'] = $offer->id;
                    // A linha abaixo está comentada porque deste jeito não executa os Mutators
                    //$offer_option = $offer->offer_option()->create($opt);
                    $offer_option = $this->offer_option->create($opt);
                    // Verifica os valores de $offer_option para pegar o menor e depois jogar na oferta
                    if($price_with_discount == 0 || $offer_option->price_with_discount < $price_with_discount){
                        $price_original = $offer_option->price_original;
                        $price_with_discount = $offer_option->price_with_discount;
                        $percent_off = $offer_option->percent_off;
                    }
                }
                // Atualiza a oferta com os menores valores de offer_option
                $offer->price_original = $price_original;
                $offer->price_with_discount = $price_with_discount;
                $offer->percent_off = $percent_off;

                // Salva os itens inclusos
                $offers_included = Input::get('offers_included');
                if(is_array($offers_included)){
                    foreach($offers_included as $k => $v){
                        $offer->included()->attach($v, array('display_order' => $k));
                    }
                }

                // Salva as ofertas adicionais
                $offers_additional = explode(',', Input::get('offers_additional'));
                if(is_array($offers_additional)){
                    foreach($offers_additional as $k => $v){
                        $offer->offer_additional()->attach($v, array('display_order' => $k));
                    }
                }

                // Salva as Tags
                $offers_tags = explode(',', Input::get('offers_tags'));
                if(is_array($offers_tags)){
                    $tags = array();
                    foreach($offers_tags as $v){
                        if(is_numeric($v)){ // Se for número, joga no array $tags
                            $tags[] = $v;
                        }else{ // Se não for número, cria a tag primeiro e joga no array o ID
                            $tags[] = Tag::firstOrCreate(array('title' => $v))->id;
                        }
                    }
                    $offer->tag()->sync($tags);
                }

                // Salva os grupos
                $offers_groups = Input::get('offers_groups');
                if(is_array($offers_groups)){
                    foreach($offers_groups as $k => $v){
                        $offer->group()->attach($v, array('display_order' => $k));
                    }
                }

                // Salva os Feriados
                $offer->holiday()->sync(Input::get('offers_holidays'));

                // Salva o SaveMe
                $offers_saveme = Input::get('offers_saveme');
                if(is_array($offers_saveme)){
                    foreach($offers_saveme as $v){
                        $offer->saveme()->attach($v, array('priority' => Input::get('offers_saveme'.$v)));
                    }
                }

                // Salva as imagens da Oferta

                $s3access = Configuration::get('s3access');
                $s3secret = Configuration::get('s3secret');
                $s3region = Configuration::get('s3region');
                $s3bucket = Configuration::get('s3bucket');

                $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

                $s3 = Aws\S3\S3Client::factory(
                    array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
                );

                // Imagem Principal
                $cover_img = Input::get('cover_img');

                if($cover_img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($cover_img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$offer->slug}-cover.$ext";
                    $newpath = "ofertas/{$offer->id}/$newname";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$cover_img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $offer
                    $offer->cover_img = $newname;

                    // Criando o Thumb da imagem Principal
                    $result = $s3->getObject(array(
                        'Bucket' => $s3bucket,
                        'Key' => "$newpath"
                    ));
                    $thumb = Image::make($result['Body'])->resize(537, 224);
                    $s3->putObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => "ofertas/{$offer->id}/thumb/$newname",
                        'Body'   => $thumb->encode($ext, 65), // 65 é a Qualidade
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => $result['ContentType'],
                        'Expires'    => $expires
                    ));
                }

                // Imagem de Pré-Reserva
                $offer_old_img = Input::get('offer_old_img');

                if($offer_old_img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($offer_old_img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$offer->slug}-old.$ext";
                    $newpath = "ofertas/{$offer->id}/$newname";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$offer_old_img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $offer
                    $offer->offer_old_img = $newname;
                }

                // Imagem de Newsletter
                $newsletter_img = Input::get('newsletter_img');

                if($newsletter_img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($newsletter_img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$offer->slug}-newsletter.$ext";
                    $newpath = "ofertas/{$offer->id}/$newname";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$newsletter_img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $offer
                    $offer->newsletter_img = $newname;
                }

                // Imagem SaveMe
                $saveme_img = Input::get('saveme_img');

                if($saveme_img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($saveme_img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$offer->slug}-saveme.$ext";
                    $newpath = "ofertas/{$offer->id}/$newname";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$saveme_img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $offer
                    $offer->saveme_img = $newname;
                }

                // Demais imagens
                $offers_images = Input::get('offers_images');
                if(is_array($offers_images)){
                    foreach($offers_images as $k => $i){
                        if(!empty($i)){
                            // Pega a extensão da imagem
                            $ext = pathinfo($i, PATHINFO_EXTENSION);
                            // Cria um novo nome para a imagem
                            $newname = "{$offer->slug}-imagem-$k.$ext";
                            $newpath = "ofertas/{$offer->id}/$newname";
                            // Copia a imagem para o lugar definitivo
                            $s3->copyObject(array(
                                'Bucket'     => $s3bucket,
                                'Key'        => "$newpath",
                                'CopySource' => "{$s3bucket}/temp/{$i}",
                                'ACL'        => 'public-read',
                                'CacheControl' => 'max-age=315360000',
                                'ContentType' => '^',
                                'Expires'    => $expires
                            ));
                            // Coloca a nova imagem em $offer
                            $offer->offer_image()->create(array('url' => $newname));
                        }
                    }
                }
                // Update na oferta
                $offer->save();
                Session::flash('success', 'Oferta <b>#'.$offer->id.' - '.$offer->title.'</b> criada com sucesso.');
                return Redirect::route('admin.offer');
            }
		}

        Session::flash('error', 'Erro ao salvar oferta no banco de dados. Verifique o formulário abaixo e tente novamente.');

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.offer.create')
			->withInput()
			->withErrors($this->offer->errors());
	}

	/**
	 * Display Offer Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$offer = $this->offer->find($id);

		if (is_null($offer))
		{
            Session::flash('error', 'Oferta #'.$id.' não encontrada.');
			return Redirect::route('admin.offer');
		}

        $s3access = Configuration::get('s3access');
        $s3secret = Configuration::get('s3secret');
        $s3region = Configuration::get('s3region');
        $s3bucket = Configuration::get('s3bucket');

        $s3 = Aws\S3\S3Client::factory(
            array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
        );

        $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

        $postObject = new Aws\S3\Model\PostObject($s3, $s3bucket, array('acl' => 'public-read', 'Cache-Control' => 'max-age=315360000', 'Content-Type' => '^', 'Expires' => $expires, "success_action_status" => "200"));
        $form = $postObject->prepareData()->getFormInputs();
        $policy = $form['policy'];
        $signature = $form['signature'];
        $uid = uniqid();

        $holidays = $offer->holiday()->lists('holiday_id');
        $groups = $offer->group()->lists('group_id');
        $savesme = $offer->saveme()->lists('priority', 'saveme_id');
        $this->layout->page_title = 'Editando Oferta #'.$offer->id.' '.$offer->title;
        $this->layout->content = View::make('admin.offer.edit', compact('offer', 'policy', 'signature', 'uid', 's3bucket', 's3access', 'expires', 'holidays', 'groups', 'savesme'));
	}

	/**
	 * Update Offer.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::all();

	    $validation = Validator::make($inputs, Offer::$rules);

		if ($validation->passes())
		{
			$offer = $this->offer->find($id);

			if ($offer)
			{
				$cover_img = ImageUpload::createFrom(Input::file('cover_img'), Config::get('upload.offer'));

				$inputs['cover_img'] = $cover_img;

				$offer->update($inputs);
			}

			return Redirect::route('admin.offer');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('admin.offer.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Offer Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$offer = $this->offer->find($id);

		if (is_null($offer))
		{
			return Redirect::route('admin.offer');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta offeruração? Esta operação não poderá ser desfeita.');

		$data['offerData'] = $offer->toArray();
		$data['offerArray'] = null;

		foreach ($data['offerData'] as $key => $value) {
			$data['offerArray'][Lang::get('offer.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.offer.delete', $data);
	}

	// /**
	//  * Delete Offer.
	//  *
	//  * @return Response
	//  */

	// public function postDelete($id)
	// {
	// 	$this->offer->find($id)->delete();

	// 	Session::flash('success', 'Papel de usuário excluído com sucesso.');

	// 	return Redirect::route('admin.offer');
	// }

	// public function getClearfield($id, $field)
	// {
	// 	$offer = $this->offer->find($id);

	// 	if (is_null($offer) || !isset($field))
	// 	{
	// 		return Redirect::route('admin.offer.edit', $id);
	// 	}

	// 	$toDelete = $offer->{$field};

	// 	if (is_array($toDelete)) {
	// 		foreach ($toDelete as $item) {
	// 			$path = public_path() . $item;
	// 			if (File::exists($path)) {
	// 				File::delete($path);
	// 			}
	// 		}
	// 	}

	// 	$offer->{$field} = null;
	// 	$offer->save();

	// 	Session::flash('success', 'O campo '. $field .' pode ser editado agora.');

	// 	return Redirect::route('admin.offer.edit', $id);
	// }

	public function getSort(){
		/*
		 * Obj
		 */
		$offerObj = $this->offer;

		/*
		 * Finally Obj
		 */
		$offers = $offerObj->orderBy('display_order', 'asc')
						   // ->where('ends_on', '>=', date("Y-m-d H:i:s"))
						   ->get();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.sort', compact('offers'));
	}

	public function postSort(){
		$offers = Input::get('offers');

		foreach ($offers as $display_order => $id) {
			$o = Offer::find($id);
			$o->display_order = $display_order;
			$o->save();
		}

		return Redirect::route('admin.offer.sort');
	}

	public function getSortComment($id){
		/*
		 * Obj
		 */
		$offer = $this->offer->with(['comment'])->where('id', $id)->first();

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('admin.offer.sort_comment', compact('offer'));
	}

	public function postSortComment($offer_id){
		$comments = Input::get('comments');

		foreach ($comments as $display_order => $id) {
			$c = Comment::find($id);
			$c->display_order = $display_order;
			$c->save();
		}

		return Redirect::route('admin.offer.sort_comment', $offer_id);
	}

	public function getNewsletter(){
		$offers = $this->offer/*->where('starts_on', '<=', date('Y-m-d H:i:s'))
		             		   ->where('ends_on', '>=', date('Y-m-d H:i:s'))*/->get();

		/*
		* Layout / View
		*/
		$this->layout->content = View::make('admin.offer.newsletter', compact('offers'));
	}

	public function postNewsletter(){
        $title = Input::get('title');

        $input = Input::get('input');
        $text = Input::get('text');
        $button = Input::get('button');

		$allOffers = Input::get('offers');
		$selected_offers = Input::get('selected_offers');

        $n=1;
        foreach ($allOffers as $offer) {
            $ids[$n] = array();

            foreach ($offer as $display_order => $id) {
                if (isset($selected_offers[$n][$display_order])) {
                    $ids[$n][] = $display_order;
                }
		    }
            $offers[$n] = Array();

            If (count($ids[$n]) != 0 ) {
                $query = 'SELECT o.*, oo.price_original,oo.price_with_discount, oo.percent_off, oo.min_qty, g.title descricao ';
                $query .= ' FROM offers o ';
                $query .= ' LEFT JOIN offers_options oo ';
                $query .= ' ON o.id = oo.offer_id ';
                $query .= ' LEFT JOIN offers_groups og ';
                $query .= ' ON o.id = og.offer_id ';
                $query .= ' LEFT JOIN groups g ';
                $query .= ' ON g.id = og.group_id ';
                $query .= ' WHERE oo.id IN ((SELECT id FROM offers_options ';
                $query .= ' WHERE offer_id = o.id ';
                $query .= ' ORDER BY price_with_discount ';
                $query .= ' LIMIT 1),\'\') AND ';
                $query .= ' o.id IN (' . implode(',', $ids[$n]) . ') ';
                $query .= ' GROUP BY o.id, g.title ';
                $query .= ' ORDER BY g.title, FIELD(o.id, ' . implode(',', $ids[$n]) . ') ASC';

                $offers[$n] = DB::select(DB::raw($query));
            }
            $n++;
        }

        $send = Array('title'=> $title, 'input' => $input, 'text' => $text, 'button' => $button, 'offers' =>$offers);

        $html = Response::view('emails.newsletter_' . Input::get('system'), compact('send'));

		// print('<pre>');
		// print_r($offers);
		// print('</pre>'); die();

		/*
		* Layout / View
		*/

		return View::make('emails.newsletter_'.Input::get('system'), compact('send'));
		// $this->layout->content = View::make('admin.newsletter.html', compact('html'));
    }

}
