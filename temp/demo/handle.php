<?php

use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;


require __DIR__.'/../vendor/autoload.php';



// create new router
// $router = new Router('http://localhost:8080/');
$router = new Router();

// set routes
$router->get('/', 'HomeController@index', 'home'); //->name('home');
$router->get('/search/{search?}', 'SearchController@index', 'search')
    ->any('search');

/*
$router->get('/search/{search}', 'SearchController@index', 'search')
       ->any('search');
*/

$router->get('/about', 'HomeController@about', 'about');
$router->get('/news', 'HomeController@news', 'news');
$router->get('/contact', 'HomeController@contact', 'contact.form');
$router->post('/contact', 'HomeController@send', 'contact.send');
$router->map(['GET', 'POST'], '/post/{id}/edit', 'PostController@edit', 'post.edit')
    ->where('id', '[0-9]+');
/*
$router->map(['GET', 'POST'], '/post/{id?}/edit', 'PostController@edit', 'post.edit')
       ->where('id', '[0-9]+');
*/

$router->group(function ($router) {
    $router->get( '/post/{id?}', 'PostController@show', 'post.show')
        ->where('id', '[0-9]+');
}, ['name' => 'admin.', 'prefix' => 'admin/']);


$router->get( '/foo/{id?}/edit/{token?}', 'FooController@edit', 'foo.edit')
    ->where('id', '[0-9]+')
    ->whereAlphaNumeric('token');


// get routes
// dump($router->getRoutes(), RouteCollection::getNamedRoutes());
dump($router->getRoutes());

$route = $router->match($_SERVER['REQUEST_METHOD'], $uri = $_SERVER['REQUEST_URI']);


if(! $route)
{
    dd('Route '. $uri . ' not found!');
}

dump($route);

// dump($router->generate('/search', ['page' => 1, 'sort' => 'asc']));

dump($router->generate('contact.send'));
dump($router->generate('post.edit', ['id' => 1]));
dump($router->generate('admin.post.show', ['id' => 4]));


/*
use App\Cart;
use Jan\Component\Container\Container;


require __DIR__.'/../vendor/autoload.php';


# INSTANCE OF CONTAINER
$container = new Container();

$container->singleton(\App\Foo::class, \App\Foo::class);
$container->singleton(\App\Database::class, \App\Database::class);
$container->call(function (\App\Foo $foo, \App\Database $database) {
    echo 'Salut';
});


# DEBUG CONTAINER
dump($container);
*/
