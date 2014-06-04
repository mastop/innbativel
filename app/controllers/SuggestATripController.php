<?php

class SuggestATripController extends BaseController {

	/**
	 * Suggest a trip Repository
	 *
	 * @var Suggest a trip
	 */
	protected $suggest;

	/**
	 * Constructor
	 */
	public function __construct(SuggestATrip $suggest)
	{
		/*
		 * Set Sidebar Status
		 */

		$this->sidebar = true;

        /*
        * Enable Sidebar
        */

        $this->sidebar = true;

        /*
         * Enable and Set Actions
         */

        $this->actions = 'suggest';

        /*
         * Set Suggest a trip Instance
         */

        $this->suggest = $suggest;

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
		$suggest = $this->suggest;

		/*
		 * Paginate
		 */

    	$pag = in_array(Input::get('pag'), ['5', '10', '25', '50', '100']) ? Input::get('pag') : '5';

		/*
		 * Sort filter
		 */

    	$sort = in_array(Input::get('sort'), ['name', 'email', 'destiny']) ? Input::get('sort') : 'id';

		/*
		 * Order filter
		 */

    	$order = Input::get('order') === 'desc' ? 'desc' : 'asc';

		/*
		 * Search filters
		 */
		if (Input::has('name')) {
			$suggest = $suggest->where('name', 'like', '%'. Input::get('name') .'%');
		}

		if (Input::has('email')) {
			$suggest = $suggest->where('email', 'like', '%'. Input::get('email') .'%');
		}

		if (Input::has('destiny')) {
			$suggest = $suggest->where('destiny', 'like', '%'. Input::get('destiny') .'%');
		}

		if (Input::has('suggestion')) {
			$suggest = $suggest->where('suggestion', 'like', '%'. Input::get('suggestion') .'%');
		}

		/*
		 * Finally Obj
		 */
		$suggest = $suggest->orderBy($sort, $order)->paginate($pag)->appends([
			'sort' => $sort,
			'order' => $order,
			'pag' => $pag,
			'name' => Input::get('name'),
			'email' => Input::get('email'),
			'destiny' => Input::get('destiny'),
			'suggestion' => Input::get('suggestion'),
		]);

		/*
		 * Layout / View
		 */
		$this->layout->content = View::make('suggest.list', compact('sort', 'order', 'pag', 'suggest'));
	}

	/**
	 * Display Suggest a trip Create Page.
	 *
	 * @return Response
	 */

	public function getCreate()
	{
		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('suggest.create');

        $this->actions = 'suggest.create';
	}

	/**
	 * Create Suggest a trip.
	 *
	 * @return Response
	 */

	public function postCreate()
	{

        $this->actions = 'suggest.save';

		$inputs = Input::all();

		$rules = [
        	'destiny' => 'required',
        	'name' => 'required',
        	'email' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$this->suggest->create($inputs);


            //Início e-mail
            $name = $inputs['name'];
            $email = $inputs['email'];
            $destiny = $inputs['destiny'];
            $suggestion = $inputs['suggestion'];

            $data = array('name' => $name, 'email' => $email, 'destiny' => $destiny, 'suggestion' => $suggestion);

            //Manda e-mail
            Mail::send('emails.suggest.create', $data,
                function($message) use($name, $email){
                    $message->to('leohkume@hotmail.com', 'INNBatível')
                        ->setSubject('[INNBatível] '.$name. ', recebemos uma sugestão.'
                        );
                }
            );

            //Retorna para o cliente
            Mail::send('emails.suggest.reply', $data,
                function($message) use($name, $email){
                    $message->to($email, 'INNBatível')
                        ->setSubject('[INNBatível] '.$name. ', recebemos sua sugestão.'
                        );
                }
            );

            //Mostra mensagem de salvo com sucesso
            Session::flash('success', 'Sugestão enviada com sucesso!');
            return Redirect::route("home");
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('home')
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Suggest a trip Create Page.
	 *
	 * @return Response
	 */

	public function getEdit($id)
	{
		$suggest = $this->suggest->find($id);

		if (is_null($suggest))
		{
			return Redirect::route('suggest');
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('suggest.edit', compact('suggest'));
	}

	/**
	 * Update Suggest a trip.
	 *
	 * @return Response
	 */

	public function postEdit($id)
	{
		/*
		 * Permuration
		 */
		$inputs = Input::all();

		$rules = [
        	'destiny' => 'required',
        	'name' => 'required',
        	'email' => 'required',
		];

	    $validation = Validator::make($inputs, $rules);

		if ($validation->passes())
		{
			$suggest = $this->suggest->find($id);

			if ($suggest)
			{
				$suggest->update($inputs);
			}

			return Redirect::route('suggest');
		}

		/*
		 * Return and display Errors
		 */
		return Redirect::route('suggest.edit', $id)
			->withInput()
			->withErrors($validation);
	}

	/**
	 * Display Suggest a trip Delete Page.
	 *
	 * @return Response
	 */

	public function getDelete($id)
	{
		$suggest = $this->suggest->find($id);

		if (is_null($suggest))
		{
			return Redirect::route('suggest');
		}

		Session::flash('error', 'Você tem certeza que deleja excluir esta sugestão de viagem? Esta operação não poderá ser desfeita.');

		$data['suggestData'] = $suggest->toArray();
		$data['suggestArray'] = null;

		foreach ($data['suggestData'] as $key => $value) {
			$data['suggestArray'][Lang::get('suggest.'. $key)] = $value;
		}

		/*
		 * Layout / View
		 */

		$this->layout->content = View::make('suggest.delete', $data);
	}

	/**
	 * Delete Suggest a trip.
	 *
	 * @return Response
	 */

	public function postDelete($id)
	{
		$this->suggest->find($id)->delete();

		Session::flash('success', 'Sugestão de viagem excluída com sucesso.');

		return Redirect::route('suggest');
	}

}
