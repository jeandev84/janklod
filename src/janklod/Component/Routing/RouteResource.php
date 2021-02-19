<?php
namespace Jan\Component\Routing;


/**
 * Class RouteResource
 * @package Jan\Component\Routing
*/
class RouteResource
{

     /**
      * @return string[]
     */
     public static function getActions(): array
     {
         return ['index', 'show',  'new', 'edit', 'delete', 'restore'];
     }


     /**
      * @param $methods
      * @param $path
      * @param $target
      * @param $name
      * @return array
     */
     public static function getItems($methods, $path, $target, $name): array
     {
         return compact('methods', 'path', 'target', 'name');
     }
}