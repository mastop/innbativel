<?php

Menu::handler('breadcrumb', array('id' => 'breadcrumbs', 'class' => 'breadcrumb'))->add('/', 'Home');

$i = 1;

$uri = Request::segment($i);

while($uri != '')
{
	$prep_link = '';

	for($j = 1; $j <= $i; $j++)
	{
		$prep_link .= Request::segment($j).'/';
	}

	$label = Request::segment($i);

	if (is_numeric($label)) {
		$title = Lang::get('breadcrumb.default');
	}
	else
	{
		$title = Lang::get('breadcrumb.'. $label);
	}

	Menu::handler('breadcrumb')->add($prep_link, $title);

	$i++;

	$uri = Request::segment($i);

}
