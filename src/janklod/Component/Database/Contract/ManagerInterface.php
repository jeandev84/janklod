<?php
namespace Jan\Component\Database\Contract;


use Jan\Component\Database\Configuration;


/**
 * Interface DatabaseManagerInterface
 *
 * @package Jan\Component\Database\Contract
*/
interface ManagerInterface
{

     /**
      * @param Configuration $config
      * @return mixed
     */
     public function setConfiguration(Configuration $config);



     /**
      * @param ConnectionInterface $connection
      * @return mixed
     */
     public function setConnection(ConnectionInterface $connection);



     /**
      * Get connection
      *
      * @return ConnectionInterface
     */
     public function getConnection(): ConnectionInterface;



     /**
      * Get connection
      *
      * @return Configuration
     */
     public function getConfiguration(): Configuration;



     /**
       * @return mixed
     */
     public function flush();
}