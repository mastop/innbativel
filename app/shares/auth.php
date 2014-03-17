<?php

$auth = null;

if (Auth::check()) {
	$auth = Auth::user();
}

View::share('auth', $auth);
