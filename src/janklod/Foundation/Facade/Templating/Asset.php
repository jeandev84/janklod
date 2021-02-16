<?php
namespace Jan\Foundation\Facade\Templating;


use Jan\Component\Container\Facade\Facade;


/**
 * Class Asset
 * @package Jan\Foundation\Facade\Templating
*/
class Asset extends Facade
{

    /**
     * @return string
    */
    protected static function getFacadeAccessor(): string
    {
         return 'asset';
    }
}