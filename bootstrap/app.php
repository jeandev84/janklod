<?php
/*
|-------------------------------------------------------------------
|    Create new application
|-------------------------------------------------------------------
*/


$app = new \Jan\Foundation\Application(
    realpath(__DIR__.'/../')
);



/*
|-------------------------------------------------------------------
|    Binds importants interfaces of application
|-------------------------------------------------------------------
*/

$app->singleton(
    Jan\Contract\Http\Kernel::class,
    Jan\Foundation\Http\Kernel::class
);

$app->singleton(
    Jan\Contract\Console\Kernel::class,
    Jan\Foundation\Console\Kernel::class
);

$app->singleton(
    Jan\Contract\Debug\ExceptionHandler::class,
    Jan\Foundation\Exception\ErrorHandler::class
);


/*
|-------------------------------------------------------------------
|    Return instance of application
|-------------------------------------------------------------------
*/
return $app;