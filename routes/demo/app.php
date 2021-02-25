<?php

/*
  |------------------------------------------------------------------
  |         API ROUTES OF APPLICATION
  |         In this file you can register all lists routes api
  |------------------------------------------------------------------
*/



Route::api()->group(function () {
    //
});



Route::get('/', "SiteController@index")
    ->name('home')
    ->middleware(\App\Middleware\Authenticated::class);

Route::get('/about', "SiteController@about")
    ->name('about');


Route::resource("/post", "PostController");

