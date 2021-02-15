<?php
namespace Jan\Component\Container\ServiceProvider;


use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerInterface;


/**
 * Class ServiceProviderTrait
 * @package Jan\Component\Container\ServiceProvider
*/
trait ServiceProviderTrait
{

    /**
     * @var Container
    */
    public $app;



    /**
     * @param Container $app
    */
    public function setContainer(Container $app)
    {
         $this->app = $app;
    }


    /**
     * @return ContainerInterface
    */
    public function getContainer()
    {
        return $this->app;
    }
}