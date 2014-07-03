<?php

class AdminNgoController extends BaseController {

	/**
	 * NGO Repository
	 *
	 * @var NGO
	 */
	protected $ngo;

	/**
	 * Constructor
	 */
	public function __construct(Ngo $ngo)
	{
		/*
		 * Set NGO Instance
		 */

		$this->ngo = $ngo;

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
		$ngo = $this->ngo;

		/*
		 * Paginate
		 */

        $pag = Input::get('pag', 50);

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'description']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$ngo = $ngo->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('description')) {
			$ngo = $ngo->where('description', 'like', '%'. Input::get('description') .'%');
		}

		/*
		 * Finally Obj
		 */
		$ngo = $ngo->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'description' => Input::get('description'),
		]);

		/*
		 * Layout / View
		 */
        $this->layout->page_title = 'Gerenciar ONGs';
		$this->layout->content = View::make('admin.ngo.list', compact('sort', 'order', 'pag', 'ngo'));
	}

	/**
	 * Display NGO Create Page.
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

        $this->layout->page_title = 'Criar ONG';
		$this->layout->content = View::make('admin.ngo.create', compact('policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Create NGO.
	 *
	 * @return Response
	 */

	public function postCreate()
	{
        if ($this->ngo->passes())
        {
            // Cria a ONG
            $ngo = $this->ngo->create(Input::all());
            if($ngo->id){
                $s3access = Configuration::get('s3access');
                $s3secret = Configuration::get('s3secret');
                $s3region = Configuration::get('s3region');
                $s3bucket = Configuration::get('s3bucket');

                $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

                $s3 = Aws\S3\S3Client::factory(
                    array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
                );
                // Imagem Principal
                $img = urlencode(Input::get('img'));

                if($img){
                    // Pega a extensão da imagem
                    $ext = pathinfo($img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$ngo->id}.$ext";
                    $newpath = "ongs/{$ngo->id}/$newname";
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
                    // Coloca o novo nome da imagem em $ngo
                    $ngo->img = $newname;

                    // Criando o Thumb da imagem
                    $result = $s3->getObject(array(
                        'Bucket' => $s3bucket,
                        'Key' => "$newpath"
                    ));
                    $thumb = Image::make((string)$result['Body'])->resize(100, 50);
                    $s3->putObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => "ongs/{$ngo->id}/thumb/$newname",
                        'Body'   => $thumb->encode($ext, 65), // 65 é a Qualidade
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => $result['ContentType'],
                        'Expires'    => $expires
                    ));
                }
                // Update na ONG
                $ngo->save();
                Session::flash('success', 'ONG <b>#'.$ngo->id.' - '.$ngo->name.'</b> criada com sucesso.');
                return Redirect::route('admin.ngo');
            }
        }
        Session::flash('error', 'Erro ao salvar ONG no banco de dados. Verifique o formulário abaixo e tente novamente.');

        /*
         * Return and display Errors
         */
        return Redirect::route('admin.ngo.create')
            ->withInput()
            ->withErrors($this->ngo->errors());
	}

	/**
	 * Display NGO Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$ngo = $this->ngo->find($id);

		if (is_null($ngo))
		{
            Session::flash('error', 'ONG #'.$id.' não encontrada.');
			return Redirect::route('admin.ngo');
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

        $this->layout->page_title = 'Editando ONG #'.$ngo->id.' '.$ngo->name;

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('admin.ngo.edit', compact('ngo', 'policy', 'signature', 'uid', 's3bucket', 's3access', 'expires'));
	}

	/**
	 * Update NGO.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
        if ($this->ngo->passes())
        {
            // Pega a oferta
            $ngo = $this->ngo->find($id);
            if($ngo){
                // Salva a ong
                $ngo->update(Input::except(array('img')));

                // Atualiza a imagem da Ong

                $s3access = Configuration::get('s3access');
                $s3secret = Configuration::get('s3secret');
                $s3region = Configuration::get('s3region');
                $s3bucket = Configuration::get('s3bucket');

                $expires = gmdate("D, d M Y H:i:s T", strtotime("+5 years"));

                $s3 = Aws\S3\S3Client::factory(
                    array('key' => $s3access, 'secret' => $s3secret, 'region' => $s3region)
                );

                $img = urlencode(Input::get('img'));

                if(substr($img, 0, 2) != '//'){
                    // Deleta a imagem velha
                    $imagem_velha = "ongs/{$ngo->id}/{$ngo->getOriginal('img')}";
                    $imagem_velha_thumb = "ongs/{$ngo->id}/thumb/{$ngo->getOriginal('img')}";
                    $s3->deleteObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => $imagem_velha
                    ));
                    $s3->deleteObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => $imagem_velha_thumb
                    ));

                    // Envia a nova imagem

                    // Pega a extensão da imagem
                    $ext = pathinfo($img, PATHINFO_EXTENSION);
                    // Cria um novo nome para a imagem
                    $newname = "{$ngo->id}.$ext";
                    $newpath = "ongs/{$ngo->id}/$newname";
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
                    // Coloca o novo nome da imagem em $ngo
                    $ngo->img = $newname;

                    // Criando o Thumb da imagem
                    $result = $s3->getObject(array(
                        'Bucket' => $s3bucket,
                        'Key' => "$newpath"
                    ));
                    $thumb = Image::make((string)$result['Body'])->resize(100, 50);
                    $s3->putObject(array(
                        'Bucket' => $s3bucket,
                        'Key'    => "ongs/{$ngo->id}/thumb/$newname",
                        'Body'   => $thumb->encode($ext, 65), // 65 é a Qualidade
                        'ACL'        => 'public-read',
                        'CacheControl' => 'max-age=315360000',
                        'ContentType' => $result['ContentType'],
                        'Expires'    => $expires
                    ));
                }
                // Update na Ong
                $ngo->save();
                Session::flash('success', 'ONG <b>#'.$ngo->id.' - '.$ngo->name.'</b> atualizada com sucesso.');
                return Redirect::route('admin.ngo');
            }else{
                Session::flash('error', 'ONG <b>#'.$id.'</b> não encontrada.');
                return Redirect::route('admin.ngo');
            }
        }
        Session::flash('error', 'Erro ao salvar ONG no banco de dados. Verifique o formulário abaixo e tente novamente.');

        /*
         * Return and display Errors
         */
        return Redirect::route('admin.ngo.edit', $id)
            ->withInput()
            ->withErrors($this->ngo->errors());
	}

	/**
	 * Display NGO Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$ngo = $this->ngo->find($id);

        if (is_null($ngo))
        {
            Session::flash('error', 'ONG #'.$id.' não encontrada.');
            return Redirect::route('admin.ngo');
        }

		Session::flash('error', 'Você tem certeza que deleja excluir esta ONG? Esta operação não poderá ser desfeita.');

		$data['ngoData'] = $ngo->toArray();
		$data['ngoArray'] = null;

		foreach ($data['ngoData'] as $key => $value) {
			$data['ngoArray'][Lang::get('ngo.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

        $this->layout->page_title = 'Excluir ONG #'.$ngo->id.' '.$ngo->name;

		$this->layout->content = View::make('admin.ngo.delete', $data);
	}

	/**
	 * Delete NGO.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
        $ngo = $this->ngo->find($id);

        if (is_null($ngo))
        {
            Session::flash('error', 'ONG #'.$id.' não encontrada.');
            return Redirect::route('admin.ngo');
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
        $imagem = "ongs/{$ngo->id}/{$ngo->getOriginal('img')}";
        $imagem_thumb = "ongs/{$ngo->id}/thumb/{$ngo->getOriginal('img')}";
        $s3->deleteObject(array(
            'Bucket' => $s3bucket,
            'Key'    => $imagem
        ));
        $s3->deleteObject(array(
            'Bucket' => $s3bucket,
            'Key'    => $imagem_thumb
        ));

		$ngo->delete();

		Session::flash('success', 'ONG excluída com sucesso.');

		return Redirect::route('admin.ngo');
	}
}
