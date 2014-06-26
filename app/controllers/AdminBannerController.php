<?php

class AdminBannerController extends BaseController {

	/**
	 * Banner Repository
	 *
	 * @var Banner
	 */
	protected $banner;

	/**
	 * Constructor
	 */
	public function __construct(Banner $banner)
	{
		/*
		 * Set BANNER Instance
		 */

		$this->banner = $banner;

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
		$banner = $this->banner->select(['id', 'title', 'img', 'link', 'clicks', 'is_active']);

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['title', 'is_active']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('title')) {
			$banner = $banner->where('title', 'like', '%'. Input::get('title') .'%');
		}


		if (Input::has('is_active') && Input::get('is_active') !== '-1') {
			$banner = $banner->where('is_active', '=', Input::get('is_active'));
		}

		/*
		 * Finally Obj
		 */
		$banner = $banner->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'title' => Input::get('title'),
			'is_active' => Input::get('is_active'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar Banners';
		$this->layout->content = View::make('admin.banner.list', compact('sort', 'order', 'pag', 'banner'));
	}

	/**
	 * Display BANNER Create Page.
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

        $this->layout->page_title = 'Criar Banner';
		$this->layout->content = View::make('admin.banner.create', compact('policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Create BANNER.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
        if ($this->banner->passes())
        {
            // Cria o Banner
            $banner = $this->banner->create(Input::all());
            if($banner->id){
                $s3access = Configuration::get('s3access');
                $s3secret = Configuration::get('s3secret');
                $s3region = Configuration::get('s3region');
                $s3bucket = Configuration::get('s3bucket');

                $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

                $s3 = Aws\S3\S3Client::factory(
                    array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
                );
                // Imagem Principal
                $img = Input::get('img');

                if($img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newtitle = "{$banner->id}.$ext";
                    $newpath = "banners/{$banner->id}/$newtitle";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $banner
                    $banner->img = $newtitle;

                    // Criando o Thumb da imagem
//                    $result = $s3->getObject(array(
//                        'Bucket' => $s3bucket,
//                        'Key' => "$newpath"
//                    ));
//                    $thumb = Image::make($result['Body'])->resize(100, 50);
//                    $s3->putObject(array(
//                        'Bucket' => $s3bucket,
//                        'Key'    => "banners/{$banner->id}/thumb/$newtitle",
//                        'Body'   => $thumb->encode($ext, 65), // 65 é a Qualidade
//                        'ACL'        => 'public-read',
//                        'CacheControl' => 'max-age=315360000',
//                        'ContentType' => $result['ContentType'],
//                        'Expires'    => $expires
//                    ));
                }
                // Update no Banner
                $banner->save();
                Session::flash('success', 'Banner <b>#'.$banner->id.' - '.$banner->title.'</b> criada com sucesso.');
                return Redirect::route('admin.banner');
            }
        }
        Session::flash('error', 'Erro ao salvar Banner no banco de dados. Verifique o formulário abaixo e tente novamente.');

        /*
         * Return and display Errors
         */
        return Redirect::route('admin.banner.create')
            ->withInput()
            ->withErrors($this->banner->errors());
	}

	/**
	 * Display BANNER Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$banner = $this->banner->find($id);

		if (is_null($banner))
		{
            Session::flash('error', 'Banner #'.$id.' não encontrado.');
			return Redirect::route('admin.banner');
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

        $this->layout->page_title = 'Editando Banner #'.$banner->id.' '.$banner->title;

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.banner.edit', compact('banner', 'policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Update BANNER.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
        if ($this->banner->passes())
        {
            // Pega a oferta
            $banner = $this->banner->find($id);
            if($banner){
                // Salva o Banner
                $banner->update(Input::except(array('img')));

                // Atualiza a imagem do Banner

                $s3access = Configuration::get('s3access');
                $s3secret = Configuration::get('s3secret');
                $s3region = Configuration::get('s3region');
                $s3bucket = Configuration::get('s3bucket');

                $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

                $s3 = Aws\S3\S3Client::factory(
                    array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
                );

                $img = Input::get('img');

                if(substr($img, 0, 2) != '//'){
                    // Deleta a imagem velha
                    $imagem_velha = "banners/{$banner->id}/{$banner->getOriginal('img')}";
                    //$imagem_velha_thumb = "banners/{$banner->id}/thumb/{$banner->getOriginal('img')}";
                    $s3->deleteObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => $imagem_velha
                    ));
//                    $s3->deleteObject(array(
//                        'Bucket' => $s3bucket,
//                        'Key'    => $imagem_velha_thumb
//                    ));

                    // Envia a nova imagem

                    // Pega a extensão da imagem
                    $ext = pathinfo($img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newtitle = "{$banner->id}.$ext";
                    $newpath = "banners/{$banner->id}/$newtitle";
                    // Copia a imagem para o lugar definitivo
                    $s3->copyObject(array(
                        'Bucket'     => $s3bucket,
                        'Key'        => "$newpath",
                        'CopySource' => "{$s3bucket}/temp/{$img}",
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => '^',
                        'Expires'    => $expires
                    ));
                    // Coloca o novo nome da imagem em $banner
                    $banner->img = $newtitle;

                    // Criando o Thumb da imagem
//                    $result = $s3->getObject(array(
//                        'Bucket' => $s3bucket,
//                        'Key' => "$newpath"
//                    ));
//                    $thumb = Image::make($result['Body'])->resize(100, 50);
//                    $s3->putObject(array(
//                        'Bucket' => $s3bucket,
//                        'Key'    => "banners/{$banner->id}/thumb/$newtitle",
//                        'Body'   => $thumb->encode($ext, 65), // 65 é a Qualidade
//                        'ACL'        => 'public-read',
//                        'CacheControl' => 'max-age=315360000',
//                        'ContentType' => $result['ContentType'],
//                        'Expires'    => $expires
//                    ));
                }
                // Update no Banner
                $banner->is_active = Input::get('is_active', 0);
                $banner->save();
                Session::flash('success', 'Banner <b>#'.$banner->id.' - '.$banner->title.'</b> atualizado com sucesso.');
                return Redirect::route('admin.banner');
            }else{
                Session::flash('error', 'Banner <b>#'.$id.'</b> não encontrado.');
                return Redirect::route('admin.banner');
            }
        }
        Session::flash('error', 'Erro ao salvar Banner no banco de dados. Verifique o formulário abaixo e tente novamente.');

        /*
         * Return and display Errors
         */
        return Redirect::route('admin.banner.edit', $id)
            ->withInput()
            ->withErrors($this->banner->errors());
	}

	/**
	 * Display BANNER Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$banner = $this->banner->find($id);

        if (is_null($banner))
        {
            Session::flash('error', 'Banner #'.$id.' não encontrado.');
            return Redirect::route('admin.banner');
        }

		Session::flash('error', 'Você tem certeza que deleja excluir este Banner? Esta operação não poderá ser desfeita.');

		$data['bannerData'] = $banner->toArray();
		$data['bannerArray'] = null;

		foreach ($data['bannerData'] as $key => $value) {
			$data['bannerArray'][Lang::get('banner.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Excluir Banner #'.$banner->id.' '.$banner->title;

		$this->layout->content = View::make('admin.banner.delete', $data);
	}

	/**
	 * Delete BANNER.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
        $banner = $this->banner->find($id);

        if (is_null($banner))
        {
            Session::flash('error', 'Banner #'.$id.' não encontrado.');
            return Redirect::route('admin.banner');
        }

        $s3access = Configuration::get('s3access');
        $s3secret = Configuration::get('s3secret');
        $s3region = Configuration::get('s3region');
        $s3bucket = Configuration::get('s3bucket');

        $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

        $s3 = Aws\S3\S3Client::factory(
            array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
        );

        // Deleta a imagem
        $imagem = "banners/{$banner->id}/{$banner->getOriginal('img')}";
        $imagem_thumb = "banners/{$banner->id}/thumb/{$banner->getOriginal('img')}";
        $s3->deleteObject(array(
            'Bucket' => $s3bucket,
            'Key'    => $imagem
        ));
        $s3->deleteObject(array(
            'Bucket' => $s3bucket,
            'Key'    => $imagem_thumb
        ));

		$banner->delete();

		Session::flash('success', 'Banner excluído com sucesso.');

		return Redirect::route('admin.banner');
	}
}
