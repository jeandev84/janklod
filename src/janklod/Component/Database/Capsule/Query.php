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
     * Query constructor.
     * @param ManagerInterface|null $manager
     * @throws \Exception
    */
    public function __construct(ManagerInterface $manager, string $entityClass = null)
    {
         if($entityClass)
         {
             $this->entityClass = $entityClass;
         }

         $this->setManager($manager);
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
        $this->table = $table;
        $this->alias = $alias;
        
        return $this;
    }



    /**
     * @param string $table
     * @param string $alias
     * @return SQLQueryBuilder
    */
    protected function getQueryBuilder(): SQLQueryBuilder
    {
        /** @var AbstractQueryBuilder $qb */
        $qb = $this->getConnection()->getQueryBuilder();

        $qb->table($this->resolvedTableName($this->table), $this->alias);

        $query = $this->getConnection()->getQuery();

        $queryImplements = class_implements($query);

        if(isset($queryImplements[EntityMap::class]))
        {
            if(method_exists($query, 'setEntityClass'))
            {
                $query->setEntityClass($this->entityClass);
                return $qb->setQuery($query);
            }
        }

        return $qb;
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
     * @throws ReflectionException
    */
    public function select()
    {
        return $this->getQueryBuilder()->select(func_get_args());
    }



    /**
     * @param $column
     * @param $value
     * @param string $operator
     * @return SQLQueryBuilder
     * @throws ReflectionException
    */
    public function where($column, $value, $operator = '=')
    {
        $condition = sprintf('%s %s :%s', $column, $operator, $column);
        $qb = $this->getQueryBuilder()->select();

        $qb->andWhere($condition);
        $qb->setParameter($column, $value);

        return $qb;
    }



    /**
     * @param $id
     * @return mixed
     * @throws ReflectionException
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
    public function findAll()
    {
        return $this->getQueryBuilder()
                    ->select()->get();
    }


    /**
     * @param $id
     * @return mixed
    */
    public function read($id)
    {
        return $this->find($id);
    }


    /**
     * @param array $attributes
     * @return int
    */
    public function create(array $attributes)
    {
        $qb = $this->getQueryBuilder();
        $qb->insert($attributes)->execute();
        return $this->getConnection()->getLastInsertId();
    }


    /**
     * @param array $attributes
     * @param int $id
     * @return bool
    */
    public function update(array $attributes, int $id)
    {
        $qb = $this->getQueryBuilder();

        $qb->update($attributes)
           ->where("{$this->primaryKey} = :{$this->primaryKey}")
           ->setParameter($this->primaryKey, $id)
           ->execute();

        return true;
    }



    /**
     * @param $id
     * @return QueryInterface
     * @throws ReflectionException
    */
    public function delete($id)
    {
        $exprCondition = sprintf('%s = :%s',
            $this->primaryKey,
            $this->primaryKey
        );

        // ADD SOFT DELETES
        return $this->getQueryBuilder()
                    ->delete()
                    ->where($exprCondition)
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
        $columnArrays = $this->getQueryBuilder()
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
    public function assign($object, array $attributes)
    {
         foreach ($attributes as $fieldName => $fieldValue)
         {
              if(\array_key_exists($fieldName, $this->columns()))
              {
                   $object->{$fieldName} = $fieldValue;
              }
         }
    }


    /**
     * @return ConnectionInterface|mixed
     * @throws Exception
    */
    public function getConnection(): ConnectionInterface
    {
        if(! $this->connection instanceof PDOConnection)
        {
            throw new Exception('required connection to PDO for working with model');
        }

        return $this->connection;
    }


    /**
     * @param $table
     * @return mixed|string|null
    */
    protected function resolvedTableName($table)
    {
        return $this->getConfiguration()->getTableName($table);
    }
}