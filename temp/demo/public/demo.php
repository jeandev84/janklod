<?php
//
////$app->singleton(\Jan\Component\Container\Contract\ContainerInterface::class, function ($app) {
////    return $app;
////});
//
//$app->bind(Jan\Foundation\Facades\Route::class, Jan\Foundation\Facades\Route::class);
//dump($app->get(Jan\Foundation\Facades\Route::class));
//
//dump($app);
//
//# CLASS ALIASES
//class_alias(Jan\Foundation\Facades\Route::class, "Route");
//
//
//# SET FACADES
//Route::setContainer($app);
//
//
//# INCLUDE ROUTES
//require __DIR__ . '/../routes/web.php';
//
//
//$router = $app->get('router');
//
//dump($router->getRoutes());
//
//
//$route = $router->match($_SERVER['REQUEST_METHOD'], $uri = $_SERVER['REQUEST_URI']);
//
//if(! $route)
//{
//    dd("Route ". $uri . " not found!");
//}
//
//dump($route);
//$route->call();