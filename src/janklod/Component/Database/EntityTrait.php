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
     * @return string
     * @throws ReflectionException
    */
    protected function getTableDefaultName(): string
    {
        try {

            $reflectedClass = new \ReflectionClass($this->entityClass);
            return mb_strtolower($reflectedClass->getShortName().'s');

        } catch (ReflectionException $e) {

            throw $e;
        }
    }
}