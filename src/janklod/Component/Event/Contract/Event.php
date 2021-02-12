<?php
namespace Jan\Component\Event\Contract;

use ReflectionClass;



/**
 * Class Event
 * @package Jan\Component\Event\Contract
 */
abstract class Event
{
    /**
     * @return string
    */
    public function getName()
    {
        return (new ReflectionClass($this))->getShortName();
    }
}