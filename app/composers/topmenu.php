<?php

View::composer('menu.top', function($view)
{
    if (isset(Auth::user()->profile->name)) {
        $username = Auth::user()->profile->name;
    }
    else
    {
       $username = Auth::user()->email;
    }

    $view->with(compact('username'));
});
