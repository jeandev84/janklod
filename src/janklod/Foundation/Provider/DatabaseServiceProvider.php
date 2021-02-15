<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Config\Config;
use Jan\Component\Container\ServiceProvider\Contract\BootableServiceProvider;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Database\Configuration;
use Jan\Component\Database\ConnectionFactory;
use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Database\Database;
use Jan\Component\Database\Schema;


/**
 * Class DatabaseServiceProvider
 *
 * @package Jan\Foundation\Providers
*/
class DatabaseServiceProvider extends ServiceProvider implements BootableServiceProvider
{

    public function boot()
    {
        /*
        $config = $this->app->get(Config::class);
        $type = $config->get('database.connection');
        Database::open($config->get('database.'. $type));
        */
    }

    public function register()
    {
        /*
        $this->app->singleton('db', function () {
            return Database::connection();
        });
        */
    }
}