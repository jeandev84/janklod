<?php
namespace Jan\Component\Database\Connection\PDO\Driver;


use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Jan\Component\Database\Builder\PostgresQueryBuilder;



/**
 * Class PgsqlConnection
 * @package Jan\Component\Database\Connection\PDO\Driver
*/
class PgsqlConnection extends PDOConnection
{
      public function __construct($dsn, $username, $password, $options = [])
      {
          // $options[PDO::ATTR_AUTOCOMMIT] = 0;
          parent::__construct($dsn, $username, $password, $options);
      }


      /**
       * @return SQLQueryBuilder
     */
     public function getQueryBuilder(): SQLQueryBuilder
     {
         return new PostgresQueryBuilder($this);
     }


}