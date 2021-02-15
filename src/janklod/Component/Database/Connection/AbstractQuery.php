<?php
namespace Jan\Component\Database\Connection;


use Jan\Component\Database\Contract\QueryInterface;


/**
 * Class AbstractQuery
 *
 * @package Jan\Component\Database\Connection
*/
abstract class AbstractQuery implements QueryInterface
{

    /**
     * @var string
    */
    protected $sql;



    /**
     * @var array
    */
    protected $params;




    /**
     * @param $sql
     * @return QueryInterface
    */
    public function setSQL($sql): QueryInterface
    {
         $this->sql = trim($sql);

         return $this;
    }


    /**
     * @param array $params
     * @return QueryInterface
    */
    public function setParams(array $params): QueryInterface
    {
         $this->params = $params;

         return $this;
    }



    /**
     * @return mixed|string
    */
    public function getSQL()
    {
        return $this->sql;
    }


    /**
     * @return array|mixed
    */
    public function getParams()
    {
       return $this->params;
    }
}
