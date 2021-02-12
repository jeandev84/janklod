<?php
namespace Jan\Component\Database\Canon;


use Jan\Component\Database\Contract\EntityManagerInterface;
use Jan\Component\Database\DatabaseManager;



/**
 * Class Manager (like Doctrine)
 * @package Jan\Component\Database\Doctrine
*/
class Manager extends DatabaseManager
{

    /**
     * @var EntityManagerInterface
    */
    protected $entityManager;


    /**
     * Manager constructor.
     * @param array $configParams
     * @throws \Exception
    */
    public function __construct(array $configParams = [])
    {
         parent::__construct($configParams);
    }



    /**
     * @param EntityManagerInterface $entityManager
    */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
         $entityManager->setManager($this);
         $this->entityManager = $entityManager;
    }



    /**
     * get entity manager
     * @return EntityManagerInterface
    */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}