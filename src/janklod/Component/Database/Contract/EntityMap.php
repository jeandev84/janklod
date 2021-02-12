<?php
namespace Jan\Component\Database\Contract;


/**
 * Interface EntityMap
 * @package Jan\Component\Database\Contract
*/
interface EntityMap
{
    /**
     * @param string $entityClass
     * @return mixed
    */
    public function setEntityClass(string $entityClass);


    /**
     * @return string
    */
    public function getEntityClass(): string;
}