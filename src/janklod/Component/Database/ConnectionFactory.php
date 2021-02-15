<?php
namespace Jan\Component\Database;

use Jan\Component\Database\Connection\Exception\DriverException;
use Jan\Component\Database\Connection\PDO\Driver\MySqlConnection;
use Jan\Component\Database\Connection\PDO\Driver\OracleConnection;
use Jan\Component\Database\Connection\PDO\Driver\PgsqlConnection;
use Jan\Component\Database\Connection\PDO\Driver\SQLiteConnection;
use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Exception\PDODriverException;


/**
 * Class Connection Factory
 *
 * @package Jan\Component\Database
*/
class ConnectionFactory
{

      const TYPE_MYSQL  = 'mysql';
      const TYPE_SQLITE = 'sqlite';
      const TYPE_PGSQL  = 'pgsql';
      const TYPE_ORACLE = 'oci';

      const TYPES_PDO_DRIVERS = [
        self::TYPE_MYSQL,
        self::TYPE_SQLITE,
        self::TYPE_PGSQL,
        self::TYPE_ORACLE,
      ];


      /**
       * @var Configuration
      */
      protected $config;


      /**
       * DatabaseConnection constructor.
       * @param Configuration $config
      */
      public function __construct(Configuration $config)
      {
           $this->config = $config;
      }


      /**
       * @param string $driver
       * @return ConnectionInterface
       * @throws DriverException
      */
      public function make($driver = ''): ConnectionInterface
      {
          $type = $this->getType();

          if($driver)
          {
              $type = $driver;
          }

          $type = mb_strtolower($type);


          if(\in_array($type, self::TYPES_PDO_DRIVERS))
          {
               return $this->getPDO();
          }


          throw new DriverException('Cannot resolve connexion for driver ('. $type .')');
      }



      /**
       * @return PDOConnection
      */
      public function getPDO(): PDOConnection
      {
          $type = $this->getType();

          if(! \in_array($type, \PDO::getAvailableDrivers()))
          {
               throw new PDODriverException('driver ('. $type . ') is not available!');
          }

          switch ($type)
          {
              case self::TYPE_MYSQL:
                  return new MySqlConnection(
                      $this->generateDSN(self::TYPE_MYSQL),
                      $this->config->getUsername(),
                      $this->config->getPassword(),
                      $this->config->getOptions()
                  );
                  break;
              case self::TYPE_PGSQL:
                 // dd($this->generateDSN(self::TYPE_PGSQL));
                  return new PgsqlConnection(
                      $this->generateDSN(self::TYPE_PGSQL),
                      $this->config->getUsername(),
                      $this->config->getPassword(),
                      $this->config->getOptions()
                  );
                  break;
              case self::TYPE_ORACLE:
                  return new OracleConnection(
                      $this->generateDSN(self::TYPE_ORACLE),
                      $this->config->getUsername(),
                      $this->config->getPassword(),
                      $this->config->getOptions()
                  );
                  break;
              case self::TYPE_SQLITE:
                  return new SQLiteConnection(
                      $this->generateDSN(self::TYPE_SQLITE),
                      null,
                      null,
                      $this->config->getOptions()
                  );
                  break;
          }
      }


      /**
       * @param string $driverName
       * @return mixed|null
      */
      protected function getType()
      {
           return $this->config->getDriverName();
      }


      /**
       * @param $driver
       * @return string
      */
      protected function generateDSN($driver): string
      {
         if($driver === self::TYPE_SQLITE)
         {
             return sprintf('%s:%s', $driver, $this->config->getDatabase());
         }

         return sprintf('%s:host=%s;port=%s;dbname=%s;',
             $driver,
             $this->config->getHost(),
             $this->config->getPort(),
             $this->config->getDatabase()
         );
     }
}