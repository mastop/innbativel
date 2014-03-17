<?php

class AdminController extends BaseController {

	public function __construct()
	{
		$this->sidebar = true;
	}

	public function getDashboard()
	{
		$this->layout->content = View::make('admin.dash.index');
	}

}
