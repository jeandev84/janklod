<?php

use App\Cart;
use Jan\Component\Container\Container;


require __DIR__ . '/../vendor/autoload.php';


# INSTANCE OF CONTAINER
$container = new Container();

# BIND PARAMS
/*
$container->bind('name', 'Жан-Клод');
echo $container->get('name');

$container->bind('foo', function() {
   return 'Foo!';
});

echo $container->get('foo');

$container->bind(\App\Format::class, function () {
    return new \App\Format();
});

dump($container->get(\App\Format::class));
*/

$container->bind(Cart::class, Cart::class);
//dump($container->get(Cart::class));

$container->singleton(\App\Bar::class, \App\Bar::class);
//dump($container->get(\App\Database::class));

// $container->get(\App\Controllers\PageController::class);


/*
https://github.com/symfony/symfony/blob/5.x/src/Symfony/Component/HttpFoundation/ServerBag.php
*/



# DEBUG CONTAINER
dump($container);