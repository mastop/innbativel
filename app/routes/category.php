<?php

Route::get('{slug}', ['as' => 'category.offer', 'uses' => 'CategoryController@anyCategory', 'after' => 'cache.public']);//->where('slug', '[A-Za-z]+');

