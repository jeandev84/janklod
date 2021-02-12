<?php
namespace Jan\Component\Container\Contract;


/**
 * Interface ContainerInterface
 * @package Jan\Component\Container\Contract
*/
interface ContainerInterface
{

      /**
       * @param string $id
       * @return mixed
      */
      public function has(string $id);


     /**
      * @param string $id
      * @return mixed
     */
     public function get(string $id);
}