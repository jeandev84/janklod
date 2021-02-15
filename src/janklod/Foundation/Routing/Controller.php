<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Foundation\Routing\Contract\ControllerContract;



/**
 * Class Controller
 * @package Jan\Foundation\Routing
*/
abstract class Controller implements ControllerContract
{

      use ControllerTrait;


      /**
       * @var Container
      */
      protected $container;



      /**
       * @param ContainerInterface $container
      */
      public function setContainer(ContainerInterface $container)
      {
         $this->container = $container;
      }


      /**
       * @param $key
       * @return mixed
       * @throws \Exception
      */
      public function get($key)
      {
          return $this->container->get($key);
      }

}