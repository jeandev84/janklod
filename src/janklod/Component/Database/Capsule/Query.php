<?php
namespace Jan\Component\Database\Capsule;


use Jan\Component\Database\Builder\Support\AbstractQueryBuilder;
use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\ConnectionTrait;
use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\EntityMap;
use Jan\Component\Database\Contract\ManagerInterface;
use Jan\Component\Database\Contract\QueryInterface;
use Jan\Component\Database\Contract\SQLQueryBuilder;


/**
 * Class Query
 * @package Jan\Component\Database\Capsule
*/
class Query
{


    use ConnectionTrait;


    /**
     * @var string
    */
    protected $primaryKey = 'id';



    /**
     * @var string
    */
    protected $table;



    /**
     * @var string
    */
    protected $alias;



    /**
     * @var string
    */
    protected $entityClass = \stdClass::class;



    /**
     * @var ManagerInterface
    */
    protected $manager;


    /**
     * @var AbstractQueryBuilder
    */
    protected $queryBuilder;



    /**
     * @var object
    */
    protected $entityObject;


    /**
     * Query constructor.
     * @param ManagerInterface $manager
     * @param $entityObject
    */
    public function __construct(ManagerInterface $manager, $entityObject)
    {
         $this->setManager($manager);
         $this->entityObject = $entityObject;
         $this->entityClass(\get_class($entityObject));
    }



    /**
     * @param $primaryKey
     * @return Query
    */
    public function primaryKey($primaryKey): Query
    {
          $this->primaryKey = $primaryKey;

          return $this;
    }


    /**
     * @param $entityClass
     * @return Query
    */
    public function entityClass($entityClass): Query
    {
        $this->entityClass = $entityClass;

        return $this;
    }


    /**
     * @param $table
     * @param string $alias
     * @return Query
    */
    public function table($table, $alias = '')
    {
        $table = $this->getConfiguration()->getTableName($table);
        /** @var AbstractQueryBuilder $queryBuilder */
        $queryBuilder = $this->getConnection()->getQueryBuilder();
        $queryBuilder->table($table, $alias);
        $query = $this->getConnection()->getQuery();
        $queryImplements = class_implements($query);

        if(isset($queryImplements[EntityMap::class]))
        {
            if(method_exists($query, 'setEntityClass'))
            {
                $query->setEntityClass($this->entityClass);
                $queryBuilder->setQuery($query);
            }
        }

        $this->queryBuilder = $queryBuilder;
        $this->table = $table;
        $this->alias = $alias;

        return $this;
    }



    /**
     * store data to the database
     *
     * action insert|update
    */
    public function store($object)
    {

    }


    /**
     * @param ...$args
     * @return SQLQueryBuilder
     * @throws \Exception
    */
    public function select()
    {
        return $this->queryBuilder->select(func_get_args());
    }



    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return SQLQueryBuilder
     * @throws ReflectionException|\Exception
     */
    public function where($column, $value, $operator = '=')
    {
        $condition = sprintf('%s %s :%s', $column, $operator, $column);
        $this->queryBuilder->select()
                           ->andWhere($condition)
                           ->setParameter($column, $value);

        return $this->queryBuilder;
    }



    /**
     * @param $id
     * @return mixed
     * @throws ReflectionException|\Exception
    */
    public function find($id)
    {
        return $this->where($this->primaryKey, $id)
                    ->one();
    }



    /**
     * @return mixed
     * @throws ReflectionException|\Exception
    */
    public function all()
    {
        return $this->queryBuilder
                    ->select()
                    ->get();
    }




    /**
     * @param array $attributes
     * @return int
     * @throws \Exception
    */
    public function create(array $attributes)
    {
        $this->queryBuilder->insert($attributes)->execute();
        return $this->getConnection()->getLastInsertId();
    }



    /**
     * @param array $attributes
     * @param int $id
     * @return bool
     * @throws \Exception
    */
    public function update(array $attributes, int $id)
    {
        $this->queryBuilder
             ->update($attributes)
             ->where("{$this->primaryKey} = :{$this->primaryKey}")
             ->setParameter($this->primaryKey, $id)
             ->execute();

        return true;
    }



    /**
     * @param $id
     * @return QueryInterface
     * @throws ReflectionException|\Exception
    */
    public function delete($id)
    {
        $condition = sprintf('%s = :%s',
            $this->primaryKey,
            $this->primaryKey
        );

        // add soft deletes
        return $this->queryBuilder
                    ->delete()
                    ->where($condition)
                    ->setParameter($this->primaryKey, $id)
                    ->getQuery()
                    ->execute();
    }



    /**
     * @return array|mixed
     * @throws \Exception
    */
    public function tableColumns()
    {
        $columnArrays = $this->queryBuilder
                             ->showColumns()
                             ->get();

        $columns = [];

        if($columnArrays)
        {
            foreach ($columnArrays as $column)
            {
                $columns[] = $column->Field;
            }
        }

        return $columns;
    }



    /**
     * @param array $attributes
     * @return array
     * @throws \Exception
    */
    public function assignOLD(array $attributes)
    {
         $properties = [];

         foreach ($attributes as $propertyName => $propertyValue)
         {
              if(\array_key_exists($propertyName, $this->columns()))
              {
                  $properties[$propertyName] = $propertyValue;
              }
         }

         return $properties;
    }


    /**
     * @param object $object
    */
    public function assignOLD2($object)
    {
        $columns = [];

        if (\is_object($object))
        {
             foreach ($this->columns() as $columnName)
             {
                 if(property_exists($object, $columnName))
                 {
                     $columns[$columnName] = $object->{$columnName};
                 }
             }
        }

        dd($columns);
    }


    /**
     * @param array $attributes
     * @throws \Exception
    */
    public function assign(array $attributes)
    {
         foreach ($attributes as $fieldName => $fieldValue)
         {
              if(\array_key_exists($fieldName, $this->columns()))
              {
                   $this->entityObject->{$fieldName} = $fieldValue;
              }
         }
    }


    /**
     * @return ConnectionInterface|mixed
     * @throws Exception
    */
    public function getConnection(): ConnectionInterface
    {
        $connection = $this->getConnection();

        if(! $connection instanceof PDOConnection)
        {
            throw new Exception('required connection to PDO for working with model');
        }

        return $connection;
    }
}