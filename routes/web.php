<?php
/*
  |------------------------------------------------------------------
  |         WEB ROUTES OF APPLICATION
  |         In this file you can register all lists routes
  |------------------------------------------------------------------
*/


Route::get('/', "SiteController@index")
       ->name('home')
       ->middleware(\App\Middleware\Authenticated::class);

Route::get('/about', "SiteController@about")
    ->name('about');

Route::map('GET|POST', '/contact', "SiteController@contact")
    ->name('contact');

Route::map('GET|POST', '/user/sign-up', "UserController@signUp")
    ->name('user.sign.up');

Route::map('GET|POST', '/user/sign-in', "Security\\AuthController@login")
    ->name('user.sign.in');

Route::get('/demo', "DemoController@index")
    ->name('demo');


/*
Route::get('/foo/{search?}', function ($search) {
   echo "Foo!". $search;
})->any('search');
*/