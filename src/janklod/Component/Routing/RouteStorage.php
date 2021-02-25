<?php
namespace Jan\Component\Routing;


/**
 * Class RouteResource
 * @package Jan\Component\Routing
*/
class RouteStorage
{


     /**
      * @var array
     */
     protected $resources = [];



     /**
      * @var array
     */
     protected static $resourceItems = [
         'GET' => [
             ['', 'index', 'list'],
             ['/{id}', 'show', 'show'],
             ['/{id}/restore', 'restore', 'restore'],
         ],
         'GET|POST' => [
             ['/new', 'new', 'new'],
             ['/{id}/edit', 'edit', 'edit'],
         ],
         'DELETE' => [
             ['/{id}/delete', 'delete', 'delete'],
         ]
     ];



     /**
      * @return string[]
     */
     public static function getResourceSingularActions(): array
     {
          return ['show', 'new', 'edit', 'delete', 'restore'];
     }


     /**
      * @param $pathPrefix
      * @param $controllerClass
      * @return array
     */
     public static function makeResourceComponents($pathPrefix, $controllerClass): array
     {
         $resourceComponents = [];

         foreach (static::$resourceItems as $methods => $routes)
         {
             foreach ($routes as $routeItems)
             {
                 list($pathSuffix, $action, $name) = $routeItems;
                 $lastLetter = substr($pathPrefix, -1); // get last letter of string

                 if($lastLetter === 's' && \in_array($action, static::getResourceSingularActions())) {
                     $pathPrefix = str_replace($lastLetter, '', $pathPrefix);
                 }

                 $name = trim($pathPrefix, '/') . '.' . $name;

                 $resourceComponents[] = [$methods, $pathPrefix. $pathSuffix, $action, $name];
             }
         }

         return $resourceComponents;
     }


     /**
      * @param string $controller
      * @param array $resourceItems
     */
     public function add(string $controller, array $resourceItems)
     {
          $this->resources[$controller] = $resourceItems;
     }



     /**
      * @param string $controller
      * @return bool
     */
     public function has(string $controller): bool
     {
         return isset($this->resources[$controller]);
     }



     /**
      * @param string $controller
      * @return array|mixed
     */
     public function get(string $controller): array
     {
         return $this->resources[$controller] ?? [];
     }
}