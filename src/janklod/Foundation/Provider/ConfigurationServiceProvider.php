<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Config\Config;
use Jan\Component\FileSystem\FileSystem;
use Jan\Component\Config\Loaders\ArrayLoader;



/**
 * Class ConfigurationServiceProvider
 * @package Jan\Foundation\Providers
*/
class ConfigurationServiceProvider extends ServiceProvider
{


    /**
     * @return mixed
     * @throws \Exception
    */
    public function register()
    {
        $this->app->singleton(Config::class, function (FileSystem $fileSystem) {

            $config = new Config();
            $config->load([
                $this->makeArrayLoader($fileSystem),
                // json loader
                // xml loader
                //..
            ]);

            return $config;
        });
    }


    /**
     * @param FileSystem $fileSystem
     * @return ArrayLoader
    */
    protected function makeArrayLoader(FileSystem $fileSystem)
    {
        $resources = $fileSystem->resources('/config/*.php');
        $data = [];

        foreach ($resources as $resource)
        {
            $filename = pathinfo($resource)['filename'];
            $data[$filename] = $resource;
        }

        return new ArrayLoader($data);
    }


    protected function makeJsonLoader()
    {
         //
    }


    protected function makeXmlLoader()
    {
        //
    }
}