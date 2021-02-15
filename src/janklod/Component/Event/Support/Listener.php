<?php
namespace Jan\Component\Event\Support;


/**
 * Class Listener
 *
 * @package Jan\Component\Event\Support
*/
abstract class Listener
{
    /**
     * @param Event $event
    */
    abstract public function handle(Event $event);
}