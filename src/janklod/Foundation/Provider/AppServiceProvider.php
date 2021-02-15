<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Foundation\Application;


/**
 * Class AppServiceProvider
 * @package Jan\Foundation\Providers
*/
class AppServiceProvider extends ServiceProvider
{

    /**
     * @var string[]
    */
    private $classAliases = [
         "Route" =>  "Jan\Foundation\Facade\Routing\Route",
         "Asset" =>  "Jan\Foundation\Facade\Templating\Asset",
    ];


    /**
     * @var array
    */
    private $facades = [
        "Jan\Foundation\Facade\Routing\Route",
        "Jan\Foundation\Facade\Templating\Asset"
    ];


    /**
     * @return mixed
     * @throws \Exception
    */
    public function register()
    {
        // Resolve this part with abstract extenders () Application and Container
        $this->app->singleton(Application::class, function () {

             $this->bootClassAlias();
             $this->bootFacades();

             return $this->app;
        });

        /*
         $this->app->singleton(Request::class, function () {
             return Request::createFromGlobals();
         });
        */
    }


    /**
     * Boot class aliases
    */
    protected function bootClassAlias()
    {
        foreach ($this->classAliases as $alias => $className)
        {
             \class_alias($className, $alias);
        }
    }


    /**
     * @throws \ReflectionException
    */
    protected function bootFacades()
    {
        foreach ($this->facades as $facade)
        {
             $this->app->call($facade, [$this->app], "setContainer");
        }
    }
}