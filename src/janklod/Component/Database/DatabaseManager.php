<?php
namespace Jan\Component\Database;


use Jan\Component\Database\Connection\PDO\PDOConnection;
use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\ManagerInterface;
use PDO;


/**
 * Class DatabaseManager
 * @package Jan\Component\Database
*/
class DatabaseManager implements ManagerInterface
{

     /**
      * @var ConnectionFactory
     */
     protected $factory;


     /**
      * @var mixed
     */
     protected $connection;


     /**
      * @var Configuration
     */
     protected $config;


     /**
      * @var bool
     */
     protected $connected = false;



     /**
      * DatabaseManager constructor.
      *
      * @param array $configParams
      * @throws \Exception
     */
     public function __construct(array $configParams = [])
     {
          if($configParams)
          {
              $this->open($configParams);
          }
     }



     /**
      * @param array $configParams
      * @throws \Exception
     */
     public function open(array $configParams)
     {
          if(! $this->connection)
          {
              $config  = new Configuration($configParams);
              $factory = new ConnectionFactory($config);

              $this->setConfiguration($config);
              $this->setConnection($factory->make());
              $this->setFactory($factory);
          }
     }



     /**
      * @param Configuration $config
      * @return mixed|void
     */
     public function setConfiguration(Configuration $config)
     {
          $this->config = $config;
     }



     /**
      * @param ConnectionInterface $connection
      * @return $this|mixed
     */
     public function setConnection(ConnectionInterface $connection)
     {
           $this->connection = $connection;

           if($connection->getStatus() === true)
           {
                 $this->connected = true;
           }

           return $this;
     }



     /**
      * @return bool
     */
     public function isConnected(): bool
     {
         return $this->connection === true;
     }


     /**
      * @param string|null $key
      * @return Configuration|mixed|null
     */
     public function config(string $key = null): ?Configuration
     {
          if(! $key) {
              return $this->config;
          }

          return $this->config->get($key);
     }


     /**
      * @return PDOConnection
     */
     public function getPDO()
     {
         return $this->getFactory()->getPDO();
     }


     /**
      * @return PDO
     */
     public function pdo(): PDO
     {
         return $this->getPDO()->getConnection();
     }



     /**
      * @param string $driver [driver name]
      * @return ConnectionInterface
      * @throws \Exception
     */
     public function connection($driver = ''): ConnectionInterface
     {
         if(! $driver)
         {
             return $this->getConnection();
         }

         return $this->connection = $this->getFactory()->make($driver);
     }



     /**
      * @return mixed
     */
     public function getConnection(): ConnectionInterface
     {
         return $this->connection;
     }


     /**
      * @return Configuration
     */
     public function getConfiguration(): Configuration
     {
         return $this->config;
     }


     /**
      * @param string $table
      * @return Contract\SQLQueryBuilder
     */
     public function table(string $table)
     {
         $queryBuilder = $this->getConnection()
                              ->getQueryBuilder();
         $table = $this->config->getTableName($table);

         $queryBuilder->table($table);
         return $queryBuilder;
     }



     /**
      * @param $sql
      * @return mixed
     */
     public function exec($sql)
     {
         return $this->getConnection()->exec($sql);
     }



     /**
      * Close connection to database
      *
      * @return void
     */
     public function close()
     {
         if($this->connection)
         {
             $this->getConnection()->close();
         }
     }



     /**
      * @return mixed|void
     */
     public function flush()
     {
          // close connection
          $this->close();
     }


     /**
      * @param ConnectionFactory $factory
     */
     public function setFactory(ConnectionFactory $factory)
     {
         $this->factory = $factory;
     }


     /**
      * @return ConnectionFactory
     */
     public function getFactory(): ConnectionFactory
     {
         return $this->factory;
     }

}
