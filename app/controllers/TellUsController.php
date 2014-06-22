<?php

class TellUsController extends BaseController
{

    /**
     * Be our tellus Repository
     *
     * @var Be our tellus
     */
    protected $tellus;

    /**
     * Constructor
     */
    public function __construct(TellUs $tellus)
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

        $this->actions = 'tellus';

        /*
         * Set Be our tellus Instance
         */

        $this->tellus = $tellus;

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
        $tellus = $this->tellus;

        /*
         * Paginate
         */

        $pag = Input::get('pag', 50);

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
            $tellus = $tellus->where('name', 'like', '%' . Input::get('name') . '%');
        }

        if (Input::has('email')) {
            $tellus = $tellus->where('email', 'like', '%' . Input::get('email') . '%');
        }

        if (Input::has('destiny')) {
            $tellus = $tellus->where('destiny', 'like', '%' . Input::get('destiny') . '%');
        }

        if (Input::has('tellusion')) {
            $tellus = $tellus->where('tellusion', 'like', '%' . Input::get('tellusion') . '%');
        }

        /*
         * Finally Obj
         */
        $tellus = $tellus->orderBy($sort, $order)->paginate($pag)->appends([
            'sort' => $sort,
            'order' => $order,
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'destiny' => Input::get('destiny'),
            'tellusion' => Input::get('tellusion'),
        ]);

        /*
         * Layout / View
         */
        $this->layout->content = View::make('tellus.list', compact('sort', 'order', 'pag', 'tellus'));
    }

    /**
     * Display Be our tellus Create Page.
     *
     * @return Response
     */

    public function getCreate()
    {
        /*
         * Layout / View
         */

        $this->layout->content = View::make('tellus.create');

        $this->actions = 'tellus.create';
    }

    /**
     * Create Be our tellus.
     *
     * @return Response
     */

    public function postCreate()
    {

        //$this->actions = 'tellus.save';

        $inputs = Input::all();

        $rules = [
            'name' => 'required',
            'email' => 'required',
            'destiny' => 'required',
            'travelDate' => 'required',
            'deppoiment' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes()) {
            //$this->tellus->create($inputs);
            //Início e-mail
            $name = $inputs['name'];
            $email = $inputs['email'];
            $destiny = $inputs['destiny'];
            $travelDate = $inputs['travelDate'];
            $deppoiment = $inputs['deppoiment'];
            // $photo = $inputs['photo'];
            //$video = $inputs['video'];
            $authorize = array_key_exists('authorize',$inputs);


            $data = array('name' => $name, 'email' => $email, 'destiny' => $destiny, 'travelDate' => $travelDate,
                'deppoiment' => $deppoiment, /* 'photo'=>$photo, 'video'=>$video,*/
                'authorize' => $authorize);

            //Manda e-mail
            Mail::send('emails.tellus.create', $data,
                function ($message) use ($name, $email) {
                    $message->to('leohkume@hotmail.com', 'INNBatível')
                        ->setSubject('[INNBatível] ' . $name . ', recebemos um depoimento.'
                        );
                }
            );

            //Retorna para o cliente
            Mail::send('emails.tellus.reply', $data,
                function ($message) use ($name, $email) {
                    $message->to($email, 'INNBatível')
                        ->setSubject('[INNBatível] ' . $name . ', recebemos seu depoimento.'
                        );
                }
            );

            //Mostra mensagem de salvo com sucesso
            Session::flash('success', 'Seu depoimento foi enviado com sucesso!');
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
     * Display Be our tellus Create Page.
     *
     * @return Response
     */

    public function getEdit($id)
    {
        $tellus = $this->tellus->find($id);

        if (is_null($tellus)) {
            return Redirect::route('tellus');
        }

        /*
         * Layout / View
         */

        $this->layout->content = View::make('tellus.edit', compact('tellus'));
    }

    /**
     * Update Be our tellus.
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

        if ($validation->passes()) {
            $tellus = $this->tellus->find($id);

            if ($tellus) {
                $tellus->update($inputs);
            }

            return Redirect::route('tellus');
        }

        /*
         * Return and display Errors
         */
        return Redirect::route('tellus.edit', $id)
            ->withInput()
            ->withErrors($validation);
    }

    /**
     * Display Be our tellus Delete Page.
     *
     * @return Response
     */

    public function getDelete($id)
    {
        $tellus = $this->tellus->find($id);

        if (is_null($tellus)) {
            return Redirect::route('tellus');
        }

        Session::flash('error', 'Você tem certeza que deleja excluir esta sugestão de viagem? Esta operação não poderá ser desfeita.');

        $data['tellusData'] = $tellus->toArray();
        $data['tellusArray'] = null;

        foreach ($data['tellusData'] as $key => $value) {
            $data['tellusArray'][Lang::get('tellus.' . $key)] = $value;
        }

        /*
         * Layout / View
         */

        $this->layout->content = View::make('tellus.delete', $data);
    }

    /**
     * Delete Be our tellus.
     *
     * @return Response
     */

    public function postDelete($id)
    {
        $this->tellus->find($id)->delete();

        Session::flash('success', 'Sugestão de viagem excluída com sucesso.');

        return Redirect::route('tellus');
    }

}
