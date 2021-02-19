<?php
//
//$routeCollection = new \Jan\Component\Routing\RouteCollection();
//
//
//$route1 = new \Jan\Component\Routing\Route(['GET'], '/', 'HomeController@index');
//$routeCollection->add($route1)->name('home');
//
//
//$route2 = new \Jan\Component\Routing\Route(['GET'], '/about', 'HomeController@about');
//$routeCollection->add($route2)->name('about');
//
//
//$route3 = new \Jan\Component\Routing\Route(['GET', 'POST'], '/contact', 'HomeController@contact');
//$routeCollection->add($route3)->name('contact');
//
//
//dd($routeCollection->getRoutes());


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

}, $options);

$router->get('/', 'HomeController@index', 'home');
$router->get('/demo', 'DemoController@index', 'demo');

dd($router->getRoutes(), $router->getGroupRoutes(), $router->getResources());