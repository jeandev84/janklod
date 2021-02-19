<?php
namespace Jan\Component\Routing\Traits;


/**
 * Trait RouteTrait
 * @package Jan\Component\Routing\Traits
*/
trait RouteTrait
{

    /**
     * @var array
    */
    protected $options = [];



    /**
     * @var array
     */
    protected $availableOptions = [];



    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
         $this->options = $options;
    }


    /**
     * @return void
    */
    public function removeOptions()
    {
         $this->options = [];
    }


    /**
     * @param array $availableOptions
     */
    public function setAvailableOptions(array $availableOptions)
    {
        $this->availableOptions = $availableOptions;
    }


    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     * @throws \Exception
    */
    public function getOption($key, $default = null)
    {
        foreach (array_keys($this->options) as $index)
        {
            if(! $this->isValidOption($index))
            {
                throw new \Exception(sprintf('%s is not available this param', $index));
            }
        }

        return $this->options[$key] ?? $default;
    }



    /**
     * @param $index
     * @return bool
    */
    protected function isValidOption($index): bool
    {
        return \in_array($index, $this->availableOptions);
    }
}