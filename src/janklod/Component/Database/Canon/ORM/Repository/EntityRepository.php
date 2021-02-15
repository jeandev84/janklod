<?php
namespace Jan\Component\Database\Canon\ORM\Repository;



use Jan\Component\Database\ConnectionTrait;
use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Jan\Component\Database\EntityTrait;


/**
 * Class EntityRepository
 * @package Jan\Component\Database\Doctrine\ORM\Repository
*/
class EntityRepository
{

    use ConnectionTrait, EntityTrait;


    /**
     * @var string
    */
    protected $entityClass = \stdClass::class;


    /**
      * EntityRepository constructor.
      * @param ManagerInterface $manager
    */
    public function __construct(ManagerInterface $manager)
    {
         $this->setManager($manager);
    }


    /**
     * @param $entityClass
    */
    public function registerClass($entityClass)
    {
         $this->entityClass = $entityClass;
    }


    /**
     * @param $alias
     * @return SQLQueryBuilder
     * @throws \Exception
    */
    public function createQueryBuilder(string $alias = ''): SQLQueryBuilder
    {
         $table = $this->getTableName();
         $queryBuilder = $this->manager->getConnection()
                                       ->getQueryBuilder();

         return $queryBuilder->select("*")->from($table, $alias);
    }



    /**
     * @param $id
     * @return array
    */
    public function findOne($criteria = []): array
    {
        return [];
    }



    /**
     * @param array $criteria
     * @return array
    */
    public function findOneBy(array $criteria): array
    {
          dump($criteria);
    }


    /**
     * @param array $criteria
     * @return array
    */
    public function findBy(array $criteria): array
    {
          return [];
    }



    /**
     * @return mixed|string|null
     * @throws \ReflectionException
    */
    protected function getTableName()
    {
        return $this->getConfiguration()->getTableName(
            $this->getTableDefaultName($this->entityClass)
        );
    }


//    /**
//     * @param $name
//     * @param $arguments
//     * @throws \ReflectionException
//    */
//    public function __call($name, $arguments)
//    {
//        $method = 'findById('. $arguments .')';
//
//        $reflectedClass = new \ReflectionClass($this->classMap);
//        $methods = $reflectedClass->getMethods();
//        $properties = $reflectedClass->getProperties();
//    }

//     public function findById(int $id)
//     {
//        parent::findBy(['id' => $id]);
//     }
}