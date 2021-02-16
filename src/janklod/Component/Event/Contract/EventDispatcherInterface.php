<?php
namespace Jan\Component\Event\Contract;


/**
 * Interface EventDispatcherInterface
 *
 * @package Jan\Component\Event\Contract
*/
interface EventDispatcherInterface
{

     /**
       * @param string $eventName
       * @param EventInterface $event
       * @return mixed
     */
     public function addListener(string $eventName, EventInterface $event);



     /**
      * @param string $eventName
      * @return array
     */
     public function getListenersByEvent(string $eventName): array;



     /**
      * @param EventInterface $event
      * @return mixed
     */
     public function dispatch(EventInterface $event /*, string $eventName */);
}