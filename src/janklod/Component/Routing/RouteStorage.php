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
      * @return string[]
     */
     public static function getResourceActions(): array
     {
         return ['index', 'show',  'new', 'edit', 'delete', 'restore'];
     }


     /**
      * @return array
     */
     public static function getResourceItems(): array
     {
         return [
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
     }



     /**
      * @return string[]
     */
     public static function getResourceSingleActions(): array
     {
          return ['show', 'new', 'edit', 'restore', 'delete'];
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