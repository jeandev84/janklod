<?php
namespace Jan\Foundation\Facade\Database;


use Jan\Foundation\Facade;


/**
 * Class Schema
 * @package Jan\Foundation\Facade\Database
*/
class Schema extends Facade
{

    /**
     * @return string
    */
    protected static function getFacadeAccessor(): string
    {
        return 'Jan\Component\Database\Schema\Schema::class';
    }
}