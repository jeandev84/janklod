<?php
namespace Jan\Component\Event\Support;

use ReflectionClass;



/**
 * Class Event
 *
 * @package Jan\Component\Event\Support
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