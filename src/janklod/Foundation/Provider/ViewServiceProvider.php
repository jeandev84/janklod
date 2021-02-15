<?php
namespace Jan\Foundation\Provider;


use Jan\Component\Container\ServiceProvider\ServiceProvider;
use Jan\Component\Templating\View;


/**
 * Class ViewServiceProvider
 * @package Jan\Foundation\Providers
*/
class ViewServiceProvider extends ServiceProvider
{

    const TEMPLATE_DIR = '/views';

    /**
     * @return mixed
    */
    public function register()
    {
        $this->app->singleton('view', function () {
            $path = $this->app->get('path');
            return new View($path. self::TEMPLATE_DIR);
        });
    }
}