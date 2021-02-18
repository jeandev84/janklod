<?php
namespace Jan\Component\Helper\Collection;


/**
 * Class ArrayCollection
 * @package Jan\Component\Helper\Collection
*/
class ArrayCollection implements \ArrayAccess, \Iterator
{

    /** @var array  */
    protected $items = [];


    /**
     * ArrayCollection constructor.
     * @param array $items
    */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }


    /**
     * @param $key
     * @param $value
    */
    public function add($key, $value)
    {
         $this->items[$key] = $value;
    }


    /**
     * @param $key
     * @return mixed
    */
    public function get($key)
    {
        return $this->items[$key];
    }


    /**
     * @param $key
    */
    public function remove($key)
    {
        unset($this->items[$key]);
    }



    /**
     * Determine if has given param in items
     * @param $key
     * @return bool
    */
    public function contains($key)
    {
        return \in_array($key, $this->items);
    }

    public function current()
    {
        // TODO: Implement current() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function valid()
    {
        // TODO: Implement valid() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function offsetExists($offset)
    {
        return $this->contains($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->add($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}