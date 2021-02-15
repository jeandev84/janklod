<?php
namespace Jan\Component\Database\Connection\MySQLi;


use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Contract\QueryInterface;
use Jan\Component\Database\Contract\SQLQueryBuilder;

/**
 * Class MySQLiConnection
 * @package Jan\Component\Database\Connection\MySQLi
*/
class MySQLiConnection extends Connection
{

    /**
     * MySQLiConnection constructor.
     * @param $hostname
     * @param $username
     * @param $password
     * @param $database
    */
    public function __construct($hostname, $username, $password, $database)
    {
        if(! $this->connection)
        {
            $this->connection = new \mysqli($hostname, $username, $password, $database);
        }
    }

    public function exec(string $sql)
    {
        // TODO: Implement exec() method.
    }

    public function isConnected(): bool
    {
        // TODO: Implement isConnected() method.
    }

    public function close()
    {
        // TODO: Implement close() method.
    }

    public function getQueryBuilder(): SQLQueryBuilder
    {
        // TODO: Implement getQueryBuilder() method.
    }

    public function paginate()
    {
        // TODO: Implement paginate() method.
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
    }

    public function rollback()
    {
        // TODO: Implement rollback() method.
    }

    public function commit()
    {
        // TODO: Implement commit() method.
    }

    public function getQuery(): QueryInterface
    {
        // TODO: Implement getQuery() method.
    }

    public function getLastInsertId(): int
    {
        // TODO: Implement getLastInsertId() method.
    }

    public function getStatus(): bool
    {
        // TODO: Implement getStatus() method.
    }
}