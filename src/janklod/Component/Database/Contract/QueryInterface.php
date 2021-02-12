<?php
namespace Jan\Component\Database\Contract;


/**
 * interface QueryInterface
 *
 * @package Jan\Component\Database\Contract
*/
interface QueryInterface
{


    /**
     * @param $sql
     * @return mixed
    */
    public function setSQL($sql): QueryInterface;



    /**
     * @param array $params
     * @return mixed
    */
    public function setParams(array $params): QueryInterface;




    /**
     * @return mixed
    */
    public function getSQL();




    /**
     * @return mixed
    */
    public function getParams();



    /**
     * @return QueryInterface
    */
    public function execute(): QueryInterface;



    /**
     * Get all result
     *
     * @return mixed
    */
    public function getResult();



    /**
     * Get first result
     *
     * @return mixed
    */
    public function getFirstResult();



    /**
     * Get one result
     *
     * @return mixed
    */
    public function getSingleResult();



    /*
    public function getArrayResult();
    public function getScalarResult();
    public function getSingleScalarResult();
    public function getNullOrOneResult();
    */


    /**
     * @param string $sql
     * @param array $params
     * @return mixed
    */
    public function log($sql, $params = []);

}