<?php
namespace Jan\Component\Database\ORM;


use ReflectionObject;


/**
 * Trait ObjectMap
 * @package Jan\Component\Database\ORM
*/
trait ObjectMap
{


    /**
     * @var array
    */
    protected $defaultValues = [];


    /**
     * @param $propertyName
     * @param $value
    */
    protected function setDefaultValues($propertyName, $value)
    {
         $this->defaultValues[$propertyName] = $value;
    }



    /**
     * @param object|null $object
     * @return array
     * @throws Exception
    */
    protected function getProperties($object = null): array
    {
        if(! is_object($object)) {
             $object = $this;
        }

        $mappedProperties = [];
        $reflectedObject = new ReflectionObject($object);

        foreach($reflectedObject->getProperties() as $property)
        {
            $property->setAccessible(true);

            $prop  = $property->getName();
            $value = $property->getValue($object);

            if(\array_key_exists($prop, $this->defaultValues))
            {
                 $value = $this->defaultValues[$prop];
            }

            $mappedProperties[$prop] = $value;
        }

        return $mappedProperties;
    }
}