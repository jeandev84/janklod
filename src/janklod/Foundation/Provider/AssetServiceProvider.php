<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Config\Config;
use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Templating\Asset;


/**
 * Class AssetServiceProvider
 * @package Jan\Foundation\Providers
*/
class AssetServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(Asset::class, function (Config $config) {
            return new Asset($config->get('app.baseUrl'));
        });
    }
}