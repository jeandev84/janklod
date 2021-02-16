<?php
namespace Jan\Component\Event\Contract;


/**
 * Interface ListenerInterface
 * @package Jan\Component\Event\Contract
*/
interface ListenerInterface
{
    /**
     * @param EventInterface $event
    */
    public function handle(EventInterface $event);
}