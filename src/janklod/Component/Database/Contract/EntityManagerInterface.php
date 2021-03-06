<?php
namespace Jan\Component\Database\Contract;


use Jan\Component\Database\Canon\ORM\Repository\ServiceRepository;
use Jan\Component\Database\Configuration;


/**
 * Interface EntityManagerInterface
 *
 * @package Jan\Component\Database\Contract
*/
interface EntityManagerInterface extends ObjectManager
{

     /**
      * @param ManagerInterface $manager
      * @return mixed
     */
     public function setManager(ManagerInterface $manager);



     /**
      * Map entity with repository
      *
      * @param string $entityClass
      * @param ServiceRepository $repositoryObject
      * @return mixed
     */
     public function map(string $entityClass, ServiceRepository $repositoryObject);



     /**
      * Determine if entity is mapped
      *
      * @param string $entityName
      * @return bool
     */
     public function mapped(string $entityName): bool;




     /**
      * Get entity classes
      *
      * @return array
     */
     public function getEntityClasses(): array;



     /**
      * @param $entityName
      *
      * @return mixed
     */
     public function getRepository($entityName);




     /**
      * @return mixed
     */
     public function getConnection(): ConnectionInterface;




     /**
      * @return mixed
     */
     public function getConfiguration(): Configuration;
}