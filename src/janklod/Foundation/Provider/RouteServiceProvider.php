<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Config\Config;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\FileSystem\FileSystem;
use Jan\Component\Routing\Router;
use Jan\Foundation\Routing\Dispatcher\RouteDispatcher;


/**
 * Class RouteServiceProvider
 * @package Jan\Foundation\Providers
*/
class RouteServiceProvider extends ServiceProvider implements BootableServiceProvider
{


    /**
     * Boot router instance
    */
    public function boot()
    {
        $this->app->singleton(Router::class, function (Config $config) {
            $router = new Router();
            $router->setBaseURL($config->get('app.baseUrl'));

            return $router;
        });
    }


    /**
     * @return mixed
     * @throws \Exception
    */
    public function register()
    {
         $this->app->singleton(RouteDispatcher::class, function (FileSystem $fileSystem, Router $router) {

             // TODO Refactoring and (Create a Event and Listener for dispatching route )
             $fileSystem->load('/routes/api.php');
             $fileSystem->load('/routes/web.php');

             $middlewareStack = $this->app->get('middleware');
             $dispatcher = new RouteDispatcher($this->app, $router, $middlewareStack);
             $dispatcher->namespace('App\\Controller\\');

             return $dispatcher;
         });
    }
}