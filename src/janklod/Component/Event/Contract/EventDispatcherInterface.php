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
       * @param $eventName
       * @param $event
       * @return mixed
     */
     public function addListener($eventName, $event);



     /**
      * @param $eventName
      * @return array
     */
     public function getListenersByEvent($eventName): array;



     /**
      * @param $event
      * @return mixed
     */
     public function dispatch($event /*, string $eventName */);
}