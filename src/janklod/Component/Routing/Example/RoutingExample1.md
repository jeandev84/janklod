# ROUTING
```
<?php
use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;


require __DIR__.'/../vendor/autoload.php';


$router = new Router();


// set routes
$router->get('/hello', function () {
   return 'Hello';
}, 'hello');


$router->get('/', 'HomeController@index', 'home'); //->name('home');

/*
$router->api()
       ->group(function ($router) {
           $router->resource('posts', 'PostController');
       });
*/


$router->prefix('admin')
       ->name('admin.')
       ->namespace('Admin\\')
       ->middleware([\App\Middleware\SessionStorage::class, \App\Middleware\Flashing::class])
       ->group(function ($router) {
           $router->get('/post', 'PostController@index', 'post.list');
           $router->get('/post/{id?}', 'AdminController@show', 'post.show')
                  ->middleware([\App\Middleware\Authenticated::class])
                  ->whereNumeric('id');
                  //->name('post.show');
       });



dump($router->generate('admin.post.show', ['id' => 1]));


/*
$router->namespace('Admin\\')
       ->prefix('admin')
       ->name('admin.')
       ->resource('post', 'PostController', 'post.');
*/

dump($router->getRoutes());

$route = $router->match($_SERVER['REQUEST_METHOD'], $uri = $_SERVER['REQUEST_URI']);


if(! $route)
{
    dd('Route '. $uri . ' not found!');
}

dd($route);
```