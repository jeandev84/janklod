<?php
namespace Jan\Component\Database\Connection;


use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\EntityMap;
use Jan\Component\Database\Contract\PaginatedQueryInterface;
use Jan\Component\Database\Contract\QueryInterface;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Closure;



/**
 * Class Connection
 *
 * @package Jan\Component\Database\Connection
 */
abstract class Connection implements ConnectionInterface
{

    /**
     * @var mixed
    */
    protected $connection;



    /**
     * @var QueryInterface
    */
    protected $query;



    /**
     * @var PaginatedQueryInterface
    */
    protected $paginatedQuery;



    /**
     * @param $connection
    */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }


    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }


    /**
     * @param QueryInterface $query
    */
    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;
    }


    /**
     * @return QueryInterface
    */
    public function getQuery(): QueryInterface
    {
        return $this->query;
    }





    /**
     * @param string $sql
     * @param array $params
     * @param string $classMap
     * @return QueryInterface
    */
    public function query(string $sql, array $params = [], string $classMap = null): QueryInterface
    {
        $query = $this->getQuery()
                      ->setSQL($sql)
                      ->setParams($params);

        if($classMap)
        {
            $implements = class_implements($query);
            if(isset($implements[EntityMap::class]) && method_exists($query, "setEntityClass"))
            {
               $query->setEntityClass($classMap);
               return $query;
            }
        }

       return $query;
    }




    /**
     * @param Closure $callback
     * @throws PDOException|Exception
    */
    public function transaction(Closure $callback)
    {
        try {

            $this->beginTransaction();

            $callback($this);

            $this->commit();

        } catch (PDOException $e) {

            $this->rollback();

            throw $e;
        }
    }


    /**
     * @param PaginatedQueryInterface $paginatedQuery
    */
    public function setPaginatedQuery(PaginatedQueryInterface $paginatedQuery)
    {
        $this->paginatedQuery = $paginatedQuery;
    }


    /**
     * @return PaginatedQueryInterface
    */
    public function getPaginatedQuery(): PaginatedQueryInterface
    {
         return  $this->paginatedQuery;
    }


    /**
     * @param string $sql
     * @return mixed
    */
    abstract public function exec(string $sql);



    /**
     * @return bool
    */
    abstract public function isConnected(): bool;



    /**
     * @return SQLQueryBuilder
    */
    abstract public function getQueryBuilder(): SQLQueryBuilder;


    /**
     * @return mixed
    */
    abstract public function close();
}