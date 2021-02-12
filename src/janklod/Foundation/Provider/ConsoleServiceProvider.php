<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Config\Config;
use Jan\Component\Console\Command\Command;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Foundation\Console;



/**
 * Class ConsoleServiceProvider
 * @package Jan\Foundation\Providers
*/
class ConsoleServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('console', function (Config $config) {

             return new Console();
        });
    }
}