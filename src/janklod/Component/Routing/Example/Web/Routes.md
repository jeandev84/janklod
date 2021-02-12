# WEB ROUTES
```markdown
<?php
/*
  |------------------------------------------------------------------
  |         WEB ROUTES OF APPLICATION
  |         In this file you can register all lists routes
  |------------------------------------------------------------------
*/


use Jan\Component\Http\Request;

Route::get('/', "HomeController@index")
    ->name('home')
    ->middleware([
        \Jan\Foundation\Middlewares\SessionStart::class,
        \Jan\Foundation\Middlewares\Authenticated::class,
        \Jan\Foundation\Middlewares\FooMiddleware::class
    ]);

Route::get('/about', "HomeController@about")
    ->name('about');

Route::map('GET|POST', '/contact', "HomeController@contact")
    ->name('contact');


Route::map('GET|POST', '/login', "HomeController@login")
    ->name('login');


Route::get("/foo", function () {
    echo "Foo!";
});


Route::get("/products", function () {

    return [
        'id' => 1,
        'name' => 'Жан-Клод',
        'surname' => 'Яо'
    ];
});




Route::get('/hello/{id}', function (Request $request) {

    dump($request);
    return new \Jan\Component\Http\Response('Hello jean-claude!');

})->where('id', '\d+');


Route::get('/user/{id}/edit', function (Request $request) {

    dump($request);
    return new \Jan\Component\Http\Response('Edited user!');

})->where('id', '\d+');

?>
<a href="/hello/3?name=jean&username=klod">Say Hello!</a>
<br>
<a href="/user/3/edit">Обновить</a>
```