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

$app->singleton(\Jan\Component\Routing\Router::class, function () {
    return new \Jan\Component\Routing\Router('http://localhost');
});

$app->call(function (\Jan\Component\Routing\Router $router, $id, $slug) {
    dump($router);
//    dump($router);
//    dump($router);
    echo "From closure with params : ". $id . " ". $slug . "<br>";
}, ['id' => 1, 'slug' => 'jean-claude']);


//$filesystem = new \Jan\Component\FileSystem\FileSystem(
//    realpath(__DIR__.'/../')
//);
//
//$filename = 'database/migrations/create_users_table_202012160148.php';
//$filesystem->make($filename);
//
//dump($filesystem->load('config/app.php'));
//echo $filesystem->read($filename);
//$filesystem->write($filename, "Приходи сегодня!");
//echo $filesystem->read($filename);




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