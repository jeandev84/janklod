<?php
namespace Jan\Component\Database;


use Jan\Component\Database\Contract\ConnectionInterface;
use Jan\Component\Database\Contract\ManagerInterface;


/**
 * Trait ConnectorTrait
 *
 * @package Jan\Component\Database
*/
trait ConnectionTrait
{


    /**
     * @var ManagerInterface
    */
    protected $manager;



    /**
     * @param ManagerInterface $manager
    */
    public function setManager(ManagerInterface $manager)
    {
         $this->manager    = $manager;
    }


    /**
     * @return ConnectionInterface
    */
    public function getConnection(): ConnectionInterface
    {
        return $this->manager->getConnection();
    }


    /**
     * @return Configuration
    */
    public function getConfiguration(): Configuration
    {
        return $this->manager->getConfiguration();
    }


    /**
     * @return Contract\SQLQueryBuilder
    */
    public function getQueryBuilder()
    {
        return $this->getConnection()->getQueryBuilder();
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
     * @return mixed
    */
    public function closeConnection()
    {
        $this->getConnection()->close();
    }
}