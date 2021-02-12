<?php
namespace Jan\Component\Database\Connection\PDO\Driver;


use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Jan\Component\Database\Builder\OracleQueryBuilder;


/**
 * Class OracleConnection
 * @package Jan\Component\Database\Connection\PDO\Driver
*/
class OracleConnection extends PDOConnection
{

    public function getQueryBuilder(): SQLQueryBuilder
    {
         return new OracleQueryBuilder($this);
    }
}