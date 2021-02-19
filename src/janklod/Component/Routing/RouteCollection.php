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
      protected static $nameList = [];



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
       * @param $name
       * @param Route $route
      */
      public static function nameList($name, Route $route)
      {
           static::$nameList[$name] = $route;
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
      public static function getNameList(): array
      {
           return static::$nameList;
      }



      /**
       * @param $name
       * @return bool
      */
      public static function exists($name): bool
      {
           return \array_key_exists($name, static::$nameList);
      }



      /**
       * @param $name
       * @return Route
      */
      public static function retrieve($name): Route
      {
          return static::$nameList[$name];
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