<?php

$app = require_once __DIR__.'/../bootstrap/app.php';


dump($app);

$router = $app->get('router');

$router->get("/", function () {
    return "Good morning!";
});

$router->get("/foo", function () {
    return "Foo!";
});

$route = $router->match($_SERVER['REQUEST_METHOD'], $url = $_SERVER['REQUEST_URI']);

if(! $route)
{
    dd('Route '. $url . ' not found');
}

echo $route->call();