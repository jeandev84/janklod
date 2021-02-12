<?php
namespace Jan\Component\Database\Connection\PDO\Driver;


use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use Jan\Component\Database\Builder\MysqlQueryBuilder;
use PDO;



/**
 * Class MySQLConnection
 * @package Jan\Component\Database\Connection\PDO\Driver
*/
class MySqlConnection extends PDOConnection
{

      /**
       * MySqlConnection constructor.
       * @param $dsn
       * @param $username
       * @param $password
       * @param array $options
      */
      public function __construct($dsn, $username, $password, $options = [])
      {
           $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
           parent::__construct($dsn, $username, $password, $options);
      }


      /**
       * @return SQLQueryBuilder
      */
      public function getQueryBuilder(): SQLQueryBuilder
      {
          return new MysqlQueryBuilder($this);
      }
}