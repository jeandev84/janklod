<?php
namespace Jan\Component\Database\Builder\Support;


use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\QueryInterface;



/**
 * Class QueryBuilder
 * @package Jan\Component\Database\Builder\Support
*/
class QueryBuilder extends AbstractQueryBuilder
{


      /**
       * @var ConnectionInterface
      */
      protected $connection;



      /**
       * Query Grammar
       *
       * @var QueryInterface
      */
      protected $query;



     /**
      * QueryBuilder constructor.
      * @param ConnectionInterface $connection
     */
     public function __construct(ConnectionInterface $connection)
     {
         $this->connection = $connection;
         $this->setQuery($connection->getQuery());
     }


     /**
      * @param QueryInterface $query
      * @return QueryBuilder
     */
     public function setQuery(QueryInterface $query)
     {
           $this->query = $query;

           return $this;
     }




     /**
      * @return QueryInterface
     */
     public function getQuery(): QueryInterface
     {
          return $this->query;
     }



    /**
     * @return QueryInterface
     */
    public function execute()
    {
        return $this->getQuery()
            ->setSQL($this->getSQL())
            ->setParams($this->parameters)
            ->execute();
    }


    /**
     * @return bool
    */
    public function exec()
    {
        return $this->getQuery()
                    ->setSQL($this->getSQL())
                    ->exec();
    }


    /**
     * @return mixed
     * @throws \Exception
    */
    public function get()
    {
        if($this->getSQL())
        {
            return $this->execute()->getResult();
        }

        return [];
    }



    /**
     * @return mixed
    */
    public function first()
    {
        return $this->execute()
                    ->getFirstRecord();
    }


    /**
     * @return mixed
    */
    public function one()
    {
        return $this->execute()
                    ->getOneRecord();
    }



//     /**
//      * @return QueryInterface
//     */
//     protected function execute()
//     {
//          return $this->getQuery()
//                      ->setSQL($this->getSQL())
//                      ->execute();
//     }



    /**
     * @return
    */
    public function paginate(int $currentPage, int $perPage)
    {

    }
}