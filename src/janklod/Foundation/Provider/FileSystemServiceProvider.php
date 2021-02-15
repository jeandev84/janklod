<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\FileSystem\FileSystem;



/**
 * Class FileSystemServiceProvider
 * @package Jan\Foundation\Providers
*/
class FileSystemServiceProvider extends ServiceProvider
{

    /**
     * Register Filesystem
    */
    public function register()
    {
        $this->app->singleton(FileSystem::class, function () {
            return new FileSystem($this->app->get('path'));
        });
    }
}