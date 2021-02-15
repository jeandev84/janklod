<?php

use App\Cart;
use Jan\Component\Container\Container;


require __DIR__.'/../vendor/autoload.php';


# INSTANCE OF CONTAINER
$container = new Container();


$container->call(function () {
    echo 'Salut';
});


# DEBUG CONTAINER
dump($container);