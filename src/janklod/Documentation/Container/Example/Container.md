# CONTAINER DEPENDENCY INJECTION 
```
<?php

use App\Cart;
use Jan\Component\Container\Container;


require __DIR__.'/../vendor/autoload.php';


# INSTANCE OF CONTAINER
$container = new Container();

$container->bind('name', 'Жан-Клод');
echo $container->get('name');

$container->bind('foo', function() {
    return 'Foo String';
});
echo $container->get('foo');
dump($container->make(\App\Foo::class, ['id' => 1, 'slug' => 'mon-amis']));

dump($container->make(\App\Foo::class));

$container->bind(\App\Foo::class, \App\Foo::class);
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));


$container->singleton(\App\Foo::class, \App\Foo::class);
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));
dump($container->get(\App\Foo::class));


echo $container->get('something');

# DEBUG CONTAINER
dump($container);
```