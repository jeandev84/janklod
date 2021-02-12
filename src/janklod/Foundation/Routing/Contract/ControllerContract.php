<?php
namespace Jan\Foundation\Routing\Contract;


use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Container\Contract\UsableContainer;


/**
 * Interface ControllerContract
 * @package Jan\Foundation\Routing\Contract
*/
interface ControllerContract
{
     public function setContainer(ContainerInterface $container);
}