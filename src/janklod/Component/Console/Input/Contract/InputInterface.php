<?php
namespace Jan\Component\Console\Input\Contract;


/**
 * Interface InputInterface
 * @package Jan\Component\Console\Input\Contract
*/
interface InputInterface
{

    /**
     * @return string|null
    */
    public function getFirstArgument();


    /**
     * @return array
    */
    public function getArguments();


    /**
     * @param string $name
     * @return string|null
    */
    public function getArgument(string $name);


    /**
     * @return array
    */
    public function getOptions();


    /**
     * @param string $name
     * @return string|null
    */
    public function getOption(string $name);


    /**
     * @return mixed
    */
    public function validate();
}