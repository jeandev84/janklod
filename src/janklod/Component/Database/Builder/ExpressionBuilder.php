<?php
namespace Jan\Component\Database\Builder;


use Jan\Component\Database\Builder\Support\AbstractQueryBuilder;


/**
 * Class ExpressionBuilder
 * @package Jan\Component\Database\Builder
*/
class ExpressionBuilder
{

    /**
     * @var AbstractQueryBuilder
    */
    protected $queryBuilder;



    /**
     * Expr constructor.
     * @param AbstractQueryBuilder $queryBuilder
    */
    public function __construct(AbstractQueryBuilder $queryBuilder)
    {
         $this->queryBuilder = $queryBuilder;
    }


    /**
     * @param $value1
     * @param $value2
    */
    public function eq($value1, $value2)
    {

    }


    /**
     * @param $value1
     * @param $value2
    */
    public function neq($value1, $value2)
    {

    }


    /**
     * @param $sql
     * @return AbstractQueryBuilder
    */
    public function avg($sql)
    {
        return $this->queryBuilder;
    }


    /**
     * @return AbstractQueryBuilder
    */
    public function count()
    {
        return $this->queryBuilder;
    }


    /**
     * @return AbstractQueryBuilder
    */
    public function andX()
    {
        return $this->queryBuilder;
    }


    /**
     * @return AbstractQueryBuilder
    */
    public function orX()
    {
        return $this->queryBuilder;
    }



    /**
     * @param $value
     * @param array $data
    */
    public function in($value, array $data)
    {

    }


    /**
     * @param $value
     * @param array $data
    */
    public function notIn($value, array $data)
    {

    }


    /**
     * @param $value
    */
    public function isNull($value)
    {

    }
}