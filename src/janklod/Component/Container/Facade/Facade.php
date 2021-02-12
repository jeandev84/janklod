<?php
namespace Jan\Component\Container\Facade;

use Jan\Component\Container\Contract\ContainerInterface;



/**
 * Class Facade
 *
 * @package Jan\Component\Container\Facade
*/
abstract class Facade
{

    /**
     * @var ContainerInterface
    */
    protected static $container;


    /**
     * @var mixed
     */
    protected static $resolved;


    /**
     * Set container
     * @param ContainerInterface $container
    */
    public static function setContainer(ContainerInterface $container)
    {
         static::$container = $container;
    }


    /**
     * Get instance of Facade
     *
     * dump($accessor, static::$container)
    */
    public static function getFacadeInstance()
    {
        $accessor = static::getFacadeAccessor();

        if($resolved = static::$resolved[$accessor] ?? null)
        {
            return $resolved;
        }

        return static::$resolved[$accessor] = static::$container->get($accessor);
    }


    /**
     * @param $method
     * @param $arguments
     * @return bool
    */
    public static function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeInstance();

        if(! method_exists($instance, $method))
        {
              return false;
        }

        /* return $instance->{$method}(...$arguments); */

        return call_user_func_array([$instance, $method], $arguments);
    }


    /**
     * Get name of facade to be resolve in container
    */
    abstract protected static function getFacadeAccessor();
}