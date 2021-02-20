<?php
namespace Jan\Component\Http\Bag;


/**
 * Class ParameterBag
 * @package Jan\Component\Http\Bag
*/
class ParameterBag
{

    /**
     * @var array
    */
    protected $data = [];


    /**
     * ParameterBag constructor.
     * @param array $data
    */
    public function __construct(array $data)
    {
          $this->data = $data;
    }
    

    
    /**
     * @param $key
     * @param $value
     * @return $this
    */
    public function set($key, $value): ParameterBag
    {
        $this->data[$key] = $value;

        return $this;
    }


    /**
     * Determine if param key in data
     *
     * @param $key
     * @return bool
    */
    public function has($key): bool
    {
        return isset($this->data[$key]);
    }


    /**
     * Get parameter from bag
     *
     * @param $key
     * @param null $default
     * @return mixed
    */
    public function get($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    

    /**
     * @return array
    */
    public function all(): array
    {
        return $this->data;
    }
}