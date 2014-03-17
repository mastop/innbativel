<?php

View::composer('menu.breadcrumb', function($view)
{
    $i = 1;

    $uri = Request::segment($i);

    $bread = [];

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

        $bread[$title] = url($prep_link);

        $i++;

        $uri = Request::segment($i);
    }

    $view->with(compact('bread'));
});
