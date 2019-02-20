<?php
Route::group(['middleware' => ['web']], function(){
  Route::get('/registration', 'Ari\Cc\NicepayVaController@index')->name('va-regis-request');
  Route::post('/registration', 'Ari\Cc\NicepayVaController@regisVA')->name('va-regis-response');
});
