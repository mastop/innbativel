<?php

class PainelController extends BaseController {

    public function __construct()
    {
        $this->sidebar = true;
    }

    public function getDashboard()
    {
        $this->layout->content = View::make('painel.dash.index');
    }
}

