<?php
namespace Jan\Component\Database\Connection\PDO;


use Jan\Component\Database\Connection\Connection;
use Jan\Component\Database\Contract\QueryInterface;
use Jan\Component\Database\Contract\SQLQueryBuilder;
use PDO;
use PDOException;


/**
 * Class PDOConnection
 * @package Jan\Component\Database\Connection\PDO
*/
class PDOConnection extends Connection
{

        const DEFAULT_PDO_OPTIONS = [
           PDO::ATTR_PERSISTENT => true, // permit to insert/ persist data in to database
           PDO::ATTR_EMULATE_PREPARES => 0,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];


        /**
         * @var
        */
        protected $paginatedQuery;



        /**
         * PDOConnection constructor.
         * @param $dsn
         * @param $username
         * @param $password
         * @param array $options
        */
        public function __construct($dsn, $username, $password, $options = [])
        {
              if (! $this->isConnected()) {

                  try {

                      $pdo = new \PDO(
                          $dsn,
                          $username,
                          $password,
                          array_merge(self::DEFAULT_PDO_OPTIONS, $options)
                      );

                      $this->setConnection($pdo);
                      $this->setQuery(new Query($pdo));
                      $this->setPaginatedQuery(new PaginatedQuery());

                  } catch (PDOException $e) {

                      throw $e;
                  }
              }
        }


        /**
         * @param $key
         * @param $value
        */
        public function setAttribute($key, $value)
        {
            $this->connection->setAttribute($key, $value);
        }


        /**
         * @return bool
        */
        public function isConnected(): bool
        {
            return $this->connection instanceof PDO;
        }




        /**
          * @return bool
        */
        public function getStatus(): bool
        {
            return $this->isConnected();
        }


        /**
         * @param string $sql
         * @return mixed
        */
        public function exec(string $sql)
        {
            if($this->connection->exec($sql))
            {
                 $this->query->log($sql);

                 return true;
            }

            return false;
        }


        /**
         * @return int
        */
        public function getLastInsertId(): int
        {
           return $this->connection->lastInsertId();
        }



       /**
         * @return mixed|void
        */
        public function beginTransaction()
        {
             $this->connection->beginTransaction();
        }


        /**
         * @return mixed|void
        */
        public function rollback()
        {
            $this->connection->rollback();
        }


        /**
         * @return mixed|void
        */
        public function commit()
        {
            $this->connection->commit();
        }


        /**
         * Close connection
         *
         * @return mixed|void
        */
        public function close()
        {
            $this->connection = null;
        }



        /**
          * @return SQLQueryBuilder
          * @throws \Exception
        */
        public function getQueryBuilder(): SQLQueryBuilder
        {
            throw new \Exception('unable query builder for this connection');
        }


        /**
         * Make pagination
        */
        public function paginate(int $currentPage = 1, int $perPage = 3)
        {
             return $this->getPaginatedQuery()->paginate(
                 $this->getQuery(),
                 $currentPage,
                 $perPage
             );
        }
}