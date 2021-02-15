<?php
namespace Jan\Component\Database\Canon\ORM\Repository;


use Jan\Component\Database\Contract\ManagerInterface;


/**
 * Class ServiceRepository
 * @package Jan\Component\Database\Doctrine\ORM\Repository
*/
class ServiceRepository extends EntityRepository
{

    /**
     * ServiceRepository constructor.
     *
     * @param ManagerInterface $manager
     * @param string $entityClass
    */
    public function __construct(ManagerInterface $manager, string $entityClass)
    {
        parent::__construct($manager);
        $this->registerClass($entityClass);
    }
}