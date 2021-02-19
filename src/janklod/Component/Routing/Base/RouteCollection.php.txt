<?php
namespace Jan\Component\Routing;


/**
 * Class RouteCollection
 * @package Jan\Component\Routing
*/
class RouteCollection
{

      /**
       * @var array
      */
      protected $routes = [];



      /**
       * @param Route $route
       * @return Route
      */
      public function add(Route $route): Route
      {
           $this->routes[] = $route;

           return $route;
      }




     /**
      * @return array
     */
     public function getRoutes(): array
     {
         return $this->routes;
     }



    /**
     * @return array
     */
    public function getNamedRoutes(): array
    {
        return Route::getNameList();
    }
}