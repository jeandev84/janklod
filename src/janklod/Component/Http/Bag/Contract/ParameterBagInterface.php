<?php
namespace Jan\Component\Http\Bag\Contract;


/**
 * Interface ParameterBagInterface
 * @package Jan\Component\Http\Bag\Contract
*/
interface ParameterBagInterface
{

    /**
     * ParameterBag constructor.
     * @param array $data
    */
    public function __construct(array $data);



    /**
     * @param $key
     * @param $value
     * @return $this
    */
    public function set($key, $value);



    /**
     * Determine if param key in data
     *
     * @param $key
     * @return bool
    */
    public function has($key): bool;



    /**
     * Get parameter from bag
     *
     * @param $key
     * @param null $default
     * @return mixed
    */
    public function get($key, $default = null);
}