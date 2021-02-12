<?php
namespace Jan\Component\Database\Canon;


use Exception;
use Jan\Component\Database\Canon\ORM\Repository\EntityRepository;
use Jan\Component\Database\Configuration;
use Jan\Component\Database\ConnectionTrait;
use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\EntityManagerInterface;
use Jan\Component\Database\Exception\EntityException;
use Jan\Component\Database\Canon\ORM\Repository\ServiceRepository;
use Jan\Component\Database\ORM\ObjectCustomer;


/**
 * Class EntityManager
 * @package Jan\Component\Database
*/
class EntityManager extends ObjectCustomer implements EntityManagerInterface
{

    use ConnectionTrait;


    /**
     * @var array
    */
    protected $entityMapped = [];



    /**
     * @var array
    */
    protected $entityInsertions = [];



    /**
     * @var array
    */
    protected $entityDeletions = [];



    /**
     * @var array
    */
    protected $entityUpdates = [];



    /**
     * Map entity class
     *
     * @param string $entityName
     * @param EntityRepository $repository
    */
    public function map(string $entityName, EntityRepository $repository)
    {
          $this->entityMapped[$entityName] = $repository;
    }


    /**
     * @param string $entityName
     * @return bool
    */
    public function mapped(string $entityName): bool
    {
         return isset($this->entityMapped[$entityName]);
    }



    /**
     * Get entity classes
     *
     * @return array
    */
    public function getEntityClasses(): array
    {
        return array_keys($this->entityMapped);
    }




    /**
     * @param $entityName
     *
     * @return ServiceRepository
     * @throws EntityException
    */
    public function getRepository($entityName): ServiceRepository
    {
        if(! $this->mapped($entityName))
        {
            throw new EntityException('Cannot get repository for entity ( '. $entityName.' ) ');
        }

        return $this->entityMapped[$entityName];
    }


    /**
     *
    */
    public function mapEntityRepository()
    {
        // Entity : App\Entity\User, Repository : App\Repository\UserRepository
        // Entity : App\Entity\Form\FormUser, Repository : App\Repository\Form\FormUserRepository
        // return $entityName."Repository";

        // /project/app/Entity/User
        // $filename = /project/app/Entity/Form/FormUser
        // str_replace(
        $entities = [
            "App\\Entity\\User",
            "App\\Entity\\Form\\FormUser"
        ];

        $repositories = [];

        foreach ($entities as $entityName)
        {
            $app = new \stdClass(); // replace to class container Container
            $repositoryName = str_replace("App\\Entity\\", "App\\Repository\\", $entityName."Repository");
            $repositories[$entityName] = $app->get($repositoryName);
        }

        dump($repositories);
    }


    /**
     * @param object $object
     * @throws Exception
    */
    public function update($object)
    {
         $this->entityUpdates[] = $object;
    }


    /**
     * @param object $object
     * @return void
     * @throws Exception
    */
    public function persist($object)
    {
         $this->entityInsertions[] = $object;
    }


    /**
     * @param object $object
     * @return void
     * @throws Exception
    */
    public function remove($object)
    {
        $this->entityDeletions[] = $object;
    }


    /**
     * @return mixed|void
     * @throws Exception
    */
    public function flush()
    {
        if($this->entityUpdates)
        {
            $this->updates();
        }

        if($this->entityInsertions)
        {
            $this->inserts();
        }

        if($this->entityDeletions)
        {
            $this->removes();
        }

        // reset datas
        $this->entityUpdates = [];
        $this->entityInsertions = [];
        $this->entityDeletions  = [];
    }


    /**
     * @throws EntityException
     * @throws Exception
    */
    protected function inserts()
    {
        foreach ($this->entityInsertions as $entityName => $object)
        {
            if(method_exists($object, 'beforePersist'))
            {
                $object->beforePersist();
            }

            $properties = $this->getFilteredClassMetaData($object);
            $this->getRepository($this->getClassName($object))->insert($properties);
        }
    }


    /**
     * @throws Exception
    */
    protected function removes()
    {
        foreach ($this->entityDeletions as $entityName => $object)
        {
            if(method_exists($object, 'beforeRemove'))
            {
                $object->beforeRemove();
            }

            $properties = $this->getFilteredClassMetaData($object);
            $this->getRepository($this->getClassName($object))->delete($this->getId($object), $properties);
        }
    }


    /**
     * @throws EntityException
     * @throws Exception
    */
    protected function updates()
    {
        foreach ($this->entityUpdates as $entityName => $object)
        {
            if(method_exists($object, 'beforeUpdate'))
            {
                $object->beforeUpdate();
            }

            $properties = $this->getFilteredClassMetaData($object);
            $this->getRepository($this->getClassName($object))->update($this->getId($object), $properties);
        }
    }


    /**
     * @param string $action
     * @param array $entities
     * @param array $beforeMethods
     * @param array $afterMethods
     * @throws EntityException
    */
    protected function callAction(string $action, array $objects, array $beforeMethods = [], array $afterMethods = [])
    {
          foreach ($objects as $object)
          {
               if($beforeMethods)
               {
                   foreach ($beforeMethods as $method)
                   {
                       if(method_exists($object, $method))
                       {
                           $object->{$method}();
                       }
                   }
               }

               $callback = [$this->getRepository($this->getClassName($object)), $action];

               // TODO to indicate arguments
               call_user_func_array($callback, []);
          }
    }


    /**
     * @param object $object
     * @return array
     * @throws Exception
    */
    protected function getClassMetaData(object $object): array
    {
         return $this->getProperties($object);
    }


    /**
     * @param object $object
     * @return array
     * @throws Exception
    */
    protected function getFilteredClassMetaData(object $object): array
    {
        if(\array_key_exists('id', $properties = $this->getClassMetaData($object)))
        {
            unset($properties['id']);
        }

        return $properties;
    }



    /**
     * @param object $object
     * @return int
     * @throws Exception
    */
    protected function getId(object $object): int
    {
        $mappedProperties = $this->getClassMetaData($object);

        if(! \array_key_exists('id', $mappedProperties))
        {
            throw new Exception('The entity ( '. $this->getClassName($object) . ') has not property id.');
        }

        return $mappedProperties['id'];
    }


    /**
     * @param object $object
     * @return false|string
    */
    protected function getClassName(object $object)
    {
         return \get_class($object);
    }


//  /**
//    * Dispatch actions
//    *
//    * @param object $object
//    * @param array $actions
//  */
//  protected function callAction(object $object, array $actions = [])
//  {
//         if($actions)
//         {
//             foreach ($actions as $action)
//             {
//                 if(method_exists($object, $action))
//                 {
//                       call_user_func([$object, $action]);
//                 }
//             }
//         }
//  }
    public function getConnection(): ConnectionInterface
    {
        // TODO: Implement getConnection() method.
    }

    public function getConfiguration(): Configuration
    {
        // TODO: Implement getConfiguration() method.
    }
}