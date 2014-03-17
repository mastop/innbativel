<?php

View::composer(['error.*'], function($view)
{
    $html_classes = '';
    $body_classes = '';
    $sidebar = null;
    $type = 'frontend';
    $seo = Config::get('seo');

    $view->with(compact([
        'html_classes',
        'body_classes',
        'sidebar',
        'type',
        'seo',
    ]));
});