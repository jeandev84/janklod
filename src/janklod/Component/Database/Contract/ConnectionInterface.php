<?php
namespace Jan\Component\Database\Contract;


use Closure;


/**
 * Interface ConnectionInterface
 * @package Jan\Component\Database\Contract
*/
interface ConnectionInterface
{

     /**
      * @return mixed
     */
     public function beginTransaction();



     /**
      * @return mixed
     */
     public function rollback();



     /**
      * @return mixed
     */
     public function commit();



     /**
      * get last insert id
      * @return int
     */
     public function getLastInsertId(): int;



     /**
      * transaction
      * @param Closure $callback
     */
     public function transaction(Closure $callback);



     /**
      * get connection status
      * @return bool
     */
     public function getStatus(): bool;



     /**
      * get connection query
      * @return QueryInterface
     */
     public function getQuery(): QueryInterface;




     /**
      * get connection query builder
      * @return SQLQueryBuilder
     */
     public function getQueryBuilder(): SQLQueryBuilder;




     /**
      * @param string $sql
      * @return mixed
     */
     public function exec(string $sql);




     /**
      * @param string $sql
      * @param array $params
      * @return QueryInterface
     */
     public function query(string $sql, array $params = []): QueryInterface;




     /**
      * Close connection
      *
      * @return mixed
     */
     public function close();
}