<?php

// Menu::handler('topmenu', array('id' => 'top-menu', 'class' => 'top-menu'));

// if (Auth::check()) {
// 	Menu::handler('usermenu', array('class' => 'dropdown-menu'))
// 		->add('#', '<i class="icon-user"></i>Profile')
// 		->add(route('logout'), '<i class="icon-remove"></i>Logout');

// 	if (isset(Auth::user()->profile->name)) {
// 		$username = Auth::user()->profile->name;
// 	}
// 	else
// 	{
// 		$username = Auth::user()->email;
// 	}

// 	Menu::handler('topmenu')
// 	->add('#', null, null, ['class' => 'fullview'])
// 	// ->add('#', null, null, ['class' => 'showmenu'])
// 	// ->add('#', '<i class="new-message"></i>', null, ['class' => 'messages'])
// 	->add('#', '<img src="'. asset('assets/themes/floripa/backend/img/userpic.png'). '" alt=""><span>'. $username .' <b class="caret"></b></span>',
// 		Menu::handler('usermenu'), ['class' => 'user-menu', 'data-toggle' => 'dropdown']);
// }
