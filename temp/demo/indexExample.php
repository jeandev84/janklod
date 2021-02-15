<?php


/*
|----------------------------------------------------------------------
|   Autoloader classes and dependencies of application
|----------------------------------------------------------------------
*/

use Jan\Foundation\Facades\Route;

require_once __DIR__.'/../vendor/autoload.php';



/*
|-------------------------------------------------------
|    Require bootstrap of Application
|-------------------------------------------------------
*/

$app = require_once __DIR__.'/../bootstrap/app.php';


# SET FACADES
Route::setContainer($app);


# INCLUDE ROUTES
require __DIR__ .'/../routes/web.php';



/*
dump($app);

$app->singleton(\Jan\Component\Routing\Router::class, function () {
   return new \Jan\Component\Routing\Router('http://localhost');
});

$app->singleton(\Jan\Component\Http\Request::class, function () {
    return \Jan\Component\Http\Request::createFromGlobals();
});

$app->call(function (\Jan\Component\Routing\Router $router, $id, $slug) {
dump($router);
//    dump($router);
//    dump($router);
  echo "From closure with params : ". $id . " ". $slug . "<br>";
}, [1, 'jean-claude']);


$respond = $app->call(\App\Http\Controllers\HomeController::class, [], "index");

if(is_string($respond))
{
    // return new \Jan\Component\Http\Response($respond);
}

if(is_array($respond))
{
    new \Jan\Component\Http\Response(json_encode($respond));
}

if($respond instanceof \Jan\Component\Http\Response)
{
    return $respond;
}


$filesystem = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__.'/../')
);

$filesystem->mkdir('tests');
$filename = 'database/migrations/create_users_table_202012160148.php';
$filesystem->make($filename);
$filesystem->make('.env');
$filesystem->make('.env.local');

dump($filesystem->load('config/app.php'));
echo $filesystem->read($filename);
echo "<br/>";
$filesystem->write($filename, "Приходи сегодня!");
echo $filesystem->read($filename);
echo "<br/>";
echo $filesystem->extension($filename);
echo "<br/>";
*/



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