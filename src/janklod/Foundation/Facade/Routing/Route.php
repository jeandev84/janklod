<?php
namespace Jan\Foundation\Facade\Routing;


use Jan\Component\Routing\Router;
use Jan\Component\Container\Facade\Facade;


/**
 * Class Route
 * @package Jan\Foundation\Facade
*/
class Route extends Facade
{

    /**
     * @return mixed
    */
    protected static function getFacadeAccessor(): string
    {
         return Router::class;
    }
}