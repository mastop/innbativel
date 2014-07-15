<?php

// Route::any('preview', function(){
//     $token = '29384729384234';
//     return View::make('emails.auth.reminder', compact('token'));
// });

Route::post ('/fale-conosco/enviar',['https', 'as' => 'contact.send',    'uses' => 'PageController@postFaleConosco']);
Route::post ('/sugira-uma-viagem/enviar',['https', 'as' => 'suggest.send',    'uses' => 'PageController@postSuggestATrip']);
Route::post ('/conte-pra-gente/enviar',['https', 'as' => 'tell_us.send',    'uses' => 'PageController@postTellUs']);
Route::post ('/seja-nosso-parceiro/enviar',['https', 'as' => 'be_our_partner.send',    'uses' => 'PageController@postBeOurPartner']);
Route::post ('/trabalhe-conosco/enviar',['https', 'as' => 'work_with_us.send',    'uses' => 'PageController@postWorkWithUs']);
