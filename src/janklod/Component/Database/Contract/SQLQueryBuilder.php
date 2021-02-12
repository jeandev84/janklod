<?php
namespace Jan\Component\Database\Contract;


/**
 * Interface SQLQueryBuilder
 * @package Jan\Component\Database\Contract
*/
interface SQLQueryBuilder
{

    /**
     * @param mixed ...$args
     * @return SQLQueryBuilder
    */
    public function select(...$args): SQLQueryBuilder;



    /**
     * @param string $condition
     * @return SQLQueryBuilder
    */
    public function where(string $condition): SQLQueryBuilder;




    /**
     * @param int $number
     * @param int $offset
     * @return SQLQueryBuilder
    */
    public function limit(int $number, int $offset = 0): SQLQueryBuilder;




    /**
     * @param string $joinTable
     * @param string $condition
     * @param string $type
     * @return SQLQueryBuilder
    */
    public function join(string $joinTable, string $condition, string $type='INNER'): SQLQueryBuilder;


    /**
     * @param array $attributes
     * @return SQLQueryBuilder
    */
    public function insert(array $attributes): SQLQueryBuilder;



    /**
     * @param array $attributes
     * @return SQLQueryBuilder
    */
    public function update(array $attributes): SQLQueryBuilder;




    /**
     * @param string $table
     * @return SQLQueryBuilder
    */
    public function delete(string $table = ''): SQLQueryBuilder;




    /**
     * @param string|array $column
     * @param string $sort
     * @return SQLQueryBuilder
    */
    public function orderBy($column, string $sort='asc'): SQLQueryBuilder;



    /**
     * @param $column
     * @return SQLQueryBuilder
    */
    public function groupBy($column): SQLQueryBuilder;



    /**
     * @param $condition
     * @return SQLQueryBuilder
    */
    public function having($condition): SQLQueryBuilder;


    /**
     * @param $key
     * @param $value
     * @return SQLQueryBuilder
    */
    public function setParameter($key, $value): SQLQueryBuilder;



    /**
     * @param array $parameters
     * @return SQLQueryBuilder
     */
    public function setParameters(array $parameters): SQLQueryBuilder;


    /**
     * @return string
    */
    public function getSQL(): string;



    /**
     * @return QueryInterface
    */
    public function getQuery(): QueryInterface;
}