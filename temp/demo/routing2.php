<?php


/*
|----------------------------------------------------------------------
|   Autoloader classes and dependencies of application
|----------------------------------------------------------------------
*/

require_once __DIR__.'/../vendor/autoload.php';



/*
|-------------------------------------------------------
|    Require bootstrap of Application
|-------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';


dump($app);





/*
|-------------------------------------------------------
|    Check instance of Kernel
|-------------------------------------------------------
*/

$kernel = $app->get(Jan\Contract\Http\Kernel::class);



/*
|-------------------------------------------------------
|    Get Response
|-------------------------------------------------------
*/


$response = $kernel->handle(
    $request = \Jan\Component\Http\Request::createFromGlobals()
);


$router = $app->get('router');


$router->get("/", function () {
    return "Hello world!";
});

$router->get("/{slug}", function ($slug) {
    return "Page with slug : ". $slug ."<br>---------------------------------------------------------------";
})->whereAlphaNumeric('slug');

dump($router->getRoutes());


// TODO must to fix $request->getPath() and $request->getRequestUri();
// $route = $router->match($_SERVER['REQUEST_METHOD'], $uri = $_SERVER['REQUEST_URI']);
// $route = $router->match($request->getMethod(), $uri = $request->getRequestUri());
$route = $router->match($request->getMethod(), $uri = $request->getPath());


if(! $route) {
    dd("Route ". $uri . " not found!");
}

dump($route);
echo $route->call() . "<br>";


/*
|-------------------------------------------------------
|    Send all headers to navigator
|-------------------------------------------------------
*/

$response->send();



/*
|-------------------------------------------------------
|    Terminate
|-------------------------------------------------------
*/

$kernel->terminate($request, $response);