<?php

class PainelController extends BaseController {

    public function __construct()
    {
        $this->sidebar = true;
    }

    public function getDashboard()
    {
    	$this->layout->page_title = "Painel da Empresa Parceira";
        $this->layout->content = View::make('painel.dash.index');
    }
}

