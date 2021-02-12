# Route 
```markdown
<?php

use Jan\Component\Routing\Route;
use Jan\Component\Routing\Router;

require __DIR__.'/../vendor/autoload.php';


// route collection
$routes = [
    new Route(['GET'], '/', 'HomeController@index', 'home'),
    new Route(['GET'], '/about', 'HomeController@about', 'about'),
    new Route(['GET'], '/news', 'HomeController@news', 'news'),
    new Route(['GET'], '/contact', 'HomeController@contact', 'contact.form'),
    new Route(['POST'], '/contact', 'HomeController@send', 'contact.send'),
    new Route(['GET', 'POST'], '/post/{id}/edit', 'PostController@edit', 'post.edit'),
    new Route(['GET'], '/foo', function() {
        return 'Foo!';
    }, 'foo'),
];

$route = new Route();
$route->setMethods(['GET'])
      ->setPath('/test')
      ->setTarget(function() {
          return Hello
      });


// dumping routes
dump($routes);


// create new router
$router = new Router();

// set routes
$router->setRoutes($routes);


// get routes
dd($router->getRoutes());
```