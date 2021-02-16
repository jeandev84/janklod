<?php
namespace Jan\Foundation\Facade\Database;


use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Container\Facade\Facade;


/**
 * Class DB
 * @package Jan\Foundation\Facade\Database
*/
class DB extends Facade
{

    /**
     * @return string
    */
    protected static function getFacadeAccessor(): string
    {
          return ManagerInterface::class;
    }
}