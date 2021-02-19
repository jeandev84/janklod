<?php
namespace Jan\Component\Routing;


use Closure;

/**
 * Class RouteGroup
 * @package Jan\Component\Routing
*/
class RouteGroup
{

     const KEY_OPTION_PARAM_PATH_PREFIX  = 'path.prefix';
     const KEY_OPTION_PARAM_NAMESPACE    = 'namespace';
     const KEY_OPTION_PARAM_NAME_PREFIX  = 'name.prefix';


     const OPTION_PARAM_PATH_PREFIX      = 'prefix';
     const OPTION_PARAM_NAMESPACE        = 'namespace';
     const OPTION_PARAM_MIDDLEWARE       = 'middleware';
     const OPTION_PARAM_NAME_PREFIX      = 'name';



     /**
      * @var array
     */
     protected $options = [];



     /**
      * RouteGroup constructor.
     */
     public function __construct()
     {

     }


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
      * @param $key
      * @param null $default
      * @return mixed|null
     */
     public function getOption($key, $default = null)
     {
         return $this->options[$key] ?? $default;
     }
}