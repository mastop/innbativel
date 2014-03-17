<?php

View::composer(['error.*'], function($view)
{
    $html_classes = 'no-js';
    $body_classes = 'page-error';
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
