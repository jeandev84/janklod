<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Config\Config;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Http\Middleware\Middleware;



/**
 * Class MiddlewareServiceProvider
 * @package Jan\Foundation\Providers
*/
class MiddlewareServiceProvider extends ServiceProvider
{

    public function register()
    {
         $this->app->singleton('middleware', function (Config $config) {

             /* dump($config->get('app.middlewares')); */

             return new Middleware();

            // add middleware from config
            // $middleware->middlewares([]);

           /* return $middleware; */
        });
    }
}