<?php
namespace Jan\Component\Database\Contract;


/**
 * Interface ObjectManager
 * @package Jan\Component\Database\Contract
*/
interface ObjectManager
{

    /**
     * @param object $object
     * @return mixed
    */
    public function update($object);



    /**
     * @param object $object
     * @return mixed
    */
    public function persist($object);



    /**
     * @param object $object
     * @return mixed
    */
    public function remove($object);



    /**
     * @return mixed
    */
    public function flush();
}