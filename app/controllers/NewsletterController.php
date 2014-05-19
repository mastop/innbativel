<?php

class NewsletterController extends BaseController {

    protected $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function postNewsletter()
    {
        //check if its our form
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Cadastro sem autorização'
            ));
        }

        $inputs = Input::all();

        $rules = [
            'name' => 'Required',
            'email' => 'Required|Max:255|Email',
        ];

        $validation = Validator::make($inputs, $rules);

        if ($validation->passes())
        {
            $newsletter = Newsletter::where('email', $inputs['email'])->count();
            if($newsletter == 0){
                $this->newsletter->create($inputs);
            }
            $response = array(
                'status' => 'success',
                'msg' => 'Cadastro efetuado com sucesso',
            );
        }else{
            $response = array(
                'status' => 'error',
                'msg' => 'Preencha os campos corretamente',
                $validation->errors()->toArray()
            );
        }

        return Response::json( $response );
    }
}
