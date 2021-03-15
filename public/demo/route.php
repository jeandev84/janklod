<?php


/*
$routeCollection = new \Jan\Component\Routing\RouteCollection();


$route1 = new \Jan\Component\Routing\Route(['GET'], '/', 'HomeController@index');
$routeCollection->add($route1)->name('home');


$route2 = new \Jan\Component\Routing\Route(['GET'], '/about', 'HomeController@about');
$routeCollection->add($route2)->name('about');


$route3 = new \Jan\Component\Routing\Route(['GET', 'POST'], '/contact', 'HomeController@contact');
$routeCollection->add($route3)->name('contact');


dd($routeCollection->getRoutes());
*/



/*
Append file
$file = realpath(__DIR__ . '/../../routes/demo/app.php');
$content = "\n\n". 'Route::resource("/post", "PostController");'. "\n";


if(file_put_contents($file, $content, FILE_APPEND | LOCK_EX)) {
    // dd('OK');
}
*/


use Jan\Component\Routing\Router;

$router = new Router();


$options = [
  'prefix' => '/admin',
  'namespace' => 'Admin\\',
  'middleware' => [
      \App\Middleware\Authenticated::class,
      \App\Middleware\AjaxMiddleware::class
  ],
  'name' => 'admin.'
];

$router->group(function (Router $router) {
  $router->get('posts', 'PostController@index', 'list');
  $router->map('GET|POST', '/post/new', 'PostController@new', 'new');
  $router->map('GET|POST', '/post/{id}/edit', 'PostController@edit', 'edit');
  $router->get('/post/{id}/delete', 'PostController@index', 'delete');

  $router->resource('/products', 'ProductController');

  /* $router->resource('/orders', 'Operation\OrderController'); */

}, $options);


$router->resource('/cart', 'CartController');
$router->get('/', 'HomeController@index', 'welcome');
$router->get('/foo', 'FooController@index', 'foo');

dd($router->getResources());

/* dd($router->getRoutes(), $router->getGroups(), $router->getResources()); */
