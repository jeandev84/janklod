<?php
namespace Jan\Component\Database;


use ReflectionObject;


/**
 * Trait ObjectMap
 * @package Jan\Component\Database
*/
trait ObjectMap
{


    /**
     * @param object $object
     * @return array
     * @throws Exception
    */
    protected function getProperties($object): array
    {
        if(\is_object($object))
        {
            $mappedProperties = [];
            $reflectedObject = new ReflectionObject($object);

            foreach($reflectedObject->getProperties() as $property)
            {
                $property->setAccessible(true);
                $mappedProperties[$property->getName()] = $property->getValue($object);
            }

            return $mappedProperties;
        }
    }


    /**
     * @param object $object
     * @return array
    */
    protected function getOnlyProperties($object): array
    {
        return array_keys($this->getProperties($object));
    }
}