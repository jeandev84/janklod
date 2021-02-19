<?php
namespace Jan\Component\Routing;


/**
 * Class RouteGroup
 * @package Jan\Component\Routing
*/
class RouteGroup
{

     /**
      * @var array
     */
     protected $options = [];


     /**
      * RouteGroup constructor.
      * @param array $options
     */
     public function __construct(array $options)
     {
         $this->options = $options;
     }
}