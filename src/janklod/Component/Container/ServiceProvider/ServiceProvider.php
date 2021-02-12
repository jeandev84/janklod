<?php
namespace Jan\Component\Container\ServiceProvider;


/**
 * Class ServiceProvider
 * @package Jan\Component\Container\ServiceProvider
*/
abstract class ServiceProvider
{
      use ServiceProviderTrait;

      abstract public function register();
}