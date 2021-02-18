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
      protected static $namedRoutes = [];



      /**
       * @var array
      */
      protected $routes = [];




      /**
       * @param Route $route
       * @return RouteCollection
      */
      public function add(Route $route): RouteCollection
      {
           $this->routes[] = $route;

           return $this;
      }



      /**
       * @param $name
       * @param Route $route
      */
      public static function setNamedRoute($name, Route $route)
      {
           static::$namedRoutes[$name] = $route;
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
      public static function getNamedRoutes(): array
      {
           return static::$namedRoutes;
      }



      /**
       * @param $name
       * @return bool
      */
      public static function exists($name): bool
      {
           return \array_key_exists($name, static::$namedRoutes);
      }



      /**
       * @param $name
       * @return Route
      */
      public static function retrieve($name): Route
      {
          return static::$namedRoutes[$name];
      }



      /**
       * @param $name
       * @param array $params
       * @return false|string|string[]|null
      */
      public static function generate($name, $params = [])
      {
          if(! static::exists($name))
          {
              return false;
          }

          return static::retrieve($name)->convertParams($params);
      }
}