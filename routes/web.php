<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/'. config('telegram.bot_token').'/webhook', 'TelegramController@index');
//Route::post(Telegram::getAccessToken() ,function ()
//{
//    app('App\http\Controllers\TelegramController')->webhook();
//});

Route::get('test' , 'TelegramController@test');


