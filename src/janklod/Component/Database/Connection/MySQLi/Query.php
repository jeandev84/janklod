<?php
namespace Jan\Component\Database\Connection\MySQLi;


use Jan\Component\Database\Contract\QueryInterface;


/**
 * Class Query
 * @package Jan\Component\Database\Connection\MySQLi
*/
class Query implements QueryInterface
{

    public function setSQL($sql): QueryInterface
    {
        // TODO: Implement setSQL() method.
    }

    public function setParams($params): QueryInterface
    {
        // TODO: Implement setParams() method.
    }

    public function getSQL()
    {
        // TODO: Implement getSQL() method.
    }

    public function getParams()
    {
        // TODO: Implement getParams() method.
    }

    public function execute(): QueryInterface
    {
        // TODO: Implement execute() method.
    }

    public function getResult()
    {
        // TODO: Implement getResult() method.
    }

    public function getFirstRecord()
    {
        // TODO: Implement getFirstRecord() method.
    }

    public function getOneRecord()
    {
        // TODO: Implement getOneRecord() method.
    }

    public function getFirstResult()
    {
        // TODO: Implement getFirstResult() method.
    }

    public function getSingleResult()
    {
        // TODO: Implement getSingleResult() method.
    }

    public function log($sql, $params = [])
    {
        // TODO: Implement log() method.
    }
}