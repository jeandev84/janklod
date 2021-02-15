# ROUTE MAPPING

1. MAP ROUTES
```markdown
<?php

use Jan\Component\Routing\Route;
use Jan\Component\Routing\RouteCollection;
use Jan\Component\Routing\Router;
use Jan\Component\Routing\RouteParameter;

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

$router->get( '/post/{id?}', 'PostController@show', 'post.show')
       ->where('id', '[0-9]+');


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

dd($route);

```

2 . GENERATE PATH  

```markdown
dump($router->generate('/search', ['page' => 1, 'sort' => 'asc']));
dump($router->generate('contact.send'));
dump($router->generate('post.edit', ['id' => 1]));
dump($router->generate('post.show', ['id' => 4]));
```