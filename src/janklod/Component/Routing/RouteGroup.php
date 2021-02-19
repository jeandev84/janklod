<?php
namespace Jan\Component\Routing;


use Closure;


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
      * @param array $options
     */
     public function setOptions(array $options)
     {
          $this->options = $options;
     }


     /**
      * @param Closure $routeCallback
      * @return false
     */
     public function call(Closure $routeCallback): bool
     {
          if(! empty($this->options))
          {
              $routeCallback();
              $this->options = [];
              return true;
          }

          return false;
     }



     /**
      * @return array
     */
     public function getOptions(): array
     {
         return $this->options;
     }
}