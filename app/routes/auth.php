<?php

/*
|
| Auth
|
*/
// Grupo de Routes que usam SSL

Route::group(array('https', 'after' => 'cache.public'), function()
{
Route::get  ('entrar',  ['as' => 'login',      'uses' => 'AuthController@getLogin']);
Route::post ('entrar',  ['as' => 'login.post', 'uses' => 'AuthController@postLogin']);
Route::get  ('sair', 	  ['as' => 'logout',     'uses' => 'AuthController@getLogout']);

Route::get  ('criar/conta',             ['as' => 'account.get',       'uses' => 'AuthController@getCreate']);
Route::post ('criar/conta',             ['as' => 'account.create',    'uses' => 'AuthController@postCreate']);

Route::get  ('recuperar/senha', 		    ['as' => 'password.remind',  	'uses' => 'AuthController@getRemind']);
Route::post ('recuperar/senha', 		    ['as' => 'password.request', 	'uses' => 'AuthController@postRequest']);
Route::get  ('recuperar/senha/{token}', ['as' => 'password.reset',   	'uses' => 'AuthController@getReset']);
Route::post ('recuperar/senha/{token}', ['as' => 'password.update',  	'uses' => 'AuthController@postUpdate']);

Route::get  ('entrar/facebook', 		['as' => 'login.facebook',      'uses' => 'AuthController@getFacebook']);
Route::get('facebook', ['as' => 'facebook', function()
{
    $destination = Input::get('destination', Session::get('destination', '/'));
    if(!Session::has('destination')){
        Session::put('destination', $destination);
    }
    $permissions = array(
        'email',
        'user_location',
        'user_birthday'
    );
    $helper = new Facebook();
    return Redirect::to($helper->getLoginUrl($permissions));
}]);

});