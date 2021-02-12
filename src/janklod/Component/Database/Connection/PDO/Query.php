<?php
namespace Jan\Component\Database\Connection\PDO;


use Exception;
use Jan\Component\Database\Connection\AbstractQuery;
use Jan\Component\Database\Connection\Exception\QueryException;
use Jan\Component\Database\Contract\EntityMap;
use Jan\Component\Database\Contract\QueryInterface;
use PDO;
use PDOException;
use PDOStatement;



/**
 * Class Query
 *
 * @package Jan\Component\Database\Connection\PDO
*/
class Query extends AbstractQuery implements EntityMap
{

     /**
      * @var PDO
     */
     protected $pdo;


     /**
      * @var PDOStatement
     */
     protected $statement;



     /**
      * @var int
     */
     protected $fetchMode = PDO::FETCH_OBJ;



     /**
      * @var string
     */
     protected $entityClass;


     /**
      * @var mixed
     */
     protected $result;



     /**
      * @var array
     */
     protected $results = [];



     /**
      * @var array
     */
     protected $bindValues = [];




    /**
     * @var array
    */
    protected $queryLogs = [];



     /**
      * Statement constructor.
      * @param PDO $pdo
     */
     public function __construct(PDO $pdo)
     {
          $this->pdo = $pdo;
     }


     /**
      * @param $fetchMode
      * @return $this
     */
     public function setFetchMode($fetchMode): Query
     {
        $this->fetchMode = $fetchMode;

        return $this;
     }


    /**
     * @param $entityClass
     * @return $this
    */
    public function setEntityClass($entityClass): Query
    {
        $this->entityClass = $entityClass;

        return $this;
    }


    /**
     * @return string
    */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }


     /**
      * @param string $param
      * @param $value
      * @param int $type
      * @return $this
     */
     public function bindValue(string $param, $value, int $type = 0): Query
     {
        $this->bindValues[] = [$param, $value, $type];

        return $this;
     }


     /**
      * @return QueryInterface
      * @throws QueryException
     */
     public function execute(): QueryInterface
     {
         try {

             return $this->executionProcess();

         } catch (PDOException $e) {

             throw $e;
         }
     }



     /**
      * @return $this
      *
      * @throws QueryException
     */
     protected function executionProcess(): Query
     {
         if(! $this->sql)
         {
              throw new QueryException('Empty query sql.');
         }

         $this->statement = $this->pdo->prepare($this->sql);

         if($this->bindValues)
         {
             return $this->executeBindValues($this->statement);
         }

         return $this->executeParams($this->statement);
     }



     /**
      * @param $sql
      * @param array $params
     */
     public function log($sql, $params = [])
     {
          if($sql !== '')
          {
               $this->queryLogs[$sql] = $params;
          }
     }



     /**
      * @return array
     */
     public function getQueryLog(): array
     {
         return $this->queryLogs;
     }



    /**
     * @return array
     * @throws Exception
    */
    public function getResult(): array
    {
        return $this->results;
    }


    /**
     * @return mixed
     * @throws Exception
    */
    public function getFirstResult()
    {
        return $this->result[0] ?? null;
    }


    /**
     * @return mixed
    */
    public function getSingleResult()
    {
        return $this->result;
    }




    /**
     * @param PDOStatement $statement
     *
     * @return $this
    */
    protected function executeBindValues(PDOStatement $statement)
    {
        $this->params = [];

        $params = [];

        foreach ($this->bindValues as $bindParameters)
        {
            list($param, $value, $type) = $bindParameters;
            $statement->bindValue($param, $value, $type);
            $params[$param] = $value;
        }

        // TODO Refactoring because code double inside method executeParams
        if($statement->execute())
        {
            $this->log($this->sql, $params);
        }

        return $this->setResults($statement);
    }


    /**
     * @param PDOStatement $statement
     *
     * @return $this
    */
    protected function executeParams(PDOStatement $statement)
    {
        $this->bindValues = [];

        if($statement->execute($this->params))
        {
            $this->log($this->sql, $this->params);
        }

        return $this->setResults($statement);
    }


    /**
     * @param PDOStatement $statement
     * @return Query
    */
    protected function setResults(PDOStatement $statement)
    {
        $this->results = $this->fetchData($statement);
        $this->result  = $this->fetchData($statement, true);

        return $this;
    }




    /**
     * @param PDOStatement $statement
     * @param false $one
     * @return array|mixed
     */
    protected function fetchData(PDOStatement $statement, $one = false)
    {
        if($this->entityClass)
        {
            if($one === true)
            {
                $statement->setFetchMode(PDO::FETCH_CLASS, $this->entityClass);
                return $statement->fetch();
            }

            return $statement->fetchAll(PDO::FETCH_CLASS, $this->entityClass);

        }

        if($one === true)
        {
            return $statement->fetch($this->fetchMode);
        }

        return $statement->fetchAll($this->fetchMode);
    }



    /**
     * @param $type
     * @return array
    */
    protected function getBindType($type)
    {
         return [

         ];
    }
}