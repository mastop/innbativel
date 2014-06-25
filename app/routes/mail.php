<?php

// Route::any('preview', function(){
//     $token = '29384729384234';
//     return View::make('emails.auth.reminder', compact('token'));
// });

Route::post ('/fale-conosco/enviar',             ['https', 'as' => 'contact.send',    'uses' => 'PageController@postFaleConosco']);
