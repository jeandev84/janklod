<?php
namespace Jan\Component\Database;


use ReflectionException;

/**
 * Trait EntityTrait
 *
 * @package Jan\Component\Database
*/
trait EntityTrait
{
    /**
     * @param string $entityClass
     * @return string
     * @throws ReflectionException
    */
    protected function getTableDefaultName(string $entityClass): string
    {
        try {

            $reflectedClass = new \ReflectionClass($entityClass);
            return mb_strtolower($reflectedClass->getShortName().'s');

        } catch (ReflectionException $e) {

            throw $e;
        }
    }
}